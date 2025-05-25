<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class EmployeeAttendanceController extends Controller
{
    public function index()
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

            // Get attendance records for the current month
            $currentMonth = now()->format('m');
            $currentYear = now()->format('Y');
            
            $attendanceRecords = Attendance::where('employee_id', $employeeId)
                ->whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->orderBy('date', 'desc')
                ->get()
                ->map(function ($record) {
                    return [
                        'date' => $record->date->format('Y-m-d'),
                        'status' => 'Present',
                        'check_in' => $record->check_in ? $record->check_in->format('h:i A') : '-',
                        'check_out' => $record->check_out ? $record->check_out->format('h:i A') : '-',
                        'total_hours' => $record->total_hours ?? '-'
                    ];
                });

            // Calculate attendance statistics
            $totalDays = $attendanceRecords->count();
            $presentDays = $attendanceRecords->where('status', 'Present')->count();
            $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

            return view('employee.attendance', compact(
                'assignedCourses',
                'attendanceRecords',
                'presentDays',
                'attendanceRate'
            ));
        } catch (\Exception $e) {
            Log::error('Error loading attendance page', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to load attendance data. Please try again.');
        }
    }

    public function signAttendance(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'date' => 'required|date',
                'time' => 'required',
                'course' => 'required|exists:courses,_id',
                'type' => 'required|in:check_in,check_out'
            ]);

            $employeeId = auth()->user()->_id;
            $date = Carbon::parse($validatedData['date']);
            $time = Carbon::parse($validatedData['time']);

            // Find existing attendance record for this date and course
            $attendance = Attendance::where('employee_id', $employeeId)
                ->where('course_id', $validatedData['course'])
                ->whereDate('date', $date)
                ->first();

            if (!$attendance) {
                // Create new attendance record
                $attendance = new Attendance([
                    'employee_id' => $employeeId,
                    'course_id' => $validatedData['course'],
                    'date' => $date,
                ]);
            }

            if ($validatedData['type'] === 'check_in') {
                // Check if already checked in
                if ($attendance->check_in) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already checked in for this course today.'
                    ], 400);
                }
                $attendance->check_in = $time;
                $message = 'Check-in recorded successfully';
            } else {
                // Check if already checked out
                if ($attendance->check_out) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You have already checked out for this course today.'
                    ], 400);
                }
                // Check if checked in
                if (!$attendance->check_in) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You must check in before checking out.'
                    ], 400);
                }
                $attendance->check_out = $time;
                
                // Calculate total hours
                $checkIn = Carbon::parse($attendance->check_in);
                $checkOut = $time;
                $attendance->total_hours = round($checkOut->diffInMinutes($checkIn) / 60, 2);
                $message = 'Check-out recorded successfully';
            }

            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => $message
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording attendance', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to record attendance: ' . $e->getMessage()
            ], 500);
        }
    }
} 