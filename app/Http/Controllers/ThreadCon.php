<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Message;
use App\Models\Answer;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ThreadCon extends Controller
{
	public function index()
    {
    	$active = Thread::where('isClosed', 0)->orderByDesc('created_at')->get();
    	$closed = Thread::where('isClosed', 1)->orderByDesc('created_at')->get();

    	return view('thread', compact('active', 'closed'));
    }

    public function threadsByCategory($category)
    {
    	$active = Thread::where('category_id', $category)->where('isClosed', 0)->orderByDesc('created_at')->get();
    	$closed = Thread::where('category_id', $category)->where('isClosed', 1)->orderByDesc('created_at')->get();

    	return view('thread', compact('active', 'closed'));
    }

    public function create()
    {
    	$new_thread = true;
    	$categories = Category::all();
    	return view('new_msg', compact('new_thread','categories'));
    }

    public function store(Request $request)
    {
    	if (!Auth::check()) return;
    	

        $thread = Thread::insertGetId([
            'title' => $request->title,
            'isClosed' => $request->isClosed,
            'category_id' => $request->category_id,
			'created_at' => date("Y-m-d H:i:s"),
        ]);

        $message = Message::insert([
        	'body' => $request->body,
    		'isMainInThread' => $request->isMainInThread,
    		'related_thread' => $thread,
			'created_at' => date("Y-m-d H:i:s"),
    		'user_id' => Auth::id()
        ]);
        return redirect(route('indexThread'));
    }

    public function close($thread)
    {
		$closing_threadMM = Message::where('user_id', Auth::id())->firstOrFail();
		$closing_thread = Thread::findOrFail($thread);
    	if (!is_null($closing_threadMM) && !is_null($closing_thread))
    	{
    		// dd("not null");
	    	$closing_thread->isClosed = 1;
    	}
    	$closing_thread->save();
		// dd($closing_thread->isClosed);
    	return redirect(route('indexThread'));
    }

    public function save(Request $request, $thread)
    {
		$updated_thread = Thread::findOrFail($thread);
		if (!is_null($request->title))
		{
			$updated_thread->title = $request->title;
			$updated_thread->save();
		}
		return redirect(route('threadView', ['thread' => $thread]));
    }

    public function destroy($id)
    {
        $thread = Thread::findOrFail($id);
        if (Auth::check() && Auth::user()->isAdmin)
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
        return redirect(route('indexThread'));
    }
}
