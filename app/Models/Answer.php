<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $table = 'answers';

	protected $fillable = [
        'question',
        'answers'
    ];

    use HasFactory;
}
