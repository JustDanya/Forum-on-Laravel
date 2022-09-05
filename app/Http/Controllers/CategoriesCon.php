<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Thread;
use App\Models\Message;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class CategoriesCon extends Controller
{
    public function index()
    {
    	$content = Category::all();
    	return view('categories', compact('content'));
    }

    public function update(Request $request, $id)
    {
    	$category = Category::findOrFail($id);
    	if (Auth::check() && Auth::user()->isAdmin && !is_null($request->name))
    	{
    		$category->name = $request->name;
    		$category->save();
    	}
    	return redirect(route('indexCategory'));
    }

    public function destroy($id)
    {
    	$category = Category::findOrFail($id);
    	if (Auth::check() && Auth::user()->isAdmin)
    	{
    		$threads = Thread::where('category_id', $id)->get();
    		foreach ($threads as $thread)
    		{
    			$messages = Message::where('related_thread', $thread->id)->get();
    			foreach ($messages as $message)
    			{
    				$answers = Answer::where('question', $message->id)->get();
    				foreach ($answers as $answer)
    				{
    					$answer->delete();
    				}
    				$message->delete();
    			}
    			$thread->delete();
    		}
    		$category->delete();
    	}
    	return redirect(route('indexCategory'));
    }

    public function create(Request $request)
    {
    	if (Auth::check() && Auth::user()->isAdmin && !is_null($request->name))
    	{
    		$category = Category::insert([
    			'name' => $request->name 
    		]);
    	}
    	return redirect(route('indexCategory'));
    }
}
