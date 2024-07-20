<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->roles_name == 'Manager')
        {
            $managers_count  = \App\Models\User::where('created_by', auth()->user()->id)->where('roles_name', 'Manager')->count();
            $employees_count = \App\Models\User::where('created_by', auth()->user()->id)->where('roles_name', 'Employee')->count();
            $tasks_count     = \App\Models\Task::where('created_by', auth()->user()->id)->count();
        }
        else if(auth()->user()->roles_name == 'Employee')
        {
            $managers_count  = \App\Models\User::where('created_by', auth()->user()->created_by)->where('roles_name', 'Manager')->count();
            $employees_count = \App\Models\User::where('created_by', auth()->user()->created_by)->where('roles_name', 'Employee')->count();
            $tasks_count     = \App\Models\Task::where('employee_id', auth()->user()->id)->count();
        }
        else
        {
            $managers_count  = \App\Models\User::where('roles_name', 'Manager')->count();
            $employees_count = \App\Models\User::where('roles_name', 'Employee')->count();
            $tasks_count     = \App\Models\Task::count();
        }
        
        return view('home',compact('managers_count','employees_count','tasks_count'));
    }
}
