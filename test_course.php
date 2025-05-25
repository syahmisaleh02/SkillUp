<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Course;

// Create a new course
$course = new Course();
$course->title = 'Laravel Development';
$course->description = 'Learn Laravel framework from scratch';
$course->status = 'active';
$course->category = 'development';
$course->enrolled_count = 0;
$course->rating = 0;
$course->created_by = 'manager12@gmail.com';

if ($course->save()) {
    echo "Course created successfully!\n";
    echo "Course ID: " . $course->_id . "\n";
} else {
    echo "Failed to create course\n";
} 