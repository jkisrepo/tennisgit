<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Academy;
use DB;
use Excel;
use App\User;
use App\UserType;
use App\Player;
use App\AcademyCoach;


class AcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function academies(Request $request)
    {

        $sql = DB::table('academy_court')
            ->select('court_types.court_type', 'academy_court.court_id')
            ->join('court_types', 'court_types.id', '=', 'academy_court.court_id');

        if ($request->has('academy')) {
            return $courts = $sql->where('academy_court.academy_id', $request->academy)
                ->get();
        }

        $academies = new Academy;

        if ($request->has('searchColumn') && $request->has('searchBy')) {
            $column = $request->searchColumn;
            $searchBy = $request->searchBy;

            $academies = $academies->where($column, 'iLIKE',  '%' . $searchBy . '%');
        }

        $academies = $academies->paginate(10);
        $players = [];
        $coaches = [];
        $courts  = [];
        foreach ($academies as $academy) {


            $courts[$academy->id] = $sql->where('academy_court.academy_id', $academy->id)
                ->get();

            $players[] = Player::where('academy_id', $academy->id)->count();

            $coaches[] = AcademyCoach::where('academy_id', $academy->id)->count();
        }

        return view('academies', ['academies' => $academies, 'courts' => $courts, 'players' => $players, 'coaches' => $coaches]);
    }

    public function academyForm()
    {
        $court_types = DB::table('court_types')->get();

        return view('add_academy', ['court_types' => $court_types]);
    }

    public function addAcademy(Request $request)
    {
        $academy = new Academy;

        $court_type = $request->court_type;
        $academy->title = $request->title;
        $academy->contact = $request->contact;
        $academy->country = $request->country;
        $academy->state = $request->state;
        $academy->city = $request->city;
        $academy->address = $request->address;
        $academy->save();

        $lastid = $academy->id;

        if (!empty($court_type)) {
            foreach ($court_type as $key => $value) {
                DB::table('academy_court')->insert(['academy_id' => $lastid, 'court_id' => $value]);
            }
        }

        if ($request->has('addNew')) {

            return back()->with('message', config('strings.success.academy_added'));
        } else {
            return redirect('academies')->with('message', config('strings.success.academy_added'));
        }
    }

    public function editAcademy($id)
    {

        $court_types = DB::table('court_types')->get();
        $academy = Academy::find($id);

        $academy_court = DB::table('academy_court')->where('academy_id', $id)->get(['court_id']);

        $values = array();
        foreach ($academy_court as $key => $value) {
            $values[] = $value->court_id;
        }

        return view('edit_academy', ['academy' => $academy, 'court_types' => $court_types, 'academy_court' => $values]);
    }


    public function updateAcademy(Request $request, $id)
    {

        $academy = Academy::find($id);

        $court_type = $request->court_type;
        $academy->title = $request->title;
        $academy->contact = $request->contact;
        $academy->country = $request->country;
        $academy->state = $request->state;
        $academy->city = $request->city;
        $academy->address = $request->address;
        $academy->save();

        DB::table('academy_court')->where('academy_id', $id)->delete();

        if (!empty($court_type)) {
            foreach ($court_type as $key => $value) {
                DB::table('academy_court')->insert(['academy_id' => $id, 'court_id' => $value]);
            }
        }
        return back()->with('message', config('strings.success.academy_updated'));
    }

    public function deleteAcademy($id)
    {
        Academy::find($id)->delete();
        return 'true';
    }

    public function viewAcademy($id)
    {

        $academy = Academy::find($id);

        $academy_court = DB::table('academy_court')
            ->where('academy_id', $id)
            ->get(['court_id']);

        $vals = array();
        foreach ($academy_court as $key => $value) {
            $values = DB::table('court_types')
                ->where('id', $value->court_id)
                ->select('court_type')
                ->first();

            $vals[] =  $values->court_type;
        }

        $academy_courts = implode(', ', $vals);

        return view('view_academy', ['academy' => $academy, 'academy_courts' => $academy_courts]);
    }

    public function academiesExport()
    {

        $academies = Academy::all();
        Excel::create('Academies', function ($excel) use ($academies) {

            $excel->sheet('Sheetname', function ($sheet) use ($academies) {

                $sheet->fromArray($academies);
            });
        })->export('xls');

        return back();
    }


    public function academyCoaches($id, Request $request)
    {

        $academy = Academy::find($id);

        $academyCoaches = DB::table('academy_coaches')
            ->select('academy_coaches.id', 'users.name', 'academies.title')
            ->join('users', 'users.id', '=', 'academy_coaches.coach_id')
            ->join('academies', 'academies.id', '=', 'academy_coaches.academy_id')
            ->where('academy_id', $id);
        $coaches = $academyCoaches->get();

        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column   = $request->searchColumn;
            $searchBy = $request->searchBy;

            $academyCoaches = $academyCoaches->where('users.name', 'ilike', '%' . $searchBy . '%');
        }

        $academyCoaches = $academyCoaches->paginate(10);


        return view('academy_coaches', ['academyCoaches' => $academyCoaches, 'academy' => $academy]);
    }




    public function academyCoachesAssignFrom($id)
    {

        $usertype = UserType::where('type', 'coach')->first();
        $assignedCoaches = \DB::table('academy_coaches')->where('academy_id', $id)->pluck('coach_id')->toArray();
        $coaches = User::where('user_type', $usertype->id)->whereNotIn('id', $assignedCoaches)
            ->get();
        return view('academy_assign_coach', ['coaches' => $coaches, 'academy' => $id]);
    }

    public function academyCoachesAdd($id, Request $request)
    {

        $coachids = $request->coachids;
        if ($coachids && count($coachids) > 0) {
            foreach ($coachids as $key => $value) {
                DB::table('academy_coaches')->insert(array('academy_id' => $id, 'coach_id' => $value));
            }
            return back()->with('message', config("strings.success.assign_coach"));
        }

        return back()->with('error', config("strings.warning.invalid_assign_coach"));
    }

    public function academyCoachDelete($id)
    {

        DB::table('academy_coaches')->delete($id);

        return back()->with('message', config("strings.success.delete_coach"));
    }


    public function academyCoachesExport($id)
    {

        $academyCoaches = AcademyCoach::where('academy_id', $id)->get();

        Excel::create('Academycoaches', function ($excel) use ($academyCoaches) {

            $excel->sheet('Sheetname', function ($sheet) use ($academyCoaches) {

                $sheet->fromArray($academyCoaches);
            });
        })->export('xls');

        return back();
    }

    public function academyPlayers($id, Request $request)
    {

        $academy = Academy::select('academies.title', 'academies.id')
            ->find($id);

        $players = Player::select('players.*', 'users.name as cname')
            ->join('users', 'users.id', '=', 'players.coachid')
            ->where('academy_id', $id);

        if ($request->has('searchColumn') && $request->has('searchBy')) {

            $column   = $request->searchColumn;
            $searchBy = $request->searchBy;

            if ($column == "coach") {
                $players->where('users.name', 'iLIKE', '%' . $searchBy . '%');
            } else {
                $players->where('players.' . $column, 'iLIKE', '%' . $searchBy . '%');
            }
        }

        $players = $players->paginate(10);


        return view('academy_players', ['players' => $players, 'academy' => $academy]);
    }



    public function academyPlayersExport($id)
    {

        $academyPlayres = Player::where('academy_id', $id)
            ->get();

        Excel::create('academy_players', function ($excel) use ($academyPlayres) {

            $excel->sheet('Sheetname', function ($sheet) use ($academyPlayres) {

                $sheet->fromArray($academyPlayres);
            });
        })->export('xls');

        return back();
    }
}