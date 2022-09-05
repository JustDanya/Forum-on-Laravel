<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;
use App\Models\User;

class Message extends Model
{
	protected $table = 'messages';

	protected $fillable = [
        'body'
    ];

    public function answers()
    {
    	return $this->hasMany(Answer::class, 'question');
    }

    public function questions()
    {
    	return $this->hasMany(Answer::class, 'answers');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    use HasFactory;
}
