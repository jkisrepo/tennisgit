<?php

namespace App;

use DB;
use App\BaseModel;
use Paginate;
use App\Player;
use Carbon\Carbon;


class PlayerAttendance extends BaseModel
{
    protected $table = 'player_attendance';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        if ($this->sessionUserType == "player") {
            $this->sessionUserId = auth()->user()->player->id;
        }
    }


    public function playerCoach($id)
    {

        return $result = Player::select('users.id', 'users.name')
            ->join('users', 'users.id', '=', 'players.coachid')
            ->where('players.id', $id)
            ->first();
    }

    public function baseQuery($playerId)
    {


        $playerAttend = self::select('player_attendance.id', 'player_attendance.attendance', 'player_attendance.absent_type', DB::raw("to_char(player_attendance.date_time, 'dd/mm/YYYY HH12:MI AM') as date_time"), 'users.name as coach_name', 'players.name as player_name')
            ->join('users', 'users.id', '=', 'player_attendance.coach_id')
            ->join('players', 'players.id', '=', 'player_attendance.player_id');

        if ($playerId == "") {


            $playerAttend->whereNotNull('player_id');
        } else {

            $playerAttend->where('player_id', $playerId);
        }

        return $playerAttend;
    }

    public function playerAttendance($playerId, $column = "", $searchBy = "")
    {

        $sessionUserId = $this->sessionUserId;
        $sessionUserType = $this->sessionUserType;

        $player_attendance = $this->searchByColumns($playerId, $column, $searchBy);

        if ($sessionUserType == "player") {

            $player_attendance->where('player_attendance.player_id', $sessionUserId);
        } elseif ($sessionUserType == "coach") {

            $players = Player::where('coachid', $sessionUserId)
                ->select('id')
                ->pluck('id');

            $player_attendance->whereIn('player_attendance.player_id', $players);
        }

        return $player_attendance->paginate(10);
    }


    /**
    *Checks if the coach has authorization to modify the given attendance Id
     */
    public function hasAuth($coachId, $attendanceId)
    {
        return self::where('coach_id', $coachId)
            ->where('id', $attendanceId)
            ->count() > 0;
    }


    private function searchByColumns($playerId, $column, $searchBy)
    {

        $player_attendance = $this->baseQuery($playerId);

        if ($column == "player") {

            $player_attendance->where('players.name', 'iLIKE', '%' . $searchBy . '%');
        } elseif ($column == "coach") {

            $player_attendance->where('users.name', 'iLIKE', '%' . $searchBy . '%');
        } elseif ($column == "date_time") {

            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $searchBy)->format('Y-m-d');
            $player_attendance->where(DB::raw("DATE(player_attendance.date_time)"), $date);
        }

        return $player_attendance;
    }


    public function CheckPlayerWithAttendance($attendanceId, $playerId)
    {

        return self::where('id', $attendanceId)
            ->where('player_id', $playerId)
            ->count() > 0;
    }


    public function attendanceGraphsByMonthYear($playerId, $request)
    {


        $month1 = $request->month1;

        $monthName = substr(date("F", mktime(0, 0, 0, $month1, 10)), 0, 3);

        if ($month1 < 10) {

            $month1 = "0" . $month1;
        }
        $year1 = $request->year1;
        $year2 = $request->year2;

        $monthlLastDay = cal_days_in_month(CAL_GREGORIAN, $month1, $year1);

        $attendanceP = [];
        for ($i = 1; $i <= $monthlLastDay; $i++) {

            if ($i < 10) {

                $i = "0" . $i;
            }
            $attendance = self::select("player_attendance.attendance")
                ->where('player_attendance.player_id', $playerId)
                ->where(DB::raw('date(player_attendance.date_time)'), $year1 . "-" . $month1 . "-" . $i)
                ->first();
            if ($attendance == null) {
                $attendance = new \stdClass();
                $attendance->attendance = null;
            }
            $date = $i . " " . $monthName;
            $attendance->date = $date;
            array_push($attendanceP, $attendance);
        }

        return $attendanceP;
    }

    public function attendanceGraphsByYear($playerId, $request)
    {


        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;
        $arrayNames = array();
        $value = array();
        $attendanceP = [];
        for ($i = 1; $i < 13; $i++) {

            $monthName = substr(date("F", mktime(0, 0, 0, $i, 10)), 0, 3);
            $sql = "SELECT sum(case when attendance=1 then 1 else 0 end) as present,
                  sum(case when attendance=0 then 1 else 0 end)as absent,
                  extract(month from player_attendance.date_time) as month
                  FROM player_attendance
                  where player_id = ?
                  and extract(month from player_attendance.date_time)=?
                  and extract(year from player_attendance.date_time)=?
                  group by month
                  order by month";

            $attendanceS = DB::select($sql, [$playerId, $i, $year2]);

            if ($attendanceS == null) {
                $attendance = new \stdClass();
                $attendance->present = "0";
                $attendance->absent = "0";
                $month = substr(date("F", mktime(0, 0, 0, $i, 10)), 0, 3);
                $attendance->month = $month;
            } else {

                $attendance = new \stdClass();
                $attendance->present = $attendanceS[0]->present;
                $attendance->absent =  $attendanceS[0]->absent;
                $attendance->month =   $monthName;
            }


            array_push($attendanceP, $attendance);
        }
        return $attendanceP;
    }

    public function totalAttendanceGraphsByMonthYear($playerId, $request)
    {


        $month1 = $request->month1;
        $year1 = $request->year1;

        return self::select(
            DB::raw("sum(case when attendance=1 then 1 else 0 end) as present"),
            DB::raw("sum(case when attendance=0 then 1 else 0 end) as absent")
        )
            ->where('player_id', $playerId)
            ->where(DB::raw('extract(month from date_time)'), $month1)
            ->where(DB::raw('extract(year from date_time)'), $year1)
            ->first();
    }

    public function totalAttendanceGraphsByYear($playerId, $request)
    {


        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;
        $arrayNames = array();
        $value = array();
        $attendanceP = [];

        return self::select(
            DB::raw("sum(case when attendance=1 then 1 else 0 end) as present"),
            DB::raw("sum(case when attendance=0 then 1 else 0 end) as absent")
        )
            ->where('player_id', $playerId)
            ->where(DB::raw('extract(year from date_time)'), $year2)
            ->first();
    }
}
