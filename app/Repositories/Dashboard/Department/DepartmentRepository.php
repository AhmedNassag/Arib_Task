<?php

namespace App\Repositories\Dashboard\Department;

use App\Models\User;
use App\Models\Department;
use App\Repositories\Dashboard\BaseRepository;

class DepartmentRepository extends BaseRepository implements DepartmentInterface
{
    public function getModel()
    {
        return new Department();
    }



    public function index($request)
    {
        $data = $this->getModel()
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like', '%'.$request->name.'%');
        })
        ->when($request->from_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '>=', $request->from_date);
        })
        ->when($request->to_date != null,function ($q) use($request){
            return $q->whereDate('created_at', '<=', $request->to_date);
        })
        ->paginate(config('myConfig.paginationCount'))->appends(request()->query());

        return view('dashboard.departments.index')
        ->with([
            'data'      => $data,
            'name'      => $request->name,
            'from_date' => $request->from_date,
            'to_date'   => $request->to_date,
        ]);
    }



    public function destroy($request)
    {
        try {
            $related_table = User::where('department_id', $request->id)->pluck('department_id');
            if($related_table->count() == 0) { 
                $department = $this->getModel()->findOrFail($request->id);
                if (!$department) {
                    session()->flash('error');
                    return redirect()->back();
                }

                $department->delete();
                session()->flash('success');
                return redirect()->back();
            } else {
                session()->flash('canNotDeleted');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function deleteSelected($request)
    {
        try {
            $delete_selected_id = explode(",", $request->delete_selected_id);
            $data = $this->getModel()->whereIn('id', $delete_selected_id)->get();
            foreach($data as $item)
            {
                $related_table = User::where('department_id', $item->id)->pluck('department_id');
                if($related_table->count() == 0) { 
                    $department = $this->getModel()->findOrFail($item->id);
                    if (!$department) {
                        session()->flash('error');
                        return redirect()->back();
                    }

                    $department->delete();
                } else {
                    session()->flash('canNotDeleted');
                    return redirect()->back();
                }
            }
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
