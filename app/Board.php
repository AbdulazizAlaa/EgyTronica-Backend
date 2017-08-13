<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Board extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'refresh_time', 'last_maintainance',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function components(){
        return $this->hasMany('App\Components');
    }

    public function members(){
        return $this->belongsToMany('App\User', 'members')->withPivot('type');
    }

    public static function board_member_type($board_id, $user_id){
        return DB::table('boards')
                ->where('boards.id', $board_id)
                ->join('members', 'boards.id', '=', 'members.board_id')
                ->where('members.user_id', '=', $user_id)
                ->select('boards.*', 'members.type as m_type', 'members.user_id as m_user_id')
                ->get();

    }
}
