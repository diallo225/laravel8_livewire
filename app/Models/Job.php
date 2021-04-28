<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function scopeOnline($query)
    {
        return $query->where('status', 1);
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function proposals()
    {
        return $this->hasMany('App\Models\Proposal');
    }

    public function isLiked()
    {
        if (auth()->check()) {
            # code...
            return auth()->user()->likes->contains('id',$this->id);
        }

        return auth()->check() ?? auth()->user()->likes->contains('id',$this->id);
    }
}
