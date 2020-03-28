<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\PlayerAttendance;
use App\Player;
use App\Match;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Assessment;

class CoachAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = auth()->user();
        $path = $request->path();

        if ($user->getType() == 'admin') {
            return $next($request);
        } else {
            if ($user->getType() == 'coach') {

                $playerAttendance = new PlayerAttendance;

                $match = new Match;

                $player = new Player;
                if (Request::is('schedules/*')) {
                    if (Route::input('id') == "") {
                        return $next($request);
                    } else {

                        $match = new Match;

                        $match = $match->hasAuth($user->id, Route::input('id'));

                        if ($match > 0) {
                            return $next($request);
                        }
                    }
                } elseif (Request::is('drills/assign')) {
                    return $next($request);
                } elseif (Request::is('attendance/*')) {
                    return $next($request);
                } elseif (Request::is('players/*')) {
                    if ($request->has('match_id')) {

                        $playerId = Route::input('id');

                        $match = new Match;

                        $match = $match->checkCoachPlayersAttendance($request->match_id, $playerId, $user->id);

                        if ($match > 0) {

                            return $next($request);
                        }
                    } else {
                        if ($player->hasAuth($user->id, Route::input('id'))) {
                            return $next($request);
                        }
                    }
                } elseif (Request::is('assessments*')/*$path == "assessments/{id}/update"*/) {
                    $valid = true;
                    if (Request::has('id') && Route::input('id') != "") {
                        $assessment = new Assessment;
                        $valid = $assessment->checkAssessementAuth($user->id, Route::input('id'));
                    }
                    if ($valid) {
                        return $next($request);
                    }
                } elseif ($path == "academies" || $path == "playerscoach") {
                    return $next($request);

                }
            }
            return redirect('error');
        }
    }
}
