<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class email_token extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token'
    ];
    //
    public function user(){
        return $this->belongsTo('App\User');
    }
}
