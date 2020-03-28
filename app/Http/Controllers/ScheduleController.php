<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Player;

use App\Academy;

use App\Match;

use App\Event;

use App\AcademyCoach;
use Excel;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {

        parent::__construct();
    }
    public function schedules(Request $request)
    {

        $match = new Match;

        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column = $request->searchColumn;
            $searchBy = $request->searchBy;

            $schedules = $match->allScheduleDetails($column, $searchBy);
        } else {

            $schedules = $match->allScheduleDetails();
        }

        return view('schedules', ['matches' => $schedules]);
    }

    public function scheduleFrom()
    {

        $sessionId = $this->sessionUserId;
        $sessionType = $this->sessionUserType;

        if ($sessionType == "coach") {

            $players = Player::where('coachid', $sessionId)->get();
            $academycoach = AcademyCoach::where('coach_id', $sessionId)
                ->select('academy_id')
                ->pluck('academy_id');
            $academies = Academy::whereIn('id', $academycoach)->get();
        } else {
            $players = Player::all();
            $academies = Academy::all();
        }

        return view('add_schedules', ['players' => $players, 'academies' => $academies]);
    }

    public function addMatchSchedule(Request $request)
    {

        $date = $this->convertToDBDateTime($request->date_time);

        $event = new Event;

        $detailPlayer1 = Player::select('name')->find($request->player1);

        $detailPlayer2 = Player::select('name')->find($request->player2);

        $event->title = $detailPlayer1->name . " Vs " . $detailPlayer2->name;
        $event->type = 0;
        $event->date_time = $date;

        $event->save();

        $schedule = new Match;

        $schedule->player1 = $request->player1;
        $schedule->player2 = $request->player2;
        $schedule->academy_id = $request->academy;
        $schedule->court_id = $request->court;
        $schedule->date_time = $date;
        $schedule->event_id = $event->id;

        $schedule->save();

        if ($request->has('addNew')) {

            return back()->with('message', config('strings.success.match_added'));
        } else {
            return redirect('schedules')->with('message', config('strings.success.match_added'));
        }
    }

    public function deleteMatchSchedule($id)
    {
        Match::find($id)->delete();
        return "true";
    }

    public function editMatchSchedule($id)
    {
        $matchDetails = new Match;
        $match = $matchDetails->scheduleDetails($id);

        $sessionId = $this->sessionUserId;
        $sessionType = $this->sessionUserType;

        if ($sessionType == "coach") {

            $players = Player::where('coachid', $sessionId)->get();
            $academycoach = AcademyCoach::where('coach_id', $sessionId)
                ->select('academy_id')
                ->pluck('academy_id');

            $academies = Academy::whereIn('id', $academycoach)
                ->get();

            $playerWithoutP1 = Player::whereNotIn('id', [$match->player1])
                ->where('coachid', $sessionId)
                ->select('id', 'name')
                ->get();
        } else {
            $players = Player::all();
            $academies = Academy::all();
            $playerWithoutP1 = Player::whereNotIn('id', [$match->player1])->select('id', 'name')->get();
        }

        $academyCourts = $matchDetails->academyCourts($match->academy_id);

        return view('edit_schedules', ['players' => $players, 'academies' => $academies, 'match' => $match, 'playerWithoutP1' => $playerWithoutP1, 'courts' => $academyCourts]);
    }


    public function updateMatchSchedule(Request $request, $id)
    {

        $date = \Carbon\Carbon::createFromFormat('d/m/Y h:i A', $request->date_time)->toDateTimeString();

        $schedule = Match::find($id);


        $event = Event::where('id', $schedule->event_id)->first();

        $detailPlayer1 = Player::select('name')->find($request->player1);

        $detailPlayer2 = Player::select('name')->find($request->player2);

        $event->title = $detailPlayer1->name . " Vs " . $detailPlayer2->name;
        $event->type = 0;
        $event->date_time = $date;

        $event->save();


        $schedule->player1 = $request->player1;
        $schedule->player2 = $request->player2;
        $schedule->academy_id = $request->academy;
        $schedule->court_id = $request->court;
        $schedule->date_time = $date;

        $schedule->save();
        return back()->with('message', config('strings.success.match_updated'));
    }


    public function viewMatchSchedule($id)
    {
        $matchDetails = new Match;
        $user = auth()->user();
        $type = $user->getType();
        if (
            $type == 'admin' || ($type == 'player' && $matchDetails->CheckPlayerWithMatch($id, $user->player->id)) ||
            ($type == 'coach' && $matchDetails->hasAuth($user->id, $id))
        ) {
            $match = $matchDetails->scheduleDetails($id);
            return view('view_schedules', ['match' => $match]);
        }
        return redirect('error');
    }

    public function schedulesExport()
    {

        $this->userType;
        $schedules = Match::all();

        Excel::create('Schedules', function ($excel) use ($schedules) {

            $excel->sheet('Sheetname', function ($sheet) use ($schedules) {

                $sheet->fromArray($schedules);
            });
        })->export('xls');

        return back();
    }


    public function updateMatchWinner($matchId, Request $request)
    {


        $schedule = Match::find($matchId);

        $schedule->winner_id = $request->player;

        $schedule->save();

        return 200;
    }
}