<?php

namespace App\Repositories\Dashboard\User;

use DB;
use Hash;
use App\Models\User;
use App\Models\Department;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRepository implements UserInterface
{
    use ImageTrait;
    
    public function getModel()
    {
        return new User();
    }



    public function index($request)
    {
        $query  = $this->getModel()
        ->when($request->first_name != null,function ($q) use($request){
            return $q->where('first_name','like','%'.$request->first_name.'%');
        })
        ->when($request->last_name != null,function ($q) use($request){
            return $q->where('last_name','like','%'.$request->last_name.'%');
        })
        ->when($request->email != null,function ($q) use($request){
            return $q->where('email','like','%'.$request->email.'%');
        })
        ->when($request->mobile != null,function ($q) use($request){
            return $q->where('mobile','like','%'.$request->mobile.'%');
        })
        ->orderBy('id','ASC');

        if(auth()->user()->roles_name == 'Manager')
        {
            if(request()->is('admin/employee'))
            {
                $data = $query->where('created_by', auth()->user()->id)->where('roles_name', 'Employee');
            }
            else
            {
                $data = $query->where('created_by', auth()->user()->id)->where('roles_name', '!=', 'Employee');
            }
        }
        else
        {
            if(request()->is('admin/employee'))
            {
                $data = $query->where('roles_name', 'Employee');
            }
            else
            {
                $data = $query->where('roles_name', '!=', 'Employee'); 
            }
        }
        $data = $data->paginate(config('myConfig.paginationCount'))->appends(request()->query());
        
        if(request()->is('admin/employee'))
        {
            $roles = Role::where('id',3)->get();
        }
        if(request()->is('admin/user'))
        {
            $roles = Role::where('id','!=',3)->get();
        }
        $departments = Department::get(['id','name']);
        
        return view('dashboard.users.index')
        ->with([
            'data'        => $data,
            'roles'       => $roles,
            'departments' => $departments,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'mobile'      => $request->mobile,
        ]);
    }



    public function store($request)
    {
        try {
            $user = User::create([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile'        => $request->mobile,
                'password'      => $request->password,
                'status'        => $request->status,
                'roles_name'    => $request->roles_name,
                'password'      => Hash::make($request->password),
                'created_by'    => auth()->user()->id,
                'salary'        => $request->roles_name == 'Employee' ? $request->salary : 0,
                'department_id' => $request->roles_name == 'Employee' ? $request->department_id : null,
            ]);
            
            //upload photo
            if ($request->photo) {
                $this->uploadMedia($user, 'user', $request->photo);
            }
            
            $user->assignRole($request->input('roles_name'));
            
            if (!$user) {
                session()->flash('error');
                return redirect()->back();
            }

            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    
    
    public function update($request)
    {
        try {
            $user = $this->getModel()->find($request->id);
            $user->update([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'mobile'        => $request->mobile,
                'status'        => $request->status,
                'roles_name'    => $request->roles,
                // 'password'      => Hash::make($request->password),
                'salary'        => $request->roles == 3 ? $request->salary : null,
                'department_id' => $request->roles == 3 ? $request->department_id : null,
                // 'createdBy'     => auth()->user()->id,
            ]);

            //upload photo
            if ($request->photo) {
                $this->uploadMedia($user, 'user', $request->photo);
            }

            DB::table('model_has_roles')->where('model_id',$request->id)->delete();
            $user->assignRole($request->input('roles'));
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy($request)
    {
        try {
            // $related_table = realed_model::where('user_id', $request->id)->pluck('user_id');
            // if($related_table->count() == 0) { 
                $user = User::findOrFail($request->id);
                if (!$user) {
                    session()->flash('error');
                    // return redirect()->back();
                    return response()->json([
                        'status'   => false,
                        'messages' => 'لقد حدث خطأ ما برجاء المحاولة مجدداً',
                    ]);
                }
                //remove old file
                if($user->media)
                {
                    Storage::disk('attachments')->delete('user' . '/' . $user->media->file_name);
                    $user->media->delete();
                }

                $user->delete();
                session()->flash('success');
                // return redirect()->back();
                return response()->json([
                    'status'   => true,
                    'messages' => 'تم الحذف بنجاح',
                ]);
            // } else {
                // session()->flash('canNotDeleted');
                // return redirect()->back();
            // }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
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
