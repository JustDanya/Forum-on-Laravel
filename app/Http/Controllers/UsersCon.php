<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersCon extends Controller
{
    public function show($id)
    {
    	$user  = User::findOrFail($id);
    	return view('user', compact('user'));
    }

    public function changeRole($id)
    {
    	$user = User::findOrFail($id);
    	if (Auth::check() && Auth::user()->isAdmin && Auth::id() != $id)
    	{
    		$user->isAdmin = !$user->isAdmin;
    		$user->save();
    	}
    	return redirect(route('userShow', ['user' => $id]));
    }
}
