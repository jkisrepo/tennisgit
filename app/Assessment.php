<?php

namespace App;

use DB;
use App\BaseModel;
use Illuminate\Http\Request;

use Carbon\Carbon;

class Assessment extends BaseModel
{
    protected $table = 'assessments';
    public $timestamps = false;
    public $fields = [];

    public $hstoreColumns = [];

    public function setFields($type = "all")
    {
        if ($type == "technical") {
            //Technical fetch column form assessments table starting 0 to 6 hstore column.
            $fields = DB::table('information_schema.columns')
                ->where('table_name', 'assessments')
                ->where('udt_name', 'hstore')
                ->select('column_name')
                ->take(6)
                ->get();
        } elseif ($type == "physical") {
            //Physical fetch column form assessments table after 6 hstore column.
            $fields = DB::table('information_schema.columns')
                ->where('table_name', 'assessments')
                ->where('udt_name', 'hstore')
                ->select('column_name')
                ->take(4)
                ->skip(6)
                ->get();
        } elseif ($type == "all") {
            $fields = DB::table('information_schema.columns')
                ->where('table_name', 'assessments')
                ->where('udt_name', 'hstore')
                ->select('column_name')
                ->get();
        }
        foreach ($fields as $field) {

            $this->fields[] = $field->column_name;
        }

        if ($type == "technical") {

            $fields[] = array_push($this->fields, 'smash');
        }
    }

    public function addAssesment($request)
    {

        $matchid    = $request->matchid;
        $coachid    = $request->coachid;
        $playerid   = $request->playerid;
        $type       = $request->type;

        $currentDate = Carbon::now();

        $currentDateNew = "'" . $currentDate . "'";


        $hstoreArray = $this->getHstoreFieldsFromRequest($request, $type);

        $hstorenew = [];
        foreach ($hstoreArray as $hstore) {
            $hstorenew[] = "'" . $hstore . "'";
        }

        $hstoreFields = implode(', ', $hstorenew);

        if ($type == "technical") {

            $insert = "INSERT into assessments (match_id, coach_id, player_id, date_time, forehand, backhand, serve, return, volley, positioning, smash) values
        (?,?,?,?,$hstoreFields)";
        } elseif ($type == "physical") {

            $insert = "INSERT into assessments (match_id, coach_id, player_id, date_time, strength, power, speed, agility) values
        (?,?,?,?,$hstoreFields)";
        }

        $result = DB::insert($insert, [$matchid, $coachid, $playerid, $currentDateNew]);

        if ($result == true) {
            return $type;
        }
    }

    public function playerAssessments($playerId, $column = "", $searchBy = "")
    {

        $assessments = $this->playerAssessmentBaseQuery($playerId);

        if ($column == !""  && $searchBy == !"") {

            $date = Carbon::createFromFormat('d/m/Y', $searchBy)->format('Y-m-d');

            $assessments = $assessments->where(DB::raw("DATE(s.date_time)"), $date)
                ->paginate(10);
        } else {
            $assessments = $assessments->paginate(10);
        }

        return $assessments;
    }

    public function playerAssessmentsEdit($playerId,  $assessmentId)
    {

        $assessments = $this->playerAssessmentBaseQuery($playerId,  $assessmentId)->first();

        foreach ($this->fields as $key => $field) {


            if ($assessments->{$field} == null) {
                $assessments->{$field} = '{"rating": "", "review": ""}';
            }
        }
        return $assessments;
    }


    public function updateAssessment($id, Request $request)
    {

        $matchid               = $request->matchid;
        $coachid               = $request->coachid;
        $playerid              = $request->playerid;
        $type                  = $request->type;

        $colomnValues = $this->getHstoreFieldsFromRequest($request, $type);


        $fieldsArray = array();
        foreach ($this->fields as $key => $field) {
            $fieldsArray[] = $field . ' = ' . "'" . $colomnValues[$key] . "'";
        }
        $fieldsString = implode(", ", $fieldsArray);

        $update = "UPDATE assessments SET match_id =?, coach_id =?, player_id = ?, $fieldsString where id=?";

        return $result = DB::update($update, [$matchid, $coachid, $playerid, $id]);
    }

    private function getJsonFields($alias = "a")
    {
        $sql = [];
        foreach ($this->fields as $field) {
            $sql[] = 'hstore_to_jsonb(' . $alias . '.' . $field . ') AS ' . $field;
        }
        return implode(", ", $sql);
    }


