<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('manager.course', compact('courses'));
    }

    public function create()
    {
        return view('manager.course-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,draft',
            'category' => 'required|string',
            'materials' => 'nullable|array',
            'materials.*' => 'nullable|file|max:10240' // 10MB max file size
        ]);

        $course = new Course([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'category' => $request->category,
            'enrolled_count' => 0,
            'rating' => 0,
            'created_by' => Auth::user()->name
        ]);

        if ($request->hasFile('materials')) {
            $materials = [];
            foreach ($request->file('materials') as $file) {
                $path = $file->store('course-materials', 'public');
                $materials[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $course->materials = $materials;
        }

        $course->save();

        return redirect()->route('manager.course')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('manager.course-edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,draft',
            'category' => 'required|string',
            'materials' => 'nullable|array',
            'materials.*' => 'nullable|file|max:10240'
        ]);

        $course = Course::findOrFail($id);
        
        $course->title = $request->title;
        $course->description = $request->description;
        $course->status = $request->status;
        $course->category = $request->category;

        if ($request->hasFile('materials')) {
            $materials = $course->materials ?? [];
            foreach ($request->file('materials') as $file) {
                $path = $file->store('course-materials', 'public');
                $materials[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
            $course->materials = $materials;
        }

        $course->save();

        Log::info('Course updated successfully', [
            'course_id' => $id,
            'title' => $course->title,
            'description' => $course->description,
            'status' => $course->status,
            'category' => $course->category
        ]);

        return redirect()->route('manager.course')->with('success', 'Course updated successfully');
    }

    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete course', ['id' => $id]);
            
            $course = Course::findOrFail($id);
            if (!$course) {
                Log::error('Course not found for deletion', ['id' => $id]);
                return redirect()->route('manager.course')->with('error', 'Course not found.');
            }

            if ($course->delete()) {
                Log::info('Course deleted successfully', ['id' => $id]);
                return redirect()->route('manager.course')->with('success', 'Course deleted successfully.');
            }

            Log::error('Failed to delete course', ['id' => $id]);
            return redirect()->route('manager.course')->with('error', 'Failed to delete course. Please try again.');
        } catch (\Exception $e) {
            Log::error('Error in course deletion', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);
            return redirect()->route('manager.course')->with('error', 'Error deleting course: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        
        // Check user role and return appropriate view
        if (auth()->user()->role === 'manager') {
            return view('manager.course-view', compact('course'));
        } else {
            return view('employee.course-view', compact('course'));
        }
    }

    public function storeMaterial(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|max:10240', // 10MB max file size
                'description' => 'nullable|string|max:500',
                'course_id' => 'required|exists:courses,_id'
            ]);

            $course = Course::findOrFail($request->course_id);
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Store the file in the local disk
                $path = $file->store('course-materials', 'public');
                
                $material = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType(),
                    'description' => $request->description,
                    'created_at' => now()->toDateTimeString()
                ];

                $materials = $course->materials ?? [];
                $materials[] = $material;
                $course->materials = $materials;
                $course->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Material uploaded successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No file uploaded'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error uploading material', [
                'error' => $e->getMessage(),
                'course_id' => $request->course_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error uploading material: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteMaterial($courseId, $materialIndex)
    {
        try {
            Log::info('Starting material deletion', [
                'course_id' => $courseId,
                'material_index' => $materialIndex
            ]);

            $course = Course::findOrFail($courseId);
            
            // Get the material to delete
            $materials = $course->materials ?? [];
            Log::info('Current materials', ['materials' => $materials]);

            if (!isset($materials[$materialIndex])) {
                Log::error('Material not found at index', ['index' => $materialIndex]);
                return response()->json([
                    'success' => false,
                    'message' => 'Material not found'
                ], 404);
            }

            $material = $materials[$materialIndex];
            Log::info('Material to delete', ['material' => $material]);

            // Delete the file from storage
            if (isset($material['path'])) {
                Storage::delete($material['path']);
                Log::info('File deleted from storage', ['path' => $material['path']]);
            }

            // Create a new array without the deleted material
            $newMaterials = [];
            foreach ($materials as $index => $item) {
                if ($index != $materialIndex) {
                    $newMaterials[] = $item;
                }
            }
            Log::info('New materials array', ['materials' => $newMaterials]);

            // Update the course with the new materials array
            $course->materials = $newMaterials;
            $result = $course->save();

            Log::info('Update result', ['result' => $result]);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Material deleted successfully'
                ]);
            }

            Log::error('Failed to update course', ['course_id' => $courseId]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete material'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error deleting material', [
                'error' => $e->getMessage(),
                'course_id' => $courseId,
                'material_index' => $materialIndex,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error deleting material: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the course assignment page
     */
    public function showAssignCourse($courseId)
    {
        $course = Course::findOrFail($courseId);
        $employees = User::where('role', 'employee')->get();
        
        // Get assigned employees for this course
        $assignedEmployeeIds = $course->assigned_employees ?? [];
        
        // Add isAssigned flag to each employee
        $employees->each(function ($employee) use ($assignedEmployeeIds) {
            $employee->isAssigned = in_array($employee->_id, $assignedEmployeeIds);
        });
        
        return view('manager.assign-course', compact('course', 'employees'));
    }

    /**
     * Assign a course to an employee
     */
    public function assignCourse($courseId, $employeeId)
    {
        try {
            Log::info('Starting course assignment', [
                'course_id' => $courseId,
                'employee_id' => $employeeId
            ]);

            $course = Course::findOrFail($courseId);
            $employee = User::findOrFail($employeeId);
            
            Log::info('Found course and employee', [
                'course' => $course->getArrayCopy(),
                'employee' => $employee->getArrayCopy()
            ]);
            
            // Get current assigned employees and ensure it's an array
            $assignedEmployees = $course->assigned_employees;
            if (!is_array($assignedEmployees)) {
                $assignedEmployees = [];
            }
            
            // Convert employeeId to string for comparison
            $employeeIdStr = (string) $employeeId;
            Log::info('Current assigned employees', [
                'assigned_employees' => $assignedEmployees,
                'employee_id_str' => $employeeIdStr
            ]);
            
            // Check if employee is already assigned
            if (in_array($employeeIdStr, array_map('strval', $assignedEmployees))) {
                Log::info('Employee already assigned to course');
                return redirect()->back()->with('error', 'Employee is already assigned to this course.');
            }
            
            // Add employee to assigned_employees array
            $assignedEmployees[] = $employeeIdStr;
            $course->assigned_employees = $assignedEmployees;
            $course->enrolled_count = count($assignedEmployees);
            
            Log::info('Added employee to assigned_employees array', [
                'new_assigned_employees' => $assignedEmployees,
                'enrolled_count' => $course->enrolled_count
            ]);
            
            if ($course->save()) {
                Log::info('Course saved successfully');
                return redirect()->back()->with('success', 'Course assigned successfully.');
            }
            
            Log::error('Failed to save course after assignment');
            return redirect()->back()->with('error', 'Failed to assign course. Please try again.');
        } catch (\Exception $e) {
            Log::error('Error assigning course', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'course_id' => $courseId,
                'employee_id' => $employeeId
            ]);
            return redirect()->back()->with('error', 'Failed to assign course. Please try again.');
        }
    }

    /**
     * Remove a course assignment from an employee
     */
    public function removeCourseAssignment($courseId, $employeeId)
    {
        try {
            $course = Course::findOrFail($courseId);
            
            // Get current assigned employees
            $assignedEmployees = $course->assigned_employees;
            if (!is_array($assignedEmployees)) {
                $assignedEmployees = [];
            }
            
            // Remove the employee from the array
            $assignedEmployees = array_diff($assignedEmployees, [(string) $employeeId]);
            
            // Update the course
            $course->assigned_employees = $assignedEmployees;
            $course->enrolled_count = count($assignedEmployees);
            
            if ($course->save()) {
                Log::info('Course assignment removed successfully', [
                    'course_id' => $courseId,
                    'employee_id' => $employeeId,
                    'enrolled_count' => $course->enrolled_count
                ]);
                return redirect()->back()->with('success', 'Course assignment removed successfully.');
            }
            
            Log::error('Failed to remove course assignment');
            return redirect()->back()->with('error', 'Failed to remove course assignment. Please try again.');
        } catch (\Exception $e) {
            Log::error('Error removing course assignment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'course_id' => $courseId,
                'employee_id' => $employeeId
            ]);
            return redirect()->back()->with('error', 'Failed to remove course assignment. Please try again.');
        }
    }

    /**
     * Show courses for employee view
     */
    public function employeeCourses()
    {
        try {
            $employeeId = auth()->user()->_id;
            
            // Get all courses
            $allCourses = Course::all();
            
            // Filter assigned courses for this employee
            $assignedCourses = collect($allCourses)->filter(function ($course) use ($employeeId) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                return in_array((string) $employeeId, array_map('strval', $assignedEmployees));
            });
            
            // Get unassigned courses
            $unassignedCourses = collect($allCourses)->filter(function ($course) use ($employeeId) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                return !in_array((string) $employeeId, array_map('strval', $assignedEmployees));
            });
            
            return view('employee.courses', compact('assignedCourses', 'unassignedCourses'));
        } catch (\Exception $e) {
            Log::error('Error loading employee courses', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to load courses. Please try again.');
        }
    }

    /**
     * Allow an employee to join a course
     */
    public function employeeJoinCourse($id)
    {
        try {
            $course = Course::findOrFail($id);
            $employeeId = (string)auth()->user()->_id;
            $assignedEmployees = $course->assigned_employees ?? [];
            if (in_array($employeeId, array_map('strval', $assignedEmployees))) {
                return redirect()->back()->with('error', 'You have already joined this course.');
            }
            $assignedEmployees[] = $employeeId;
            $course->assigned_employees = $assignedEmployees;
            $course->enrolled_count = count($assignedEmployees);
            $course->save();
            return redirect()->back()->with('success', 'You have successfully joined the course.');
        } catch (\Exception $e) {
            \Log::error('Error joining course', [
                'error' => $e->getMessage(),
                'course_id' => $id,
                'employee_id' => auth()->user()->_id
            ]);
            return redirect()->back()->with('error', 'Failed to join the course. Please try again.');
        }
    }

    /**
     * Allow an employee to unenroll from a course
     */
    public function employeeUnenrollCourse($id)
    {
        try {
            $course = Course::findOrFail($id);
            $employeeId = (string)auth()->user()->_id;
            $assignedEmployees = $course->assigned_employees ?? [];
            $assignedEmployees = array_filter($assignedEmployees, function($eid) use ($employeeId) {
                return (string)$eid !== $employeeId;
            });
            $course->assigned_employees = array_values($assignedEmployees);
            $course->enrolled_count = count($course->assigned_employees);
            
            // Remove completed materials for this employee
            $completedMaterials = $course->completed_materials ?? [];
            if (isset($completedMaterials[$employeeId])) {
                unset($completedMaterials[$employeeId]);
                $course->completed_materials = $completedMaterials;
            }
            
            $course->save();
            return redirect()->back()->with('success', 'You have successfully unenrolled from the course.');
        } catch (\Exception $e) {
            \Log::error('Error unenrolling from course', [
                'error' => $e->getMessage(),
                'course_id' => $id,
                'employee_id' => auth()->user()->_id
            ]);
            return redirect()->back()->with('error', 'Failed to unenroll from the course. Please try again.');
        }
    }

    /**
     * Mark a course material as completed for an employee
     */
    public function markMaterialCompleted($courseId, $materialIndex)
    {
        try {
            $course = Course::findOrFail($courseId);
            $employeeId = (string)auth()->user()->_id;
            
            // Store the current assigned_employees array
            $assignedEmployees = (array) ($course->assigned_employees ?? []);
            
            // Initialize completed_materials if it doesn't exist
            $completedMaterials = (array) ($course->completed_materials ?? []);
            
            if (!isset($completedMaterials[$employeeId])) {
                $completedMaterials[$employeeId] = [];
            }
            
            // Check if material is already completed
            $isCompleted = in_array($materialIndex, (array) $completedMaterials[$employeeId]);
            
            if ($isCompleted) {
                // Remove material from completed list
                $completedMaterials[$employeeId] = array_values(array_diff((array) $completedMaterials[$employeeId], [$materialIndex]));
            } else {
                // Add material to completed list
                $completedMaterials[$employeeId][] = $materialIndex;
            }
            
            // Update both completed_materials and preserve assigned_employees
            $course->completed_materials = $completedMaterials;
            $course->assigned_employees = $assignedEmployees;
            
            if (!$course->save()) {
                throw new \Exception('Failed to save course');
            }
            
            $progress = $this->calculateProgress($course, $employeeId);
            
            return response()->json([
                'success' => true,
                'progress' => $progress
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating material status', [
                'error' => $e->getMessage(),
                'course_id' => $courseId,
                'material_index' => $materialIndex,
                'employee_id' => auth()->user()->_id
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update material status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate progress percentage for an employee in a course
     */
    private function calculateProgress($course, $employeeId)
    {
        $materials = (array) ($course->materials ?? []);
        $totalMaterials = count($materials);
        if ($totalMaterials === 0) {
            return 0;
        }

        $completedMaterials = (array) ($course->completed_materials[$employeeId] ?? []);
        $completedCount = count($completedMaterials);
        
        return round(($completedCount / $totalMaterials) * 100);
    }

    public function employeeProgressOverview()
    {
        try {
            // Get all employees
            $employees = User::where('role', 'employee')->get();
            
            // Get all courses and convert to collection
            $courses = collect(Course::all());
            
            // Process each employee's data
            $processedEmployees = $employees->map(function($employee) use ($courses) {
                $totalProgress = 0;
                $activeCourses = 0;
                $lastActivity = null;
                
                // Get employee's assigned courses
                $assignedCourses = $courses->filter(function($course) use ($employee) {
                    $assignedEmployees = (array) ($course->assigned_employees ?? []);
                    return in_array((string)$employee->_id, array_map('strval', $assignedEmployees));
                });
                
                // Calculate progress for each assigned course
                foreach ($assignedCourses as $course) {
                    $progress = $this->calculateProgress($course, (string)$employee->_id);
                    $totalProgress += $progress;
                    $activeCourses++;
                    
                    // Track last activity from completed materials
                    $completedMaterials = (array) ($course->completed_materials[(string)$employee->_id] ?? []);
                    
                    if (!empty($completedMaterials)) {
                        $materialIndices = array_map('intval', array_keys($completedMaterials));
                        $lastMaterialIndex = !empty($materialIndices) ? max($materialIndices) : null;
                        
                        if ($lastMaterialIndex !== null) {
                            $materials = (array) ($course->materials ?? []);
                            if (isset($materials[$lastMaterialIndex]['created_at'])) {
                                $lastActivity = \Carbon\Carbon::parse($materials[$lastMaterialIndex]['created_at']);
                            }
                        }
                    }
                }
                
                $averageProgress = $activeCourses > 0 ? round($totalProgress / $activeCourses) : 0;
                
                return [
                    'id' => (string)$employee->_id,
                    'name' => $employee->name,
                    'email' => $employee->email,
                    'department' => $employee->department ?? 'Not Assigned',
                    'active_courses_count' => $activeCourses,
                    'progress' => $averageProgress,
                    'last_activity' => $lastActivity ? $lastActivity->diffForHumans() : 'No activity'
                ];
            });
            
            // Calculate team statistics
            $totalEmployees = $processedEmployees->count();
            $totalActiveCourses = $processedEmployees->sum('active_courses_count');
            $averageCompletion = $processedEmployees->avg('progress');
            $totalCompletedCourses = $processedEmployees->sum(function($employee) {
                return $employee['active_courses_count'];
            });
            
            return view('manager.team', compact(
                'processedEmployees',
                'totalEmployees',
                'totalActiveCourses',
                'averageCompletion',
                'totalCompletedCourses'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in employee progress overview', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to load employee progress data. Please try again.');
        }
    }

    public function getEmployeeProgress($employeeId)
    {
        try {
            $employee = User::findOrFail($employeeId);
            $courses = collect(Course::all());
            
            // Get employee's assigned courses
            $assignedCourses = $courses->filter(function($course) use ($employeeId) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                return in_array((string)$employeeId, array_map('strval', $assignedEmployees));
            });
            
            // Calculate overall statistics
            $completedCourses = 0;
            $inProgressCourses = 0;
            $totalScore = 0;
            $courseProgress = [];
            
            foreach ($assignedCourses as $course) {
                $progress = $this->calculateProgress($course, (string)$employeeId);
                $totalScore += $progress;
                
                // Get last activity
                $lastActivity = null;
                $completedMaterials = (array) ($course->completed_materials[(string)$employeeId] ?? []);
                
                if (!empty($completedMaterials)) {
                    $materialIndices = array_map('intval', array_keys($completedMaterials));
                    $lastMaterialIndex = !empty($materialIndices) ? max($materialIndices) : null;
                    
                    if ($lastMaterialIndex !== null) {
                        $materials = (array) ($course->materials ?? []);
                        if (isset($materials[$lastMaterialIndex]['created_at'])) {
                            $lastActivity = \Carbon\Carbon::parse($materials[$lastMaterialIndex]['created_at']);
                        }
                    }
                }
                
                // Calculate time spent (this is a placeholder - you might want to implement actual time tracking)
                $timeSpent = count($completedMaterials) * 2; // Assuming 2 hours per material
                
                $courseProgress[] = [
                    'id' => (string)$course->_id,
                    'title' => $course->title,
                    'progress' => $progress,
                    'last_activity' => $lastActivity ? $lastActivity->diffForHumans() : 'No activity',
                    'time_spent' => $timeSpent,
                    'is_completed' => $progress === 100
                ];
                
                if ($progress === 100) {
                    $completedCourses++;
                } else {
                    $inProgressCourses++;
                }
            }
            
            $averageScore = count($assignedCourses) > 0 ? round($totalScore / count($assignedCourses)) : 0;
            
            return view('manager.employee-progress', compact(
                'employee',
                'completedCourses',
                'inProgressCourses',
                'averageScore',
                'courseProgress'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error getting employee progress', [
                'error' => $e->getMessage(),
                'employee_id' => $employeeId,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'Failed to load employee progress data. Please try again.');
        }
    }

    /**
     * Show assignable courses for an employee
     */
    public function showAssignableCourses($employeeId)
    {
        try {
            $employee = User::findOrFail($employeeId);
            $allCourses = Course::all();
            
            // Get courses that are not assigned to this employee
            $assignableCourses = collect($allCourses)->filter(function($course) use ($employeeId) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                return !in_array((string)$employeeId, array_map('strval', $assignedEmployees));
            });

            // Add isAssigned flag to each course
            $assignableCourses->each(function ($course) use ($employeeId) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                $course->isAssigned = in_array((string)$employeeId, array_map('strval', $assignedEmployees));
            });
            
            return view('manager.assign-course', [
                'course' => $employee, // Pass employee as course to maintain view compatibility
                'employees' => $assignableCourses // Pass courses as employees to maintain view compatibility
            ]);
        } catch (\Exception $e) {
            Log::error('Error showing assignable courses', [
                'error' => $e->getMessage(),
                'employee_id' => $employeeId,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to load assignable courses. Please try again.');
        }
    }

    public function courseData()
    {
        try {
            $courses = collect(Course::all())->map(function ($course) {
                $assignedEmployees = (array) ($course->assigned_employees ?? []);
                $completedCount = 0;
                $inProgressCount = 0;
                $totalProgress = 0;

                foreach ($assignedEmployees as $employeeId) {
                    $employee = User::find($employeeId);
                    if ($employee) {
                        // Get completed materials for this employee in this course
                        $completedMaterials = (array) ($course->completed_materials[$employeeId] ?? []);
                        $courseMaterials = (array) ($course->materials ?? []);
                        
                        $progress = count($courseMaterials) > 0 
                            ? (count($completedMaterials) / count($courseMaterials)) * 100 
                            : 0;
                        
                        $totalProgress += $progress;
                        
                        if ($progress == 100) {
                            $completedCount++;
                        } else {
                            $inProgressCount++;
                        }
                    }
                }

                $averageProgress = count($assignedEmployees) > 0 
                    ? round($totalProgress / count($assignedEmployees), 1) 
                    : 0;

                return [
                    '_id' => $course->_id,
                    'title' => $course->title,
                    'status' => $course->status,
                    'enrolled_count' => count($assignedEmployees),
                    'completed_count' => $completedCount,
                    'in_progress_count' => $inProgressCount,
                    'average_progress' => $averageProgress
                ];
            })->map(function ($course) {
                return (object) $course;
            });

            return view('manager.course-data', compact('courses'));
        } catch (\Exception $e) {
            \Log::error('Error in courseData: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load course data.');
        }
    }

    public function courseDataDetails($id)
    {
        try {
            $course = Course::findOrFail($id);
            
            // Cast to array to avoid BSON issues
            $assignedEmployees = (array) $course->assigned_employees;
            
            $enrolledEmployees = [];
            $completedCount = 0;
            $inProgressCount = 0;
            $totalProgress = 0;

            foreach ($assignedEmployees as $employeeId) {
                $employee = User::find($employeeId);
                if ($employee) {
                    // Get completed materials for this employee
                    $completedMaterials = (array) ($course->completed_materials[$employeeId] ?? []);
                    
                    // Get course materials
                    $courseMaterials = (array) ($course->materials ?? []);
                    
                    // Calculate individual progress for this employee
                    $progress = count($courseMaterials) > 0 
                        ? (count($completedMaterials) / count($courseMaterials)) * 100 
                        : 0;
                    
                    $totalProgress += $progress;
                    
                    if ($progress == 100) {
                        $completedCount++;
                    } else {
                        $inProgressCount++;
                    }

                    // Get last activity from completed materials
                    $lastActivity = 'Never';
                    if (!empty($completedMaterials)) {
                        $lastMaterialIndex = max(array_keys($completedMaterials));
                        if (isset($courseMaterials[$lastMaterialIndex]['created_at'])) {
                            $lastActivity = \Carbon\Carbon::parse($courseMaterials[$lastMaterialIndex]['created_at'])->diffForHumans();
                        }
                    }

                    $enrolledEmployees[] = (object)[
                        'name' => $employee->name,
                        'department' => $employee->department,
                        'progress' => round($progress, 1),
                        'is_completed' => $progress == 100,
                        'last_activity' => $lastActivity,
                        'time_spent' => count($completedMaterials) * 2 // Assuming 2 hours per material
                    ];
                }
            }

            $course->enrolled_count = count($assignedEmployees);
            $course->completed_count = $completedCount;
            $course->in_progress_count = $inProgressCount;
            $course->average_progress = count($assignedEmployees) > 0 
                ? round($totalProgress / count($assignedEmployees), 1) 
                : 0;

            return view('manager.course-data-details', compact('course', 'enrolledEmployees'));
        } catch (\Exception $e) {
            \Log::error('Error in courseDataDetails: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load course details.');
        }
    }

    public function generateReport($id)
    {
        try {
            $course = Course::findOrFail($id);
            $assignedEmployees = (array) ($course->assigned_employees ?? []);
            $enrolledEmployees = [];
            $completedCount = 0;
            $inProgressCount = 0;
            $totalProgress = 0;

            foreach ($assignedEmployees as $employeeId) {
                $employee = User::find($employeeId);
                if ($employee) {
                    $completedMaterials = (array) ($course->completed_materials[$employeeId] ?? []);
                    $courseMaterials = (array) ($course->materials ?? []);
                    
                    $progress = count($courseMaterials) > 0 
                        ? (count($completedMaterials) / count($courseMaterials)) * 100 
                        : 0;
                    
                    $totalProgress += $progress;
                    
                    if ($progress == 100) {
                        $completedCount++;
                    } else {
                        $inProgressCount++;
                    }

                    $enrolledEmployees[] = [
                        'name' => $employee->name,
                        'department' => $employee->department,
                        'progress' => round($progress, 1),
                        'is_completed' => $progress == 100,
                        'last_activity' => $employee->last_activity ?? 'Never',
                        'time_spent' => $employee->time_spent ?? 0
                    ];
                }
            }

            $courseData = [
                'title' => $course->title,
                'status' => $course->status,
                'enrolled_count' => count($assignedEmployees),
                'completed_count' => $completedCount,
                'in_progress_count' => $inProgressCount,
                'average_progress' => count($assignedEmployees) > 0 
                    ? round($totalProgress / count($assignedEmployees), 1) 
                    : 0,
                'enrolled_employees' => $enrolledEmployees,
                'generated_at' => now()->format('Y-m-d H:i:s')
            ];

            // Generate PDF using a view with proper configuration
            $pdf = \PDF::loadView('manager.course-report', ['courseData' => $courseData]);
            
            // Set PDF options
            $pdf->setPaper('a4');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isPhpEnabled', true);
            $pdf->setOption('dpi', 150);
            $pdf->setOption('defaultFont', 'Arial');
            
            // Generate the PDF content
            $pdfContent = $pdf->output();
            
            // Return the PDF with proper headers
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="course-report-' . $id . '.pdf"',
                'Content-Length' => strlen($pdfContent),
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error generating course report: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate report: ' . $e->getMessage()
            ], 500);
        }
    }
}
