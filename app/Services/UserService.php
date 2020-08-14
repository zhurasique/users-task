<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Http\Request;


class UserService
{
    public function index(){
        $paginate = User::orderBy('updated_at', 'desc')->paginate(7);
        return $paginate;
    }

    public function store(Request $request){
        $request->validate([
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'country_id' => 'required|exists:countries,id'
        ]);

        $user = User::find($id);

        if($user->email != $request->email){
            $request->validate([
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
