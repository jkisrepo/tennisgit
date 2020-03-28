<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Player;

use App\Assessment;

use App\User;

use App\UserType;

use Session;



class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCoachPlayersByMatch(Request $request)
    {

        $match = $request->match;
        $player1 = $request->player1;
        $player2 = $request->player2;

        $data = array();

        if (auth()->user()->getType() == "coach") {
            $coach = auth()->user()->id;

            $data[] = Player::where('id', $player1)
                ->where('coachid', $coach)
                ->first();

            $data[] = Player::where('id', $player2)
                ->where('coachid', $coach)
                ->first();
        } else {
            $data[] = Player::find($player1);

            $data[] = Player::find($player2);
        }

        foreach ($data as $key => $value) {
            if ($data[$key] == null) {
                unset($data[$key]);
            }
        }
        $data = array_values($data);

        return $data;
    }


    public function addAssessment(Request $request)
    {

        $assessment = new Assessment;
        $data['result'] = $assessment->addAssesment($request);


        return redirect("/players/$request->playerid/assessments?type=" . $data['result'])
            ->with('message', config('strings.success.assessment_added'));
    }

    public function updateAssessment($id, Request $request)
    {
        $assessment = new Assessment;
        $assessment->setFields($request->type);
        $result = $assessment->updateAssessment($id, $request);


        if ($result == true) {
            return back()->with('message', config('strings.success.assessment_updated'));
        }
    }
}