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
use App\Assessment;
use Carbon\Carbon;
use Validator;
use Excel;

class PlayerController extends Controller
{

    private $user;
    private $userType;


    public function __construct(User $user, UserType $userType)
    {
        $this->user = $user;
        $this->userType = $userType;

        parent::__construct();
    }
    public function players(Request $request)
    {


        if ($request->has('except')) {


            $sessionId = $this->sessionUserId;
            $sessionType = $this->sessionUserType;
            if ($sessionType == "coach") {
                return Player::whereNotIn('id', [$request->input('except')])
                    ->where('coachid', $sessionId)
                    ->select('id', 'name')
                    ->get();
            } else {
                return Player::whereNotIn('id', [$request->input('except')])->select('id', 'name')->get();
            }
        }
        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column = $request->searchColumn;
            $searchBy = $request->searchBy;


            $players = Player::select('players.*', 'academies.title', 'users.name as cname')
                ->where('players.' . $column,  'iLIKE', '%' . $searchBy . '%')
                ->join('academies', 'academies.id', '=', 'players.academy_id')
                ->join('users', 'users.id', '=', 'players.coachid')
                ->paginate(10);
        } else {
            $player = new Player;
            $players = $player->playerDetails();
        }
        return view('players', ['players' => $players]);
    }

    public function playerForm()
    {

        $academies = Academy::all();

        $stances = \DB::table('stance')->get();

        $type = $this->userType->where('type', 'coach')->first();

        if ($type) {
            $coaches = User::where('user_type', $type->id)->get();
        }

        return view('add_player', ['stances' => $stances, 'coaches' => $coaches, 'academies' => $academies]);
    }

    public function addPlayer(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);

        if ($validate->fails()) {
            return back()->with('ErrorMessage', config('strings.warning.already_registered'));
        }
        $usertype = $this->userType->where('type', 'player')->select('id')->first();

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = str_replace(" ", "_", $request->name) . '_' . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images', $fileName);
            $profile = $fileName;
        } else {
            $profile = NULL;
        }

        $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_-=+?";
        $password = substr(str_shuffle($chars1), 0, 6);
        $password = 'abc123';

        $userd = $this->user;

        $userd->name = $request->name;
        $userd->email = $request->email;
        $userd->user_type = $usertype->id;
        $userd->password = \Hash::make($password);
        $userd->profile_picture = $profile;

        $userd->save();

        $dob = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');

        $player = new Player;
        $player->name         = $request->name;
        $player->email        = $request->email;
        $player->contact      = $request->contact;
        $player->gender       = $request->gender;
        $player->dob          = $dob;
        $player->address      = $request->address;
        $player->parent_name  = $request->parent;
        $player->stanceid     = $request->stanceid;
        $player->coachid      = $request->coachid;
        $player->remark       = $request->remark;
        $player->user_id      = $userd->id;
        $player->academy_id   = $request->academyId;

        $player->save();
        //send email
        $userd->sendWelcomeEmail();
        if ($request->has('addNew')) {
            return back()->with('message', config('strings.success.player_added'));
        } else {
            return redirect('players')->with('message', config('strings.success.player_added'));
        }
    }


    public function editPlayer($id)
    {

        $player = Player::find($id);


        if ($player->dob !== null) {

            $player->dob = Carbon::createFromFormat('Y-m-d', $player->dob)->format('d/m/Y');
        }


        $academies = Academy::all();

        $stances = \DB::table('stance')->get();

        $type = $this->userType->where('type', 'coach')->first();

        if ($type) {
            $coaches = $this->user->where('user_type', $type->id)->get();
        }

        return view('update_player', ['player' => $player, 'stances' => $stances, 'coaches' => $coaches, 'academies' => $academies]);
    }


    public function updatePlayer($id, Request $request)
    {
        $player = Player::find($id);
        $dob = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');

        $player->name         = $request->name;
        $player->email        = $request->email;
        $player->contact      = $request->contact;
        $player->gender       = $request->gender;
        $player->dob          = $dob;
        $player->address      = $request->address;
        $player->parent_name  = $request->parent;
        $player->stanceid     = $request->stanceid;
        $player->coachid      = $request->coachid;
        $player->remark       = $request->remark;
        $player->academy_id   = $request->academyId;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = str_replace(" ", "_", $player->name) . '_' . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images', $fileName);
            $player->profile_picture = $fileName;
        }

        $player->save();

        return back()->with('message', config('strings.success.player_updated'));
    }

    public function viewPlayer($id)
    {
        $player = Player::find($id);

        if ($player->dob !== null) {

            $player->dob = Carbon::createFromFormat('Y-m-d', $player->dob)->format('d/m/Y');
        }

        $academy = Academy::find($player->academy_id);

        $stance = \DB::table('stance')->find($player->stanceid);

        $coach = $this->user->find($player->coachid);
        return view('view_player', ['player' => $player, 'stance' => $stance, 'coach' => $coach, 'academy' => $academy]);
    }

    public function deletePlayer($id)
    {
        $player = Player::find($id)->delete();
        return "true";
    }

    public function assessmentForm($id, Request $request, Match $matchDetails)
    {


        $match_id = $request->match_id;

        $assessment = Assessment::where('match_id', $match_id)
            ->where('player_id', $id)
            ->first();
        if (($assessment)) {

            return $this->assessmentEdit($id, $assessment->id, $request, $matchDetails);
        } else {
            $player = Player::find($id);

            $match = $matchDetails->scheduleDetails($match_id);

            $academy_id = $match->academy_id;

            $academy = Academy::find($academy_id);

            return view('add_assessment', ['player' => $player, 'match' => $match, 'academy' => $academy]);
        }
    }

    public function assessments($playerId, Request $request)
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

        $assessmentObj = new Assessment;
        $player = Player::find($playerId);
        $type = $request->input('type', 'technical');

        switch ($type) {
            case 'technical':
                $type = 'technical';
                break;
            case 'physical':
                $type = 'physical';
                break;
            default:
                $type = 'technical';
                break;
        }
        $assessmentObj->setFields($type);

        $fields = $assessmentObj->fields;




        if ($request->has("searchColumn") && $request->has("searchBy")) {

            $column = $request->searchColumn;
            $searchBy = $request->searchBy;

            $assessments = $assessmentObj->playerAssessments($playerId, $column, $searchBy);
        } else {

            $assessments = $assessmentObj->playerAssessments($playerId);
        }

        foreach ($assessments as $assessment) {
            foreach ($assessmentObj->fields as $field) {
                $assessment->{$field} = json_decode($assessment->{$field});
            }
        }

        $assessmentObj1  = new Assessment;
        $assessmentObj1->setFields();

        $fieldsforGraph = $assessmentObj1->fields;

        return view('assessments', ['assessments' => $assessments, 'player' => $player, 'fields' => $fields, 'type' => $type, 'fieldGraph' => $fieldsforGraph]);
    }

    public function assessmentEdit($playerId, $assessmentId, Request $request, Match $match)
    {

        $assessmentObj = new Assessment;

        $assessmentObj->setFields();
        $assessment = $assessmentObj->playerAssessmentsEdit($playerId, $assessmentId);

        foreach ($assessmentObj->fields as $field) {
            $assessment->{$field} = json_decode($assessment->{$field});
        }

        $match_id   = $request->match_id;

        $player     = Player::find($playerId);

        $match      = $match->scheduleDetails($match_id);

        $academy_id = $match->academy_id;

        $academy    = Academy::find($academy_id);
        $assessment = json_encode($assessment);
        $assessment = json_decode($assessment);

        return view('edit_assessment', ['assessment' => $assessment, 'player' => $player, 'match' => $match, 'academy' => $academy, 'fields' => $assessmentObj->fields]);
    }


    public function assessmentDelete($playerId, $assessmentId)
    {

        Assessment::find($assessmentId)->delete();
        return "true";
    }

    public function assessmentView($id, $aid, Request $request, Match $matchDetails)
    {

        $assessmentObj = new Assessment;

        $assessmentObj->setFields();
        $assessment = $assessmentObj->playerAssessmentsEdit($id, $aid);
        foreach ($assessmentObj->fields as $field) {
            $assessment->{$field} = json_decode($assessment->{$field});
        }

        $match_id = $request->match_id;

        $player = Player::find($id);

        $match = $matchDetails->scheduleDetails($match_id);
        $academy_id = $match->academy_id;

        $academy = Academy::find($academy_id);
        $assessment = json_encode($assessment);
        $assessment = json_decode($assessment);

        return view('view_assessment', ['assessment' => $assessment, 'player' => $player, 'match' => $match, 'academy' => $academy, 'fields' => $assessmentObj->fields]);
    }


    public function assessmentStatistics($playerId, Request $request)
    {

        $field = $request->field;
        $month1 = $request->month1;
        $year1 = $request->year1;
        $year2 = $request->year2;

        $array = array('field' => $field, 'month1' => $month1, 'year1' => $year1, 'year2' => $year2);
        $player = Player::find($playerId);

        $assessment = new Assessment;
        $byMonthAndYear = $assessment->assessmentGraphsByMonthYear($playerId, $request);

        $byYear = $assessment->assessmentGraphsByYear($playerId, $request);

        return view('statistics', ['byYear' => $byYear, 'byMonthAndYear' => $byMonthAndYear, 'postData' => $array, 'player' => $player]);
    }

    public function exportPlayers()
    {

        $players = Player::all();
        Excel::create('Players', function ($excel) use ($players) {

            $excel->sheet('Sheetname', function ($sheet) use ($players) {

                $sheet->fromArray($players);
            });
        })->export('xls');

        return back();
    }


    public function exportPlayersAssessments($id)
    {


        $assessments = Assessment::where('player_id', $id)->get();

        Excel::create('player_assessments', function ($excel) use ($assessments) {

            $excel->sheet('Sheetname', function ($sheet) use ($assessments) {

                $sheet->fromArray($assessments);
            });
        })->export('xls');

        return back();
    }
}
