<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->index();
    }

    public function store(Request $request)
    {
        $this->userService->store($request);
    }

    public function update(Request $request, $id)
    {
        $this->userService->update($request, $id);
    }

    public function destroy($id)
    {
        $this->userService->destroy($id);
    }
}
