<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id_user', 'title', 'body'
    ];

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'id_user', 'id');
    }
}