    private function getHstoreFieldsFromRequest(Request $request, $type)
    {

        if ($type == "technical") {

            $forehand_review       =  $request->forehand_review;
            $forehand_rate         =  $request->forehand_rate;
            $backhand_review       =  $request->backhand_review;
            $backhand_rate         =  $request->backhand_rate;
            $serve_review          =  $request->serve_review;
            $serve_rate            =  $request->serve_rate;
            $return_review         =  $request->return_review;
            $return_rate           =  $request->return_rate;
            $volley_review         =  $request->volley_review;
            $volley_rate           =  $request->volley_rate;
            $positioning_review    =  $request->positioning_review;
            $positioning_rate      =  $request->positioning_rate;
            $smash_review          =  $request->smash_review;
            $smash_rate            =  $request->smash_rate;

            return [
                'review => "' . $forehand_review . '", rating => "' . $forehand_rate . '"',
                'review => "' . $backhand_review . '", rating => "' . $backhand_rate . '"',
                'review => "' . $serve_review . '", rating => "' . $serve_rate . '"',
                'review => "' . $return_review . '", rating => "' . $return_rate . '"',
                'review => "' . $volley_review . '", rating=> "' . $volley_rate . '"',
                'review => "' . $positioning_review . '", rating => "' . $positioning_rate . '"',
                'review => "' . $smash_review . '", rating => "' . $smash_rate . '"'
            ];
        } elseif ($type == "physical") {

            $strength_review = $request->strength_review;
            $strength_rate   = $request->strength_rate;
            $speed_review    = $request->speed_review;
            $speed_rate      = $request->speed_rate;
            $power_review    = $request->power_review;
            $power_rate      = $request->power_rate;
            $agility_review  = $request->agility_review;
            $agility_rate    = $request->agility_rate;


            return [
                'review => "' . $strength_review . '", rating => "' . $strength_rate . '"',
                'review => "' . $speed_review . '", rating => "' . $speed_rate . '"',
                'review => "' . $power_review . '", rating => "' . $power_rate . '"',
                'review => "' . $agility_review . '", rating => "' . $agility_rate . '"'
            ];
        }
    }


    private function playerAssessmentBaseQuery($playerId, $assessmentId = "")
    {

        if ($assessmentId) {

            $column = 'id';
            $value  = $assessmentId;
        } else {

            $column = 'player_id';
            $value  = $playerId;
        }

        return self::SELECT(
            'assessments.player_id',
            'assessments.match_id',
            'assessments.coach_id',
            'assessments.id',
            DB::raw($this->getJsonFields('assessments')),
            's.player1',
            's.player2',
            DB::raw("to_char(s.date_time, 'dd/mm/YYYY HH12:MI AM') as date"),
            'p1.name AS p1name',
            'p2.name AS p2name',
            'users.name AS uname'
        )
            ->join('users', 'users.id', '=', 'assessments.coach_id')
            ->join('scheduling as s', 's.id', '=', 'assessments.match_id')
            ->join('players as p1', 'p1.id', '=', 's.player1')
            ->join('players as p2', 'p2.id', '=', 's.player2')
            ->where('assessments.' . $column, $value);
    }


    public function checkAssessementAuth($coachId, $assessmentId)
    {

        return self::where('id', $assessmentId)
            ->where('coach_id', $coachId)
            ->count() > 0;
    }

    public function assessmentGraphsByMonthYear($playerId, $request)
    {

        $field = $request->field;
        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;


        return self::select(
            DB::raw("(assessments.$field -> 'rating') as $field"),
            DB::raw("DATE(scheduling.date_time) as date")
        )
            ->where('assessments.player_id', $playerId)
            ->join('scheduling', 'scheduling.id', '=', 'assessments.match_id')
            ->where(DB::raw('extract(month from scheduling.date_time)'), $month1)
            ->where(DB::raw('extract(year from scheduling.date_time)'), $year1)
            ->orderBy("date", "desc")
            ->get();
    }

    public function assessmentGraphsByYear($playerId, $request)
    {

        $field = $request->field;
        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;
        $arrayNames = array();
        $value = array();
        $assessments = [];
        for ($i = 1; $i < 13; $i++) {

            $assessment = Assessment::select(
                DB::raw("round(avg((assessments.$field -> 'rating')::int)) as $field"),
                DB::raw("to_char(scheduling.date_time, 'Mon') as month")
            )
                ->where('assessments.player_id', $playerId)
                ->join('scheduling', 'scheduling.id', '=', 'assessments.match_id')
                ->where(DB::raw('extract(year from scheduling.date_time)'), $year2)
                ->where(DB::raw('extract(month from scheduling.date_time)'), $i)
                ->groupBy("month")
                ->orderBy("month", "desc")
                ->first();

            if ($assessment == null) {
                $assessment = new \stdClass();
                $assessment->{$field} = "0";
                $month = substr(date("F", mktime(0, 0, 0, $i, 10)), 0, 3);
                $assessment->month = $month;
            }
            array_push($assessments, $assessment);
        }
        return $assessments;
    }
}
