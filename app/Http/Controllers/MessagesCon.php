<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Answer;
use App\Models\Thread;
use Illuminate\Support\Facades\Auth;

class MessagesCon extends Controller
{
    public function messagesByThread($thread)
    {
    	$c_thread = Thread::findOrFail($thread);
    	$content = Message::where('related_thread', $thread)->where('isMainInThread', 0)->orderBy('created_at')->
    		with(['answers', 'questions', 'users'])->get();
    	$main = Message::where('related_thread', $thread)->where('isMainInThread', 1)->with(['answers', 'users'])->first();

    	return view('thread_view', compact('content', 'main', 'c_thread'));
    }

    public function create($thread)
    {
    	// dd("ok");
    	$related_thread = $thread;
    	return view('new_msg', compact('related_thread'));
    }

    public function createAnswer($question)
    {
    	$isAnswer = true; 
    	$q_id = Message::findOrFail($question);
    	return view('new_msg', compact('isAnswer', 'q_id'));
    }

    public function store(Request $request)
    {
    	if (!Auth::check()) return;

    	if ($request->question)
    	{
    		$q = Message::findOrFail($request->question);
            $thread = Thread::findOrFail($q->related_thread);
            if ($thread->isClosed) return redirect(route('threadView', ['thread' => $q->related_thread]));
			$message = Message::insertGetId([
	        	'body' => $request->body,
	    		'isMainInThread' => $request->isMainInThread,
	    		'related_thread' => $q->related_thread,
    			'created_at' => date("Y-m-d H:i:s"),
	    		'user_id' => Auth::id()
	        ]);
			$answer = Answer::insert([
				'question' => $request->question,
				'answers' => $message
			]);

            return redirect(route('threadView', ['thread' => $q->related_thread]));
    	}
		else
		{
            $thread = Thread::findOrFail($request->related_thread);
            if ($thread->isClosed)
            return redirect(route('threadView', ['thread' => $request->related_thread]));

	    	$message = Message::insert([
	        	'body' => $request->body,
	    		'isMainInThread' => $request->isMainInThread,
	    		'related_thread' => $request->related_thread,
    			'created_at' => date("Y-m-d H:i:s"),
	    		'user_id' => Auth::id()
	        ]);
            return redirect(route('threadView', ['thread' => $request->related_thread]));
		}
    }

    public function edit($msg)
    {
    	$message = Message::findOrFail($msg);
    	return view('update_msg', compact('message'));
    }

    public function update(Request $request, $msg)
    {
    	$message = Message::findOrFail($msg);
        $thread = Thread::findOrFail($message->related_thread);
    	if (Auth::id() == $message->user_id && !is_null($request->body) && !$thread->isClosed)
    	{
    		$message->body = $request->body;
    		$message->save();
    	}
    	return redirect(route('threadView', ['thread' => $message->related_thread]));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $threadId = $message->related_thread;
        if (Auth::check() && (Auth::user()->isAdmin || Auth::id() == $message->user_id) )
        {
            $answers = Answer::where('question', $message->id)->get();
            $questions = Answer::where('answers', $message->id)->get();
            foreach ($answers as $answer)
            {
                $answer->delete();
            }
            foreach ($questions as $question)
            {
                $question->delete();
            }
            $message->delete();
        }
        return redirect(route('threadView', ['thread' => $threadId]));
    }
}
