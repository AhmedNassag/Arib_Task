<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\Task\TaskInterface;
use App\Http\Requests\Dashboard\Task\StoreRequest;
use App\Http\Requests\Dashboard\Task\UpdateRequest;

class TaskController extends Controller
{
    protected $task;

    public function __construct(TaskInterface $task)
    {
        $this->task = $task;
        $this->middleware('permission:عرض المهمات', ['only' => ['index']]);
        $this->middleware('permission:إضافة المهمات', ['only' => ['store']]);
        $this->middleware('permission:تعديل المهمات', ['only' => ['update']]);
        $this->middleware('permission:حذف المهمات', ['only' => ['destroy','deleteSelected']]);
        $this->middleware('permission:تغيير حالة المهمات', ['only' => ['changeStatus']]);
    }



    public function index(Request $request)
    {
        return $this->task->index($request);
    }



    public function store(StoreRequest $request)
    {
        return $this->task->store($request);
    }



    public function update(UpdateRequest $request)
    {
        return $this->task->update($request);
    }



    public function destroy(Request $request)
    {
        return $this->task->destroy($request);
    }



    public function deleteSelected(Request $request)
    {
        return $this->task->deleteSelected($request);
    }



    public function changeStatus($id)
    {
        return $this->task->changeStatus($id);
    }
}
