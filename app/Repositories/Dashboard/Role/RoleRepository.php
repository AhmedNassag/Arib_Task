<?php

namespace App\Repositories\Dashboard\Role;

use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository implements RoleInterface
{
    public function getModel()
    {
        return new Role();
    }



    public function index($request)
    {
        $data = $this->getModel()
        ->when($request->name != null,function ($q) use($request){
            return $q->where('name','like','%'.$request->name.'%');
        })
        ->orderBy('id','DESC')
        ->paginate(config('myConfig.paginationCount'))->appends(request()->query());

        return view('dashboard.roles.index')
        ->with([
            'data'   => $data,
            'name'   => $request->name,
        ]);
    }



    public function create()
    {
        $permission = Permission::get();
        return view('dashboard.roles.create',compact('permission'));
    }



    public function store($request)
    {
        try{
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            session()->flash('success');
            return redirect()->route('role.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function show($id)
    {
        $role            = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->get();
        return view('dashboard.roles.show',compact('role','rolePermissions'));
    }



    public function edit($id)
    {
        try{
            if ($id == 1 || $id == 2 || $id == 3) {
                session()->flash('error');
                return redirect()->back();
            }
            $role            = Role::find($id);
            $permission      = Permission::get();
            $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
            return view('dashboard.roles.edit',compact('role','permission','rolePermissions'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } 
    }



    public function update($request, $id)
    {
        try{
            if ($id == 1 || $id == 2 || $id == 3) {
                session()->flash('error');
                return redirect()->back();
            }
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));
            return redirect()->route('role.index')->with('success','Role updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function destroy($id)
    {
        try{
            if ($id == 1 || $id == 2 || $id == 3) {
                session()->flash('error');
                return redirect()->back();
            }
            DB::table("roles")->where('id',$id)->delete();
            session()->flash('success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } 
    }
    


    public function delete($request)
    {
        try {
            if ($request->id == 1 || $request->id == 2 || $request->id == 3) {
                session()->flash('error');
                return redirect()->back();
            }
            $role = DB::table("roles")->where('id',$request->id)->delete();
            if (!$role) {
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
