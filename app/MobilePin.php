<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MobilePin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pin'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
