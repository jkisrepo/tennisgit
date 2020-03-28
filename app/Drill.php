<?php

namespace App;

use DB;
use App\BaseModel;

class Drill extends BaseModel
{
    protected $table = 'drills';


    public function checkDrillPlayerCoach($coachId, $drillId)
    {

        return DB::table('drill_players')
            ->where('drill_players.id', $drillId)
            ->join('players', 'players.id', '=', 'drill_players.player_id')
            ->where('players.coachid', $coachId)
            ->count() > 0;
    }

    public function checkDrillPlayer($playerId, $drillId)
    {
        return DB::table('drill_players')
            ->where('drill_players.id', $drillId)
            ->where('drill_players.player_id', $playerId)
            ->count() > 0;
    }
}