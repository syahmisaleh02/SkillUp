<?php

namespace App\Models;

use MongoDB\Client;
use MongoDB\BSON\ObjectId;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class Course
{
    protected $collection = 'courses';
    protected $mongoClient;
    protected $db;
    protected $attributes = [];
    protected $fillable = [
        'title',
        'description',
        'status',
        'category',
        'materials',
        'enrolled_count',
        'rating',
        'created_by',
        'assigned_employees',
        'completed_materials'
    ];
    protected $where = [];
    protected $casts = [
        'materials' => 'array',
        'assigned_employees' => 'array',
        'completed_materials' => 'array'
    ];

    public function __construct(array $attributes = [])
    {
        try {
            $this->mongoClient = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
            $this->db = $this->mongoClient->selectDatabase(env('DB_DATABASE', 'skillup'));
            $this->attributes = $attributes;
            
            // If created_by is not set, set it to the current user's name
            if (!isset($this->attributes['created_by']) && auth()->check()) {
                $this->attributes['created_by'] = auth()->user()->name;
            }
            
            Log::info('MongoDB connection established', [
                'database' => env('DB_DATABASE', 'skillup'),
                'collection' => $this->collection
            ]);
        } catch (\Exception $e) {
            Log::error('MongoDB connection failed', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function __get($key)
    {
        if ($key === 'assigned_employees' && isset($this->attributes[$key])) {
            $value = $this->attributes[$key];
            if ($value instanceof \MongoDB\Model\BSONArray) {
                return iterator_to_array($value);
            }
            return is_array($value) ? $value : [];
        }
        if ($key === 'enrolled_count') {
            // Calculate enrolled count based on assigned employees
            $assignedEmployees = $this->assigned_employees;
            return is_array($assignedEmployees) ? count($assignedEmployees) : 0;
        }
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value)
    {
        if ($key === 'assigned_employees') {
            // Ensure we're storing an array of strings
            $this->attributes[$key] = is_array($value) ? array_map('strval', $value) : [];
            // Update enrolled count automatically
            $this->attributes['enrolled_count'] = count($this->attributes[$key]);
        } else {
            $this->attributes[$key] = $value;
        }
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public static function find($id)
    {
        try {
            $instance = new static();
            $result = $instance->db->{$instance->collection}->findOne(['_id' => new ObjectId($id)]);
            
            if ($result) {
                $instance->attributes = (array) $result;
                return $instance;
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Error finding course', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public static function findOrFail($id)
    {
        $course = static::find($id);
        if (!$course) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException("Course not found with ID: {$id}");
        }
        return $course;
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

    public function save()
    {
        try {
            if (!isset($this->attributes['_id'])) {
                // Create new course
                $result = $this->db->{$this->collection}->insertOne($this->attributes);
                $this->attributes['_id'] = $result->getInsertedId();
                return true;
            }

            // Update existing course
            $id = $this->attributes['_id'];
            if (is_string($id)) {
                $id = new ObjectId($id);
            }

            // Ensure assigned_employees is an array
            if (isset($this->attributes['assigned_employees']) && !is_array($this->attributes['assigned_employees'])) {
                $this->attributes['assigned_employees'] = [];
            }

            // Convert assigned_employees to array of strings
            if (isset($this->attributes['assigned_employees'])) {
                $this->attributes['assigned_employees'] = array_map('strval', $this->attributes['assigned_employees']);
            }

            // Prepare update data
            $updateData = [];
            foreach ($this->attributes as $key => $value) {
                if ($key !== '_id') {  // Don't update the _id field
                    $updateData[$key] = $value;
                }
            }

            Log::info('Updating course', [
                'id' => (string) $id,
                'update_data' => $updateData
            ]);

            $result = $this->db->{$this->collection}->updateOne(
                ['_id' => $id],
                ['$set' => $updateData]
            );

            Log::info('Course update result', [
                'id' => (string) $id,
                'modified_count' => $result->getModifiedCount(),
                'matched_count' => $result->getMatchedCount(),
                'assigned_employees' => $this->attributes['assigned_employees'] ?? []
            ]);

            // Consider the update successful if we found the document, even if no changes were made
            return $result->getMatchedCount() > 0;
        } catch (\Exception $e) {
            Log::error('Error saving course', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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
        $instance = new static;
        $cursor = $instance->db->{$instance->collection}->find();
        $courses = [];
        foreach ($cursor as $document) {
            $courses[] = new static((array) $document);
        }
        return $courses;
    }

    public function update(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->fillable)) {
                $this->attributes[$key] = $value;
            }
        }
        return $this->save();
    }

    public function newQuery()
    {
        return $this;
    }

    public static function all()
    {
        try {
            $instance = new static();
            $cursor = $instance->db->{$instance->collection}->find();
            $courses = [];
            foreach ($cursor as $document) {
                $course = new static((array) $document);
                $courses[] = $course;
            }
            return $courses;
        } catch (\Exception $e) {
            Log::error('Error fetching all courses', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    public function get($columns = ['*'])
    {
        return static::getAll();
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
        $instance->where[$column] = $value;
        return $instance;
    }

    public function delete()
    {
        try {
            if (!isset($this->attributes['_id'])) {
                Log::error('Cannot delete course: No _id found');
                return false;
            }

            $id = $this->attributes['_id'];
            if (is_string($id)) {
                $id = new ObjectId($id);
            }

            $result = $this->db->{$this->collection}->deleteOne(['_id' => $id]);
            
            Log::info('Delete operation result', [
                'deleted_count' => $result->getDeletedCount(),
                'id' => (string) $id
            ]);

            return $result->getDeletedCount() > 0;
        } catch (\Exception $e) {
            Log::error('Error deleting course', [
                'error' => $e->getMessage(),
                'id' => isset($this->attributes['_id']) ? (string) $this->attributes['_id'] : 'unknown'
            ]);
            return false;
        }
    }
}
