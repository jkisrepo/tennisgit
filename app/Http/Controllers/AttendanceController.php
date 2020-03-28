<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\UserType;
use App\User;

use App\Player;
use DB;

use App\Match;
use App\Academy;
use App\PlayerAttendance;
use App\CoachAttendance;
use App\Assessment;
use Session;

use Carbon\Carbon;

use Excel;

class AttendanceController extends Controller
{

    private $user;
    private $userType;


    public function __construct(User $user, UserType $userType)
    {

        parent::__construct();

        $this->user = $user;
        $this->userType = $userType;
    }


    public function playerAttendance(Request $request)
    {
        $user = auth()->user();
        $type = $user->getType();
        $player_id = "";
        $player = array();
        if ($request->has('player_id')) {
            if ($type == 'player') {
                if ($request->player_id != auth()->user()->player->id) {
                    return redirect('error');
                }
            }
            if ($type == 'coach') {
                $players = Player::select('id')
                    ->where('coachid', $user->id)
                    ->get();

                foreach ($players as $key => $value) {
                    $array[] = $value->id;
                }

                if (!in_array($request->player_id, $array)) {
                    return redirect('error');
                }
            }
            $player_id = $request->player_id;

            $player = Player::find($player_id);
        }

        $playerAttendance = new PlayerAttendance();

        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column   = $request->searchColumn;
            $searchBy = $request->searchBy;
            $player_attendance = $playerAttendance->playerAttendance($player_id, $column, $searchBy);
        } else {

            $player_attendance = $playerAttendance->playerAttendance($player_id);
        }
        return view('player_attendance', ['playerattendance' => $player_attendance, 'player' => $player]);
    }

    public function formPlayerAttendance()
    {

        $players = $this->getPlayers();

        return view('add_player_attendance', ['players' => $players]);
    }

    public function addPlayerAttendance(Request $request)
    {

        $playerattendance = new PlayerAttendance();
        $coach = $playerattendance->playerCoach($request->player);

        $requestDateOnly = $this->convertToDBDateTime($request->date_time)->format('d-m-Y');

        $currentDateOnly = Carbon::now()->format('d-m-Y');

        if (strtotime($requestDateOnly) <= strtotime($currentDateOnly)) {

            $playerattendance->player_id = $request->player;
            $playerattendance->coach_id = $coach->id;
            $playerattendance->attendance = $request->attendance;
            if ($request->attendance == 0) {
                $playerattendance->absent_type = $request->absent_type;
            } else {
                $playerattendance->absent_type = NULL;
            }
            $playerattendance->date_time = $this->convertToDBDateTime($request->date_time);
            $playerattendance->save();


            if ($request->has('addNew')) {

                return back()->with('message', config('strings.success.attendance_added'));
            } else {
                return redirect('/attendance/players')->with('message', config('strings.success.attendance_added'));
            }
        } else {

            return back()->with('warning', config('strings.warning.attendance'));
        }
    }


    public function deletePlayerAttendance($id)
    {
        $playerAtt = new PlayerAttendance;
        $user = auth()->user();
        if ($user->getType() == 'coach' && !$playerAtt->hasAuth($user->id, $id)) {
            return redirect('error');
        }
        PlayerAttendance::find($id)->delete();
        return "true";
    }

    public function editPlayerAttendance($id)
    {
        $playerAttendance = new PlayerAttendance;
        $user = auth()->user();
        if ($user->getType() == 'coach' && !$playerAttendance->hasAuth($user->id, $id)) {
            return redirect('error');
        }
        $players = $this->getPlayers();

        $player_attendance = PlayerAttendance::find($id);

        $date = \Carbon\Carbon::createFromFormat(config('app.db_date_time_format'), $player_attendance->date_time)->format('d/m/Y h:i A');

        $player_attendance->date_time = $date;

        return view('edit_player_attendance', ['players' => $players, 'player_attendance' => $player_attendance]);
    }

    public function updatePlayerAttendance(Request $request, $id)
    {
        $playerAtt = new PlayerAttendance;
        $user = auth()->user();
        if ($user->getType() == 'coach' && !$playerAtt->hasAuth($user->id, $id)) {
            return redirect('error');
        }
        $playerattendance = PlayerAttendance::find($id);
        $coach = $playerattendance->playerCoach($request->player);

        $requestDateOnly = $this->convertToDBDateTime($request->date_time)->format('d-m-Y');

        $currentDateOnly = Carbon::now()->format('d-m-Y');

        if (strtotime($requestDateOnly) <= strtotime($currentDateOnly)) {

            $playerattendance->player_id = $request->player;
            $playerattendance->coach_id = $coach->id;
            $playerattendance->attendance = $request->attendance;
            if ($request->attendance == 0) {
                $playerattendance->absent_type = $request->absent_type;
            } else {
                $playerattendance->absent_type = null;
            }
            $playerattendance->date_time = $this->convertToDBDateTime($request->date_time);
            $playerattendance->save();

            return back()->with('message', config('strings.success.attendance_updated'));
        } else {

            return back()->with('warning', config('strings.warning.attendance'));
        }
    }

    public function viewPlayerAttendance($id)
    {

        $players = $this->getPlayers();
        $user = auth()->user();
        $type = $user->getType();
        $player_attendance = PlayerAttendance::find($id);
        if (
            $player_attendance &&
            ($type == 'admin' ||
                ($type == 'player' && $player_attendance->CheckPlayerWithAttendance($id, $user->player->id)) ||
                ($type == 'coach' && $player_attendance->hasAuth($user->id, $id)))
        ) {
            $date = \Carbon\Carbon::createFromFormat(config('app.db_date_time_format'), $player_attendance->date_time)->format('d/m/Y h:i A');
            $player_attendance->date_time = $date;
            return view('view_player_attendance', ['players' => $players, 'player_attendance' => $player_attendance]);
        }
        return redirect('error');
    }


    public function coachAttendance(Request $request)
    {
        $coach_id = "";
        $coach = array();
        if ($request->has('coach_id')) {

            $coach_id = $request->coach_id;

            $coach = User::find($coach_id);
        }
        $CoachAttendance = new CoachAttendance();

        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column = $request->searchColumn;
            $searchBy = $request->searchBy;

            $coach_attendance = $CoachAttendance->coachAttendance($coach_id, $column, $searchBy);
        } else {

            $coach_attendance = $CoachAttendance->coachAttendance($coach_id);
        }
        return view('coach_attendance', ['coach_attendance' => $coach_attendance, 'coach' => $coach]);
    }

    public function formCoachAttendance()
    {


        $sessionType = $this->sessionUserType;
        $sessionId = $this->sessionUserId;

        $coaches =  $this->user
            ->select('id', 'name');

        if ($sessionType == "coach") {

            $userId = $sessionId;

            $coaches =  $coaches->where('id', $userId);
        } else {

            $userType = $this->userType->where('type', 'coach')->first();

            $userId = $userType->id;

            $coaches =  $coaches->where('user_type', $userId);
        }

        $coaches = $coaches->get();

        return view('add_coach_attendance', ['coaches' => $coaches]);
    }

    public function addCoachAttendance(Request $request)
    {

        $CoachAttendance = new CoachAttendance();

        $requestDateOnly = $this->convertToDBDateTime($request->date_time)->format('d-m-Y');

        $currentDateOnly = Carbon::now()->format('d-m-Y');

        if (strtotime($requestDateOnly) <= strtotime($currentDateOnly)) {

            $CoachAttendance->coach_id = $request->coach;
            $CoachAttendance->attendance = $request->attendance;
            if ($request->attendance == 0) {
                $CoachAttendance->absent_type = $request->absent_type;
            } else {
                $CoachAttendance->absent_type = NULL;
            }
            $CoachAttendance->date_time = $this->convertToDBDateTime($request->date_time);
            $CoachAttendance->save();


            if ($request->has('addNew')) {

                return back()->with('message', config('strings.success.attendance_added'));
            } else {
                return redirect('/attendance/coaches')->with('message',  config('strings.success.attendance_added'));
            }
        } else {

            return back()->with('warning', config('strings.warning.attendance'));
        }
    }


    public function deleteCoachAttendance($id)
    {
        CoachAttendance::find($id)->delete();
        return back()->with('message', config('strings.success.attendance_deleted'));
    }

    public function editCoachAttendance($id)
    {

        $coach_attendance = CoachAttendance::find($id);



        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $coach_attendance->date_time)->format('d/m/Y h:i A');

        $coach_attendance->date_time = $date;

        $coaches = $this->user->select(['id', 'name'])->get();
        return view('edit_coach_attendance', ['coaches' => $coaches, 'coach_attendance' => $coach_attendance]);
    }

    public function updateCoachAttendance(Request $request, $id)
    {

        $CoachAttendance = CoachAttendance::find($id);

        $requestDateOnly = $this->convertToDBDateTime($request->date_time)->format('d-m-Y');

        $currentDateOnly = Carbon::now()->format('d-m-Y');

        if (strtotime($requestDateOnly) <= strtotime($currentDateOnly)) {

            $CoachAttendance->coach_id = $request->coach;
            $CoachAttendance->attendance = $request->attendance;
            if ($request->attendance == 0) {
                $CoachAttendance->absent_type = $request->absent_type;
            } else {
                $CoachAttendance->absent_type = null;
            }
            $CoachAttendance->date_time = $this->convertToDBDateTime($request->date_time);
            $CoachAttendance->save();

            return back()->with('message', config('strings.success.attendance_updated'));
        } else {

            return back()->with('warning', config('strings.warning.attendance'));
        }
    }

    public function viewCoachAttendance($id)
    {

        $CoachAttendance = CoachAttendance::find($id);

        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $CoachAttendance->date_time)->format('d/m/Y h:i A');

        $CoachAttendance->date_time = $date;

        $coach = $this->user
            ->select(['id', 'name'])
            ->where('id', $CoachAttendance->coach_id)
            ->first();

        return view('view_coach_attendance', ['coach' => $coach, 'coach_attendance' => $CoachAttendance]);
    }

    public function playerAttendanceExport()
    {

        $playerAttendance = PlayerAttendance::all();

        Excel::create('PlayerAttendance', function ($excel) use ($playerAttendance) {

            $excel->sheet('Sheetname', function ($sheet) use ($playerAttendance) {

                $sheet->fromArray($playerAttendance);
            });
        })->export('xls');

        return back();
    }

    public function coachAttendanceExport()
    {

        $coachAttendance = DB::table('coach_attendance')->get();

        $coachAttendance = (object) $coachAttendance;

        $coachAttendance = get_object_vars($coachAttendance);

        Excel::create('CoachAttendance', function ($excel) use ($coachAttendance) {

            $excel->sheet('Sheetname', function ($sheet) use ($coachAttendance) {

                $sheet->fromArray($coachAttendance);
            });
        })->export('xls');

        return back();
    }


    private function getPlayers()
    {

        $sessionType = $this->sessionUserType;
        $sessionId = $this->sessionUserId;

        if ($sessionType == "coach") {
            $players = Player::select(['id', 'name'])
                ->where('coachid', $sessionId)
                ->get();
        } else {
            $players = Player::select(['id', 'name'])->get();
        }

        return $players;
    }

    public function playerAttendanceGraph($playerId, Request $request)
    {
        $user = auth()->user();
        $type = $user->getType();
        if ($type == 'coach') {
            $players = Player::select('id')->where('coachid', $user->id)->get();
            foreach ($players as $key => $value)
                $array[] = $value->id;

            if (!in_array($playerId, $array)) {
                return redirect('error');
            }
        }
        if ($type == 'player' && ($playerId != $user->player->id)) {
            return redirect('error');
        }
        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;

        $array = array('month1' => $month1, 'year1' => $year1, 'year2' => $year2);
        $player = Player::find($playerId);

        $attendance = new PlayerAttendance;
        $byMonthAndYear = $attendance->attendanceGraphsByMonthYear($playerId, $request);

        $byYear = $attendance->attendanceGraphsByYear($playerId, $request);

        $totalByYear = $attendance->totalAttendanceGraphsByYear($playerId, $request);

        $totalByMonthAndYear = $attendance->totalAttendanceGraphsByMonthYear($playerId, $request);

        return view('attendance_statistics', ['byYear' => $byYear, 'byMonthAndYear' => $byMonthAndYear, 'postData' => $array, 'user' => $player, 'totalByMonthAndYear' => $totalByMonthAndYear, 'totalByYear' => $totalByYear]);
    }


    public function coachAttendanceGraph($coachId, Request $request)
    {
        $user = auth()->user();
        if ($user->getType() == 'coach' && $user->id != $coachId) {
            return redirect('error');
        }
        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;

        $array = array('month1' => $month1, 'year1' => $year1, 'year2' => $year2);
        $coach = user::find($coachId);

        $attendance = new CoachAttendance;
        $byMonthAndYear = $attendance->attendanceGraphsByMonthYear($coachId, $request);

        $byYear = $attendance->attendanceGraphsByYear($coachId, $request);

        $totalByYear = $attendance->totalAttendanceGraphsByYear($coachId, $request);

        $totalByMonthAndYear = $attendance->totalAttendanceGraphsByMonthYear($coachId, $request);


        return view('attendance_statistics', ['byYear' => $byYear, 'byMonthAndYear' => $byMonthAndYear, 'postData' => $array, 'user' => $coach, 'totalByMonthAndYear' => $totalByMonthAndYear, 'totalByYear' => $totalByYear]);
    }
}
