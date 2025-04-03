<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    public function index() {
        return view('index');
    }

    public function getStudents(){
        $students = Student::with(['department', 'grades'])->get();
        return response()->json($students);
    }
}
