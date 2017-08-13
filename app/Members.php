<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'type'
    ];
}
