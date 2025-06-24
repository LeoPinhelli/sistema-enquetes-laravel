<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = ['title', 'start_at', 'end_at'];

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    public function getStatusAttribute()
    {
        $now = now();
        if ($now < $this->start_at) {
            return 'não iniciada';
        }
        if ($now >= $this->start_at && $now <= $this->end_at) {
            return 'ativa';
        }
        return 'encerrada';
    }

    public function isActive()
    {
        return $this->status === 'ativa';
    }
}
