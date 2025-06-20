<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    protected $table = 'conversation_participants';
    public $timestamps = false;
    protected $fillable = ['conversation_id', 'participant_id', 'participant_type'];
}