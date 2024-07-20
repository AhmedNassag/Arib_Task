<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Role\StoreRequest;
use App\Http\Requests\Dashboard\Role\UpdateRequest;
use App\Repositories\Dashboard\Role\RoleInterface;

class RoleController extends Controller
{
    protected $role;

    function __construct(RoleInterface $role)
    {
        $this->role = $role;
        $this->middleware('permission:عرض الصلاحيات', ['only' => ['index']]);
        $this->middleware('permission:إضافة الصلاحيات', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الصلاحيات', ['only' => ['edit','update']]);
        $this->middleware('permission:حذف الصلاحيات', ['only' => ['destroy','delete']]);
    }
    


    public function index(Request $request)
    {
        return $this->role->index($request);
    }
    


    public function create()
    {
        return $this->role->create();
    }
    


    public function store(StoreRequest $request)
    {
        return $this->role->store($request);
    }



    public function show($id)
    {
        return $this->role->show($id);
    }
    


    public function edit($id)
    {
        return $this->role->edit($id);
    }
    


    public function update(UpdateRequest $request, $id)
    {
        return $this->role->update($request, $id); 
    }
    


    public function destroy($id)
    {
        return $this->role->destroy($id);
    }



    public function delete(Request $request)
    {
        return $this->role->delete($request);
    }
}