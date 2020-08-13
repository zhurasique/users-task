<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'email' => 'sometimes|required|email|unique:users',
            'country_id' => 'required|exists:countries,id'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->country_id = $request->country_id;

        $user->save();
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
        //
    }

    public function destroy($id)
    {
        //
    }
}
