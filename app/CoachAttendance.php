<?php

namespace App;

use DB;
use App\BaseModel;

class CoachAttendance extends BaseModel
{
    protected $table = 'coach_attendance';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        if ($this->sessionUserType == "player") {
            $this->sessionUserId = auth()->user()->player->id;
        }
    }

    public function baseQuery($coachId)
    {

        $coachAttend = self::select('coach_attendance.id', 'coach_attendance.attendance', 'coach_attendance.absent_type', DB::raw("to_char(coach_attendance.date_time, 'dd/mm/YYYY HH12:MI AM') as date_time"), 'users.name as coach_name')
            ->join('users',  'users.id', '=', 'coach_attendance.coach_id');
        if ($coachId == "") {

            $coachAttend->whereNotNull('coach_id');
        } else {

            $coachAttend->where('coach_id', $coachId);
        }

        return $coachAttend;
    }

    public function coachAttendance($coachId, $column = "", $searchBy = "")
    {

        $sessionUserId = $this->sessionUserId;

        if ($this->sessionUserType == 'coach') {

            $coach_attendance = $this->searchByColumns($coachId, $column, $searchBy);
            $coach_attendance->where('coach_attendance.coach_id', $sessionUserId);
        } else {

            $coach_attendance = $this->searchByColumns($coachId, $column, $searchBy);
        }

        return $coach_attendance->paginate(10);
    }

    private function searchByColumns($coachId, $column, $searchBy)
    {

        $coach_attendance = $this->baseQuery($coachId);

        if ($column == "date_time") {

            $date = \Carbon\Carbon::createFromFormat('d/m/Y', $searchBy)->format('Y-m-d');

            $coach_attendance->where(DB::raw("DATE(coach_attendance.date_time)"), $date);
        } elseif ($column == "coach") {

            $coach_attendance->where('users.name', 'iLIKE', '%' . $searchBy . '%');
        }

        return $coach_attendance;
    }


    public function attendanceGraphsByMonthYear($coachId, $request)
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
            $attendance = self::select("coach_attendance.attendance")
                ->where('coach_attendance.coach_id', $coachId)
                ->where(DB::raw('date(coach_attendance.date_time)'), $year1 . "-" . $month1 . "-" . $i)
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

    public function attendanceGraphsByYear($coachId, $request)
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
                  extract(month from coach_attendance.date_time) as month
                  FROM coach_attendance
                  where coach_id = ?
                  and extract(month from coach_attendance.date_time)=?
                  and extract(year from coach_attendance.date_time)=?
                  group by month
                  order by month";

            $attendanceS = DB::select($sql, [$coachId, $i, $year2]);

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

    public function totalAttendanceGraphsByMonthYear($coachId, $request)
    {


        $month1 = $request->month1;
        $year1 = $request->year1;

        return self::select(
            DB::raw("sum(case when attendance=1 then 1 else 0 end) as present"),
            DB::raw("sum(case when attendance=0 then 1 else 0 end) as absent")
        )
            ->where('coach_id', $coachId)
            ->where(DB::raw('extract(month from date_time)'), $month1)
            ->where(DB::raw('extract(year from date_time)'), $year1)
            ->first();
    }

    public function totalAttendanceGraphsByYear($coachId, $request)
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
            ->where('coach_id', $coachId)
            ->where(DB::raw('extract(year from date_time)'), $year2)
            ->first();
    }
}
