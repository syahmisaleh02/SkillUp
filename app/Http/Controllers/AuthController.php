<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use MongoDB\Client;

class AuthController extends Controller
{
    protected $apiBaseUrl = 'http://localhost:3000';
    protected $mongoClient;

    public function __construct()
    {
        try {
            $this->mongoClient = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
        } catch (\Exception $e) {
            \Log::error('MongoDB connection failed', ['error' => $e->getMessage()]);
    }
    }

    public function register()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    public function registerSave(Request $request)
    {
        try {
            \Log::info('Starting registration process', ['request' => $request->all()]);

            // Test the connection to Node.js backend with detailed logging
            try {
                \Log::info('Testing connection to Node.js backend', ['url' => $this->apiBaseUrl]);
                
                // First try a simple GET request
                $testResponse = Http::timeout(5)->get($this->apiBaseUrl . '/api/data');
                \Log::info('Test GET response', [
                    'status' => $testResponse->status(),
                    'body' => $testResponse->body()
                ]);

                if (!$testResponse->successful()) {
                    \Log::error('Node.js backend test failed', [
                        'status' => $testResponse->status(),
                        'body' => $testResponse->body(),
                        'headers' => $testResponse->headers()
                    ]);
                    return back()->withErrors([
                        'error' => 'Node.js backend test failed. Status: ' . $testResponse->status() . '. Response: ' . $testResponse->body(),
                    ])->withInput($request->except('password'));
                }

            } catch (\Exception $e) {
                \Log::error('Connection test failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return back()->withErrors([
                    'error' => 'Cannot connect to Node.js backend: ' . $e->getMessage(),
                ])->withInput($request->except('password'));
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,manager,employee'
            ]);

            \Log::info('Data validated successfully', ['email' => $validatedData['email']]);

            // Check if user already exists
            $existingUser = User::where('email', $validatedData['email'])->first();
            if ($existingUser) {
                \Log::warning('Registration failed - email exists', ['email' => $validatedData['email']]);
                return back()->withErrors([
                    'email' => 'Email already registered.',
                ])->withInput($request->except('password'));
            }

            \Log::info('Making API call to Node.js backend', [
                'url' => $this->apiBaseUrl . '/api/auth/register',
                'data' => [
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'role' => $validatedData['role']
                ]
            ]);
            
            // Make API call to Node.js backend with detailed logging
            try {
                $response = Http::timeout(10)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ])
                    ->post($this->apiBaseUrl . '/api/auth/register', [
                        'name' => $validatedData['name'],
                        'email' => $validatedData['email'],
                        'password' => $validatedData['password'],
                        'role' => $validatedData['role']
                    ]);

                \Log::info('API response received', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);

                if ($response->successful()) {
                    $userData = $response->json();
                    
                    \Log::info('Creating user in MongoDB', ['userData' => $userData]);
                    
                    try {
                        // Create user in MongoDB
                        $user = User::create([
                            'name' => $validatedData['name'],
                            'email' => $validatedData['email'],
                            'password' => Hash::make($validatedData['password']),
                            'role' => $validatedData['role'],
                            'api_token' => $userData['token'] ?? null
                        ]);

                        \Log::info('User created successfully in MongoDB', ['userId' => $user->_id]);

                        // Don't log in the user automatically
                        // Instead, redirect to login page with success message
                        return redirect()->route('login')->with('success', 'Registration successful! Please log in to continue.');

                    } catch (\Exception $e) {
                        \Log::error('MongoDB user creation failed', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                }

                \Log::error('API registration failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);

                $errorMessage = $response->json()['message'] ?? $response->body();
                return back()->withErrors([
                    'error' => 'Registration failed: ' . $errorMessage,
                ])->withInput($request->except('password'));

            } catch (\Exception $e) {
                \Log::error('API call failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('Registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return back()->withErrors([
                'error' => 'Registration failed: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine(),
            ])->withInput($request->except('password'));
        }
    }

    public function login()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            \Log::info('Login attempt', ['email' => $credentials['email']]);

            // Find user in database
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                \Log::warning('Login failed - user not found', ['email' => $credentials['email']]);
                return back()->withErrors([
                    'email' => 'User not found. Please register first.',
                ])->onlyInput('email');
            }

            \Log::info('User found', [
                'user_id' => $user->_id,
                'email' => $user->email,
                'has_password' => !empty($user->getAuthPassword())
            ]);

            // Verify password
            $passwordMatch = Hash::check($credentials['password'], $user->getAuthPassword());
            \Log::info('Password verification', [
                'match' => $passwordMatch,
                'stored_hash' => substr($user->getAuthPassword(), 0, 10) . '...', // Log only part of hash for security
                'provided_password' => $credentials['password']
            ]);

            if (!$passwordMatch) {
                \Log::warning('Login failed - invalid password', ['email' => $credentials['email']]);
                return back()->withErrors([
                    'email' => 'Invalid credentials.',
                ])->onlyInput('email');
            }

            // Log in the user
            Auth::login($user);
            
            // Regenerate session ID for security
            $request->session()->regenerate();

            \Log::info('Login successful', [
                'user_id' => $user->_id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Remove any password change suggestions
            $request->session()->forget('password_change_suggestion');

            return $this->redirectBasedOnRole($user);

        } catch (\Exception $e) {
            \Log::error('Login error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'email' => $request->input('email')
            ]);

            return back()->withErrors([
                'email' => 'Login failed. Please try again.',
            ])->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        // Call logout endpoint in Node.js backend if needed
        if (session()->has('api_token')) {
            Http::withToken(session('api_token'))
                ->post($this->apiBaseUrl . '/auth/logout');
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('api_token');

        return redirect()->route('welcome');
    }

    protected function redirectBasedOnRole($user)
    {
        if (!in_array($user->role, ['admin', 'manager', 'employee'])) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Invalid user role.');
        }

        $route = match($user->role) {
            'admin' => 'admin.dashboard',
            'manager' => 'manager.dashboard',
            'employee' => 'employee.dashboard',
            default => 'login'
        };

        return redirect()->route($route);
    }
}
