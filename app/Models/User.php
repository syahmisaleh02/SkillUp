<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $collection = 'users';
    protected $mongoClient;
    protected $db;
    protected $attributes = [];
    protected $fillable = ['name', 'email', 'password', 'role', 'department', 'bio', 'skills'];
    protected $hidden = ['password', 'remember_token'];
    protected $where = [];

    public function __construct(array $attributes = [])
    {
        try {
            $this->mongoClient = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
            $this->db = $this->mongoClient->selectDatabase(env('DB_DATABASE', 'skillup'));
            $this->attributes = $attributes;
            
            Log::info('MongoDB connection established', [
                'database' => env('DB_DATABASE', 'skillup'),
                'collection' => $this->collection
            ]);
        } catch (\Exception $e) {
            Log::error('MongoDB connection failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function getAuthIdentifierName()
    {
        return 'email';
    }

    public function getAuthIdentifier()
    {
        return $this->attributes['email'] ?? null;
    }

    public function getAuthPassword()
    {
        return $this->attributes['password'] ?? null;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function __get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getPasswordAttribute()
    {
        return $this->attributes['password'] ?? null;
    }

    public static function find($id)
    {
        $instance = new static;
        $result = $instance->db->{$instance->collection}->findOne(['_id' => new ObjectId($id)]);
        if ($result) {
            return new static((array) $result);
        }
        return null;
    }

    public static function findOrFail($id)
    {
        $user = static::find($id);
        if (!$user) {
            throw new ModelNotFoundException("User not found with ID: {$id}");
        }
        return $user;
    }

    public function first()
    {
        if (!empty($this->where)) {
            $result = $this->db->{$this->collection}->findOne($this->where);
            if ($result) {
                return new static((array) $result);
            }
        }
        return null;
    }

    public function save(array $options = [])
    {
        try {
            Log::info('Attempting to save user', [
                'user_id' => $this->_id ?? 'new user',
                'attributes' => array_diff_key($this->attributes, ['password' => ''])
            ]);

            if (!isset($this->_id)) {
                Log::error('Cannot save user: No _id found');
                return false;
            }

            // Convert string _id to ObjectId if needed
            $userId = $this->_id;
            if (is_string($this->_id)) {
                $userId = new ObjectId($this->_id);
            }

            // Prepare data for update
            $data = [];
            foreach ($this->fillable as $field) {
                if (isset($this->attributes[$field])) {
                    $data[$field] = $this->attributes[$field];
                }
            }

            Log::info('Updating user data', [
                'user_id' => $userId,
                'update_data' => array_diff_key($data, ['password' => '']),
                'collection' => $this->collection
            ]);

            // Perform the update
            $result = $this->db->{$this->collection}->updateOne(
                ['_id' => $userId],
                ['$set' => $data]
            );

            Log::info('Update operation result', [
                'matched_count' => $result->getMatchedCount(),
                'modified_count' => $result->getModifiedCount(),
                'user_id' => $userId
            ]);

            if ($result->getMatchedCount() > 0) {
                // Verify the update by fetching the updated document
                $updatedDoc = $this->db->{$this->collection}->findOne(['_id' => $userId]);
                if ($updatedDoc) {
                    $this->attributes = (array)$updatedDoc;
                    Log::info('User updated successfully', [
                        'user_id' => $userId,
                        'verified' => true
                    ]);
                    return true;
                }
            }

            Log::warning('No document was updated', [
                'user_id' => $userId,
                'matched_count' => $result->getMatchedCount(),
                'modified_count' => $result->getModifiedCount()
            ]);
            return false;

        } catch (\Exception $e) {
            Log::error('Error saving user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->_id ?? 'unknown'
            ]);
            return false;
        }
    }

    public static function create(array $attributes)
    {
        $instance = new static;
        $result = $instance->db->{$instance->collection}->insertOne($attributes);
        $attributes['_id'] = $result->getInsertedId();
        return new static($attributes);
    }

    public static function getAll()
    {
        try {
            $instance = new static;
            $cursor = $instance->db->{$instance->collection}->find();
            $users = [];
            foreach ($cursor as $document) {
                $user = new static();
                $user->attributes = (array)$document;
                $user->_id = $document->_id;
                $users[] = $user;
            }
            return collect($users);
        } catch (\Exception $e) {
            Log::error('Error fetching all users', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return collect([]);
        }
    }

    public function update(array $attributes = [])
    {
        try {
            if (!isset($this->_id)) {
                Log::error('Cannot update user: No _id found');
                return false;
            }

            $data = [];
            foreach ($this->fillable as $field) {
                if (isset($attributes[$field])) {
                    $data[$field] = $attributes[$field];
                }
            }

            if (empty($data)) {
                Log::warning('No data to update', ['user_id' => $this->_id]);
                return false;
            }

            Log::info('Updating user data', [
                'user_id' => $this->_id,
                'update_data' => $data
            ]);

            $result = $this->db->{$this->collection}->updateOne(
                ['_id' => new ObjectId($this->_id)],
                ['$set' => $data]
            );

            if ($result->getModifiedCount() > 0) {
                // Update local attributes
                foreach ($data as $key => $value) {
                    $this->attributes[$key] = $value;
                }
                Log::info('User updated successfully', [
                    'user_id' => $this->_id,
                    'modified_count' => $result->getModifiedCount()
                ]);
                return true;
            }

            Log::warning('No changes made to user', [
                'user_id' => $this->_id,
                'update_data' => $data
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Error updating user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->_id ?? 'unknown'
            ]);
            return false;
        }
    }

    public function newQuery()
    {
        return $this;
    }

    public function all()
    {
        try {
            $cursor = $this->db->{$this->collection}->find();
            $users = [];
            foreach ($cursor as $document) {
                $user = new static();
                $user->attributes = (array)$document;
                $user->_id = $document->_id;
                $users[] = $user;
            }
            return collect($users);
        } catch (\Exception $e) {
            Log::error('Error fetching all users', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return collect([]);
        }
    }

    public function get($columns = ['*'])
    {
        try {
            $cursor = $this->db->{$this->collection}->find($this->where);
            $users = [];
            foreach ($cursor as $document) {
                $user = new static();
                $user->attributes = (array)$document;
                $user->_id = $document->_id;
                $users[] = $user;
            }
            return collect($users);
        } catch (\Exception $e) {
            Log::error('Error fetching users', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return collect([]);
        }
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public static function where($column, $operator = null, $value = null)
    {
        $instance = new static;
        
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        if ($operator === '=') {
            $instance->where[$column] = $value;
        }

        return $instance;
    }

    public function delete()
    {
        try {
            if (!isset($this->_id)) {
                Log::error('Cannot delete user: No _id found', [
                    'attributes' => $this->attributes
                ]);
                return false;
            }

            // Get the raw _id value
            $userId = $this->_id;
            if (is_array($userId) && isset($userId['$oid'])) {
                $userId = $userId['$oid'];
            } elseif (is_object($userId) && isset($userId->{'$oid'})) {
                $userId = $userId->{'$oid'};
            }

            Log::info('Attempting to delete user from MongoDB', [
                'raw_user_id' => $userId,
                'collection' => $this->collection
            ]);

            // Create a new MongoDB client instance
            $mongoClient = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
            $db = $mongoClient->selectDatabase(env('DB_DATABASE', 'skillup'));
            
            // Perform the delete operation
            $result = $db->{$this->collection}->deleteOne(['_id' => new ObjectId($userId)]);
            
            Log::info('Delete operation result', [
                'deleted_count' => $result->getDeletedCount(),
                'user_id' => $userId,
                'acknowledged' => $result->isAcknowledged()
            ]);

            if ($result->getDeletedCount() > 0) {
                Log::info('User deleted successfully from MongoDB', ['user_id' => $userId]);
                return true;
            }

            Log::warning('No user was deleted from MongoDB', [
                'user_id' => $userId,
                'deleted_count' => $result->getDeletedCount()
            ]);
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting user from MongoDB', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $this->_id ?? 'unknown'
            ]);
            return false;
        }
    }
}

