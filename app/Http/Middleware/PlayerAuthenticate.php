<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\PlayerAttendance;
use Illuminate\Support\Facades\Route;;

use App\Player;
use App\Match;
use App\Drill;
use Illuminate\Support\Facades\Request;

class PlayerAuthenticate
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
        $type = $user->getType();
        $path = $request->path();

        if ($user->getType() == 'admin') {
            return $next($request);
        } else {
            if ($user->getType() == 'coach') {
                if (Request::is("schedules/{id}/view")) {

                    $match = new Match;

                    $match = $match->hasAuth($user->id, Route::input('id'));

                    if ($match > 0) {
                        return $next($request);
                    }
                } elseif ($path == "attendance/{id}/players/view") {


                    $playerAttendance = new PlayerAttendance;

                    $playerAtt = $playerAttendance->hasAuth($user->id, Route::input('id'));
                    if ($playerAtt > 0) {
                        return $next($request);
                    }
                } elseif ($path == 'drills/assign/{id}/view') {
                    $drill = new  Drill;
                    $drill = $drill->checkDrillPlayerCoach($user->id, Route::input('id'));
                    if ($drill > 0) {
                        return $next($request);
                    }
                } elseif ($path == "attendance/players") {

                    if (Request::input('player_id')) {
                        $players = Player::select('id')
                            ->where('coachid', $user->id)
                            ->get();

                        foreach ($players as $key => $value) {

                            $array[] = $value->id;
                        }

                        if (in_array(Request::input('player_id'), $array)) {
                            return $next($request);
                        }
                    } else {
                        return $next($request);
                    }
                } elseif ($path == "attendance/players/{id}/graph" || "players/{id}/assessments") {

                    $players = Player::select('id')
                        ->where('coachid', $user->id)
                        ->get();

                    foreach ($players as $key => $value) {

                        $array[] = $value->id;
                    }

                    if (in_array(Route::input('id'), $array)) {
                        return $next($request);
                    }
                }
            } else {
                if ($path == "attendance/{id}/players/view") {

                    $attendanceId = Route::input('id');

                    $playerAttendance = new PlayerAttendance;

                    $count = $playerAttendance->CheckPlayerWithAttendance($attendanceId, $user->id);

                    if ($count > 0) {
                        return $next($request);
                    }
                } elseif ($path == "schedules/{id}/view") {

                    $matchId = Route::input('id');

                    $match = new Match;
                    $count = $match->CheckPlayerWithMatch($matchId, $user->id);

                    if ($count > 0) {
                        return $next($request);
                    }
                } elseif ($path == "attendance/players/{id}/graph") {

                    if (Route::input('id') == $user->id) {
                        return $next($request);
                    }
                } elseif ($path == "attendance/players") {
                    if (Request::input('player_id')) {
                        if (Request::input('player_id') == $user->id) {
                            return $next($request);
                        }
                    } else {

                        return $next($request);
                    }
                } elseif ($path == "players/{id}/assessments") {
                    if ($user->player->id == Route::input('id')) {
                        return $next($request);
                    }
                }
            }

            return redirect('error');
        }
    }
}