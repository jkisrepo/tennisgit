<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;


class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public $sessionUserId;
    public $sessionUserType;


    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Auth::user()) {
                $session = auth()->user();
                $this->sessionUserId = $session->id;
                if (auth()->user()->getType() == 'player') {
                    $this->sessionUserId = $session->player->id;
                }
                $this->sessionUserType = $session->getType();
            }
            return $next($request);
        });
    }

    public function convertToDBDateTime($dateTime)
    {
        return Carbon::createFromFormat('d/m/Y h:i A', $dateTime);
    }

    public function convertToDBDate($date)
    {
        return Carbon::createFromFormat('d/m/Y', $date);
    }
}