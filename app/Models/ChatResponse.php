<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ChatResponse extends Model
{
    use HasFactory;

    protected $table = 'chat_responses';
    protected $fillable = ['id', 'keywords', 'response', 'created_at'];
}
