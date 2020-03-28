<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\UserType;
use App\User;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use App\Match;
use App\Player;
use App\Academy;
use App\Event;
use App\AnonymousFeedback;
use Carbon\Carbon;




class AdminController extends Controller
{

    private $user;
    private $userType;

    public function __construct(User $user, UserType $userType)
    {
        $this->user = $user;
        $this->userType = $userType;

        parent::__construct();
    }


    public function dashboard(Match $match)
    {
        $matches = Match::count();
        $players = Player::count();
        $academies = Academy::count();
        $coach = $this->userType->where('type', 'coach')->first();
        $coaches = $this->user->where('user_type', $coach->id)->count();


        $event = new Event;

        $events = $event->getEventwithType();


        foreach ($events as $event) {

            if ($event->type == '0') {
                //match
                $event->url = url('/schedules/' . $event->type_id . '/view');
            } else if ($event->type == '1') {
                $event->url = url('/drills/assign/' . $event->type_id . '/view');
            }
        }


        return view('dashboard', ['numMatches' => $matches, 'numPlayers' => $players, 'numAcademies' => $academies, 'numCoaches' => $coaches, 'events' => $events]);
    }


    public function macthDashboard(Match $match)
    {

        $matches = $match->count();

        $players = Player::count();
        $academies = Academy::count();
        $coach = $this->userType->where('type', 'coach')->first();
        $coaches = $this->user->where('user_type', $coach->id)->count();

        $event = new Event;
        if ($this->sessionUserType == "player" || $this->sessionUserType == "parent" || $this->sessionUserType == "coach") {

            $events = $event->getEventwithTypeMatch($this->sessionUserType, $this->sessionUserId);

        } else {

            $events = $event->getEventwithTypeMatch($this->sessionUserType, $this->sessionUserId);
        }


        foreach ($events as $event) {

            $event->url = url('/schedules/' . $event->type_id . '/view');
        }

        return view('dashboard', ['numMatches' => $matches, 'numPlayers' => $players, 'numAcademies' => $academies, 'numCoaches' => $coaches, 'events' => $events]);
    }


    public function drillDashboard(Match $match)
    {

        $matches = $match->count();

        $players = Player::count();
        $academies = Academy::count();
        $coach = $this->userType->where('type', 'coach')->first();
        $coaches = $this->user->where('user_type', $coach->id)->count();

        $event = new Event;
        if ($this->sessionUserType == "player" || $this->sessionUserType == "parent" || $this->sessionUserType == "coach") {

            $events = $event->getEventwithTypeDrill($this->sessionUserType, $this->sessionUserId);
        } else {

            $events = $event->getEventwithTypeDrill($this->sessionUserType, $this->sessionUserId);
        }

        foreach ($events as $event) {

            $event->url = url('/drills/assign/' . $event->type_id . '/view');
        }

        return view('dashboard', ['numMatches' => $matches, 'numPlayers' => $players, 'numAcademies' => $academies, 'numCoaches' => $coaches, 'events' => $events]);
    }


    public function feedback(Request $request)
    {
        if ($request->isMethod('GET')) {

            $usertype = UserType::where('type', 'admin')->first();

            $user = User::where('user_type', $usertype->id)->get();

            return view('anonymous_feedback')->with('Admins', $user);
        }
        if ($request->isMethod('POST')) {

            $datetime = Carbon::now();

            $adminDetails = $this->user->find($request->admin);

            if ($this->sessionUserType == "player") {

                $player = Player::find($this->sessionUserId)->select('user_id')->first();

                $userDetails = $this->user->find($player->user_id);
            } else {

                $userDetails = $this->user->find($this->sessionUserId);
            }



            $message = $request->message;
            $adminName = $adminDetails->name;

            $anonymous_feedback = new AnonymousFeedback;
            $anonymous_feedback->user_id = $this->sessionUserId;
            $anonymous_feedback->user_type_id = $userDetails->user_type;
            $anonymous_feedback->message = $request->message;
            $anonymous_feedback->admin_id = $request->admin;
            $anonymous_feedback->date_time = $datetime;

            $anonymous_feedback->save();

            //send email

            return back()->with('message', config('strings.success.anonymous_feedback'));
        }
    }
}
