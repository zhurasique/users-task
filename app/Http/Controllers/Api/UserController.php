<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userservice;
    public function __construct(UserService $userService)
    {
        $this->userservice = $userService;
    }

    public function index()
    {
        return $this->userservice->index();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->userservice->store($request);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->userservice->update($request, $id);
    }

    public function destroy($id)
    {
        $this->userservice->destroy($id);
    }
}
