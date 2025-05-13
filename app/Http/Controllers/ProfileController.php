<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use MongoDB\BSON\ObjectId;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            
            Log::info('Starting profile update', [
                'user_id' => $user->_id,
                'current_data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'department' => $user->department
                ]
            ]);

            // Validate the request with optional fields
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->_id,
                'department' => 'nullable|string|in:Development,Design,Marketing,HR',
                'bio' => 'nullable|string|max:1000',
                'current_password' => 'required_with:password|string|min:8',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            // Initialize update data array
            $updateData = [];

            // Only update fields that are provided
            if ($request->filled('name')) {
                $updateData['name'] = $request->name;
            }
            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }
            if ($request->filled('department')) {
                $updateData['department'] = $request->department;
            }
            if ($request->filled('bio')) {
                $updateData['bio'] = $request->bio;
            }

            // Handle password change if current password is provided
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect']);
                }

                if ($request->filled('password')) {
                    $updateData['password'] = Hash::make($request->password);
                }
            }

            Log::info('Validation passed', [
                'user_id' => $user->_id,
                'update_data' => array_diff_key($updateData, ['password' => ''])
            ]);

            // Only proceed with update if there are changes
            if (!empty($updateData)) {
                // Save changes using MongoDB client
                $mongoClient = new \MongoDB\Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
                $collection = $mongoClient->selectDatabase(env('MONGODB_DATABASE', 'skillup'))->users;
                
                $result = $collection->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectId($user->_id)],
                    ['$set' => $updateData]
                );

                if ($result->getMatchedCount() === 0) {
                    Log::error('Failed to update user', [
                        'user_id' => $user->_id,
                        'update_result' => $result
                    ]);
                    throw new \Exception('Failed to update user in database');
                }

                // Refresh the authenticated user data
                $updatedUser = $collection->findOne(['_id' => new \MongoDB\BSON\ObjectId($user->_id)]);
                if ($updatedUser) {
                    $user->attributes = (array)$updatedUser;
                    Auth::setUser($user);
                }

                Log::info('Profile updated successfully', [
                    'user_id' => $user->_id,
                    'updated_data' => array_diff_key($updateData, ['password' => ''])
                ]);

                return back()->with('success', 'Profile updated successfully!');
            }

            return back()->with('info', 'No changes were made to your profile.');
        } catch (\Exception $e) {
            Log::error('Profile update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }
} 