<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $paginate = User::orderBy('updated_at', 'desc')->paginate(7);
        return $paginate;
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
        $this->validate($request, [
            'name' => 'required|string|max:255|min:3',
            'country_id' => 'required|exists:countries,id'
        ]);

        $user = User::find($id);

        if($user->email != $request->email){
            $this->validate($request, [
                'email' => 'sometimes|required|email|unique:users'
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->country_id = $request->country_id;

        $user->save();
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
    }
}
