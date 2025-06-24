<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    protected $fillable = ['poll_id', 'text', 'votes'];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}

