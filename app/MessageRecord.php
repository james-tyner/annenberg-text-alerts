<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageRecord extends Model
{
    protected $fillable = [
      'message', 'mediaUrl', 'sender'
    ];

    protected $table = 'message_history';

    public function sender(){
      return $this->belongsTo('App\User', 'sender', 'id');
    }
}
