<?php

namespace App;

use DB;
use App\BaseModel;
use App\Player;
use App\Match;

class Event extends BaseModel
{
    protected $table = 'events';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        if ($this->sessionUserType == "player") {
            $this->sessionUserId = auth()->user()->player->id;
        }
    }

    public function coachPlayers($sessionUserId)
    {

        return DB::table('players')
            ->select('id')
            ->where('coachid', $sessionUserId)
            ->get();
    }
    public function getEventwithType()
    {

        $sessionUserType = $this->sessionUserType;
        $sessionUserId = $this->sessionUserId;

        if ($sessionUserType == "player" || $sessionUserType == "parent") {


            $event = Event::select('events.*', 'scheduling.id as type_id')
                ->join('scheduling', 'scheduling.event_id', '=', 'events.id')
                ->where('events.type', '0')
                ->whereNotNull('scheduling.id')
                ->where(function ($query) use ($sessionUserId) {
                    $query->where('scheduling.player1', $sessionUserId);
                    $query->orWhere('scheduling.player2', $sessionUserId);
                });

            $events = Event::select('events.*', 'drill_players.id as type_id')
                ->join('drill_players', 'drill_players.event_id', '=', 'events.id')
                ->whereNotNull('drill_players.id')
                ->where('events.type', '1')
                ->where('drill_players.player_id', $sessionUserId)

                ->union($event)
                ->get();

            return $events;
        } elseif ($sessionUserType == "coach") {

            $events = Event::all();
            $eventss = [];
            foreach ($events as $key => $event) {


                if ($event->type == "0") {

                    $scheduleDeatils = Match::where('event_id', $event->id)
                        ->first();

                    $count = 0;
                    if ($scheduleDeatils) {
                        $count = Player::where(function ($query) use ($scheduleDeatils) {
                            $query->where('id', $scheduleDeatils['player1']);
                            $query->orWhere('id', $scheduleDeatils['player2']);
                        })
                            ->where('coachid', $sessionUserId)
                            ->count();
                    }

                    if ($count > 0) {
                        $event->type_id = $scheduleDeatils->id;
                    }
                } elseif ($event->type == "1") {

                    $drill_players = DB::table('drill_players')
                        ->where('event_id', $event->id)
                        ->select('id', 'player_id')
                        ->first();
                    $count = 0;
                    if ($drill_players) {
                        $count = Player::where('id', $drill_players->player_id)
                            ->where('coachid', $sessionUserId)
                            ->count();
                    }

                    if ($count > 0) {

                        $event->type_id = $drill_players->id;
                    }
                }

                if ($event->type_id) {

                    $eventss[] = $event;
                }
            }
            return $eventss;
        } else {

            $matchDetails = self::select('events.*', 'scheduling.id as type_id')
                ->join('scheduling', 'scheduling.event_id', '=', 'events.id')
                ->whereNotNull('scheduling.id')
                ->where('events.type', '0')->get();
            $drillsDetail = self::select('events.*', 'drill_players.id as type_id')
                ->where('events.type', '1')
                ->join('drill_players', 'drill_players.event_id', '=', 'events.id')
                ->whereNotNull('drill_players.id')->get();
            return $matchDetails->merge($drillsDetail);
        }
    }


    public function getEventwithTypeMatch($sessionUserType, $sessionUserId)
    {

        $matchDetails = self::select('events.*', 'scheduling.id as type_id')
            ->join('scheduling', 'scheduling.event_id', '=', 'events.id')
            ->whereNotNull('scheduling.id')
            ->where('events.type', '0');

        if ($sessionUserType ==  "coach") {

            $matchDetails->join('players as p1', 'p1.id', '=', 'scheduling.player1')
                ->join('players as p2', 'p2.id', '=', 'scheduling.player2')
                ->where('p1.coachid', $sessionUserId)
                ->get();
        } elseif ($sessionUserType ==  "player") {

            $matchDetails->where(function ($query) use ($sessionUserId) {
                $query->where('scheduling.player1', $sessionUserId);
                $query->orWhere('scheduling.player2', $sessionUserId);
            })
                ->get();
        }

        return $matchDetails->get();
    }

    public function getEventwithTypeDrill($sessionUserType, $sessionUserId)
    {
        $drillsDetail = self::where('events.type', '1')
            ->join('drill_players', 'drill_players.event_id', '=', 'events.id')
            ->whereNotNull('drill_players.id');

        if ($sessionUserType ==  "coach") {
            $drillsDetail->select('events.*', 'drill_players.id as type_id')
                ->join('players', 'players.id', '=', 'drill_players.player_id')
                ->where('players.coachid', $sessionUserId);
        } elseif ($sessionUserType == "player") {
            $drillsDetail->where('drill_players.player_id', $sessionUserId);
        }
        return $drillsDetail->get();
    }
}
