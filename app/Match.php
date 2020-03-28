<?php

namespace App;

use DB;
use App\BaseModel;
use App\Player;

use Carbon\Carbon;


class Match extends BaseModel
{

    protected $table = 'scheduling';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        if ($this->sessionUserType == "player") {
            $this->sessionUserId = auth()->user()->player->id;
        }
    }

    public function allScheduleDetails($column = "", $searchBy = "")
    {
        $sessionUserType = $this->sessionUserType;
        $sessionUserId = $this->sessionUserId;

        if ($sessionUserType == "player" || $sessionUserType == "parent") {
            return $this->getListByTypePlayer($column, $searchBy,  $sessionUserId);
        } elseif ($sessionUserType == "coach") {
            return $this->getListByTypeCoach($column, $searchBy, $sessionUserId);
        } else {
            return $this->getListByTypeAdmin($column, $searchBy);
        }
    }

    public function scheduleDetails($id)
    {
        return $this->baseQuery()
            ->where('scheduling.id', $id)
            ->first();
    }

    private function baseQuery()
    {
        return self::select(
            'scheduling.id',
            'scheduling.court_id',
            'scheduling.winner_id',
            DB::raw("to_char(scheduling.date_time,'dd/mm/YYYY HH12:MI AM') as date"),
            'p1.name as p1name',
            'p1.id as player1',
            'p2.id as player2',
            'p2.name as p2name',
            'academies.title',
            'academies.id as academy_id',
            'court_types.court_type'
        )
            ->join('players as p1', 'p1.id', '=', 'scheduling.player1')
            ->join('players as p2', 'p2.id', '=', 'scheduling.player2')
            ->join('academies',  'academies.id', '=', 'scheduling.academy_id')
            ->join('court_types', 'court_types.id', '=', 'scheduling.court_id');
    }


    public function academyCourts($id)
    {
        return DB::table('academy_court')
            ->select('academy_court.*', 'court_types.court_type')
            ->join('court_types', 'court_types.id', '=', 'academy_court.court_id')
            ->where('academy_court.academy_id', $id)
            ->get();
    }

    private function getListByTypePlayer($colomn, $searchBy, $sessionUserId)
    {
        $searchSchedules = $this->searchByColumns($colomn, $searchBy);
        return $searchSchedules->where(function ($query) use ($sessionUserId) {
            $query->where('scheduling.player1',  $sessionUserId);
            $query->orWhere('scheduling.player2', $sessionUserId);
        })
            ->orderBy('scheduling.date_time', 'desc')
            ->paginate(10);
    }

    private function getListByTypeCoach($colomn, $searchBy, $sessionUserId)
    {
        $players = Player::where('coachid', $sessionUserId)
            ->select('id')
            ->pluck('id');

        $searchSchedules = $this->searchByColumns($colomn, $searchBy);

        return $searchSchedules->where(function ($query) use ($players) {
            $query->whereIn('p1.id', $players);
            $query->orWhereIn('p2.id', $players);
        })
            ->orderBy('scheduling.date_time', 'desc')
            ->paginate(10);
    }

    private function getListByTypeAdmin($colomn, $searchBy)
    {
        $searchSchedules = $this->searchByColumns($colomn, $searchBy);
        return $searchSchedules->orderBy('scheduling.date_time', 'desc')
            ->paginate(10);;
    }


    private function searchByColumns($column, $searchBy)
    {

        $searchSchedules = $this->baseQuery();

        if ($column == "player") {

            $searchSchedules->where(function ($query) use ($searchBy) {
                $query->where('p1.name', 'ilike', '%' . $searchBy . '%');
                $query->orWhere('p2.name', 'ilike', '%' . $searchBy . '%');
            });
        } elseif ($column == "academy") {

            $searchSchedules->where('academies.title', 'ilike', '%' . $searchBy . '%');
        } elseif ($column == "date_time") {

            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $searchBy)->format('Y-m-d');

            $searchSchedules->where(DB::raw("date(scheduling.date_time)"), $date);
        }

        return $searchSchedules;
    }


    public function hasAuth($coachId, $matchId)
    {
        $match = self::find($matchId);
        if ($match) {
            return $player = Player::where('coachid', $coachId)
                ->where(function ($query) use ($match) {
                    $query->where('id', $match->player1);
                    $query->orWhere('id', $match->player2);
                })
                ->count() > 0;
        }
    }

    public function checkPlayerWithMatch($matchId, $user)
    {

        return self::where('id', $matchId)
            ->where(function ($query) use ($user) {
                $query->where('player1', $user);
                $query->orWhere('player2', $user);
            })
            ->count() > 0;
    }


    public function checkCoachPlayersAttendance($matchId, $playerId, $coachId)
    {

        return self::where('scheduling.id', $matchId)
            ->where(function ($query) use ($playerId) {
                $query->where('scheduling.player1', $playerId);
                $query->orWhere('scheduling.player2', $playerId);
            })
            ->join('players as p1', 'p1.id', '=', 'scheduling.player1')
            ->join('players as p2', 'p2.id', '=', 'scheduling.player2')
            ->where('p1.coachid', $coachId)
            ->count() > 0;
    }
}