<?php

namespace App\Repositories\Dashboard\User;

interface UserInterface
{
    
    public function index($request);
    
    public function store($request);

    public function update($request);

    public function destroy($request);

    public function changeStatus($id);

}
