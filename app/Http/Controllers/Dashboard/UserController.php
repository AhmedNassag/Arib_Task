<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\StoreRequest;
use App\Http\Requests\Dashboard\User\UpdateRequest;
use App\Repositories\Dashboard\User\UserInterface;

class UserController extends Controller
{
    protected $role;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->middleware('permission:عرض المستخدمين', ['only' => ['index']]);
        $this->middleware('permission:إضافة المستخدمين', ['only' => ['store']]);
        $this->middleware('permission:تعديل المستخدمين', ['only' => ['update']]);
        $this->middleware('permission:حذف المستخدمين', ['only' => ['destroy','deleteSelected']]);
        $this->middleware('permission:تغيير حالة المستخدمين', ['only' => ['changeStatus']]);
    }



    public function index(Request $request)
    {
        return $this->user->index($request);
    }
    


    public function store(StoreRequest $request)
    {
        return $this->user->store($request);
    }
    

        
    public function update(updateRequest $request)
    {
        return $this->user->update($request);
    }
    


    public function destroy(Request $request)
    {
        return $this->user->destroy($request);
    }
    


    public function changeStatus($id)
    {
        return $this->user->changeStatus($id);
    }
}