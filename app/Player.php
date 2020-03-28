<?php

namespace App;

use DB;
use App\BaseModel;
use Illuminate\Pagination\Paginator;


class Player extends BaseModel
{
    protected $table = 'players';
    public $timestamps = false;



    public function __construct()
    {
        parent::__construct();
        //NOTE::make sure use proper id when using sessionUserId when userType is player
    }

    public function playerDetails()
    {


        $players = self::select('players.*', 'stance.stance', 'u2.name as cname', 'academies.title')
            ->leftjoin('users as u2', 'u2.id', '=', 'players.coachid')
            ->leftjoin('academies', 'academies.id', '=', 'players.academy_id')
            ->leftjoin('stance', 'stance.id', '=', 'players.stanceid');

        if ($this->sessionUserType == "coach") {

            $players->where('coachid', $this->sessionUserId);
        }

        return $players->paginate(10);
    }

    public function hasAuth($coachId, $playerId)
    {
        return self::where('coachid', $coachId)
            ->where('id', $playerId)
            ->count() > 0;
    }
}
