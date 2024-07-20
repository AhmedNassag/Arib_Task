<?php

namespace App\Repositories\Dashboard\Task;

interface TaskInterface
{

    public function index($request);

    public function store($request);

    public function update($request);

    public function destroy($request);

    public function deleteSelected($request);

    public function changeStatus($id);

}
