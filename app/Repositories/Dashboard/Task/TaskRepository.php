<?php

namespace App\Repositories\Dashboard\Task;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Dashboard\BaseRepository;

class TaskRepository extends BaseRepository implements TaskInterface
{
    public function getModel()
    {
        return new Task();
    }



    public function index($request)
    {
        $query = $this->getModel()
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like', '%'.$request->name.'%');
        })
        ->when($request->description != null,function ($q) use($request){
            return $q->where('description','like', '%'.$request->description.'%');
        })
        ->when($request->status != null,function ($q) use($request){
            return $q->where('status',$request->status);
        })
        ->when($request->employee_id != null,function ($q) use($request){
            return $q->where('employee_id',$request->employee_id);
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        });

        if(auth()->user()->roles_name == 'Manager')
        {
            $data = $query->whereRelation('employee','created_by', auth()->user()->id)->orWhere('created_by', auth()->user()->id);
        }
        if(auth()->user()->roles_name == 'Employee')
        {
            $data = $query->where('employee_id', auth()->user()->id);
        }
        else
        {
           $data = $query; 
        }
        $data = $data->paginate(config('myConfig.paginationCount'))->appends(request()->query());


        if(auth()->user()->roles_name == 'Manager')
        {
            $employees = User::where('roles_name', 'Employee')->where('created_by', auth()->user()->id)->get();
        }
        else if(auth()->user()->roles_name == 'Employee')
        {
            $employees = User::where('roles_name', 'Employee')->where('id', auth()->user()->id)->get();
        }
        else
        {
            $employees = User::where('roles_name', 'Employee')->get();
        }

        return view('dashboard.tasks.index',compact('data','employees'))
        ->with([
            'data'        => $data,
            'employees'   => $employees,
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
            'employee_id' => $request->employee_id,
            'from_date'   => $request->from_date,
            'to_date'     => $request->to_date,
        ]);
    }



    public function changeStatus($id)
    {
        try {
            $task = $this->getModel()->find($id);
            if($task->status == 0)
            {
                $task->update(['status' => 1]);
            }
            else
            {
                $task->update(['status' => 0]);
            }
            if(!$task)
            {
                session()->flash('error');
                return redirect()->back();
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
