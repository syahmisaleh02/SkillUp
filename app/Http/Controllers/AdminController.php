<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
 
class AdminController extends Controller
{
    public function profilepage()
    {
        return view('profile');
    }

    public function users()
    {
        try {
            $users = User::getAll();
            return view('admin.users', ['users' => $users]);
        } catch (\Exception $e) {
            \Log::error('Error fetching users', ['error' => $e->getMessage()]);
            return redirect()->route('admin.dashboard')->with('error', 'Failed to fetch users. Please try again.');
        }
    }

    public function deleteUser($id)
    {
        try {
            \Log::info('Delete request received', [
                'user_id' => $id,
                'request_method' => request()->method(),
                'request_data' => request()->all()
            ]);
            
            // Create a new MongoDB client instance
            $mongoClient = new \MongoDB\Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
            $db = $mongoClient->selectDatabase(env('DB_DATABASE', 'skillup'));
            
            // Perform the delete operation directly
            $result = $db->users->deleteOne(['_id' => new \MongoDB\BSON\ObjectId($id)]);
            
            \Log::info('Delete operation result', [
                'deleted_count' => $result->getDeletedCount(),
                'user_id' => $id,
                'acknowledged' => $result->isAcknowledged()
            ]);

            if ($result->getDeletedCount() > 0) {
                \Log::info('User deleted successfully', ['user_id' => $id]);
                return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
            }

            \Log::warning('No user was deleted', [
                'user_id' => $id,
                'deleted_count' => $result->getDeletedCount()
            ]);
            return redirect()->route('admin.users')->with('error', 'Failed to delete user.');
        } catch (\Exception $e) {
            \Log::error('Error deleting user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $id
            ]);
            return redirect()->route('admin.users')->with('error', 'Failed to delete user. Please try again.');
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role' => 'required|in:admin,manager,employee'
            ]);

            // Create a new MongoDB client instance
            $mongoClient = new \MongoDB\Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
            $db = $mongoClient->selectDatabase(env('DB_DATABASE', 'skillup'));
            
            // Check if email is already taken by another user
            $existingUser = $db->users->findOne([
                'email' => $validatedData['email'],
                '_id' => ['$ne' => new \MongoDB\BSON\ObjectId($validatedData['user_id'])]
            ]);
            
            if ($existingUser) {
                return redirect()->route('admin.users')->with('error', 'Email is already taken by another user.');
            }

            // Perform the update operation
            $result = $db->users->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($validatedData['user_id'])],
                ['$set' => [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'role' => $validatedData['role']
                ]]
            );

            if ($result->getModifiedCount() > 0) {
                return redirect()->route('admin.users')->with('success', 'User updated successfully.');
            }

            return redirect()->route('admin.users')->with('error', 'No changes were made to the user.');
        } catch (\Exception $e) {
            \Log::error('Error updating user', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('admin.users')->with('error', 'Failed to update user. Please try again.');
        }
    }
}