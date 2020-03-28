<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\Player;

use App\Drill;

use App\Event;

use Excel;

use Session;

use Redirect;

use App\DrillImage;
use Carbon\Carbon;

class DrillsController extends Controller
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

    public function drills(Request $request)
    {

        if ($request->has('searchColumn') && $request->has('searchBy')) {
            $column = $request->searchColumn;
            $searchBy = $request->searchBy;
            $drills = Drill::where($column,  'iLIKE', '%' . $searchBy . '%')->paginate(10);
        } else {

            $allDrills = new Drill;
            $drills = $allDrills->paginate(10);
        }
        return view('drills', ['drills' => $drills]);
    }

    public function drillsForm()
    {

        return view('add_drills');
    }

    public function addDrills(Request $request)
    {

        $drill = new Drill;

        $drill->name = $request->title;
        $drill->description = $request->description;


        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileName = 'video_' . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/drill_files', $fileName);
            $drill->video_file = $fileName;
        }

        $drill->save();

        if ($request->hasFile('image_files')) {
            $files = $request->file('image_files');



            foreach ($files as $key => $file) {
                $fileName = 'image_' . $key . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/drill_files', $fileName);
                $drillImage = new DrillImage;
                $drillImage->drill_id    = $drill->id;
                $drillImage->drill_image = $fileName;

                $drillImage->save();
            }
        }

        if ($request->has('addNew')) {

            return back()->with('message', config('strings.success.drill_added'));
        } else {
            return redirect('/drills')->with('message', config('strings.success.drill_added'));
        }
    }

    public function deleteDrills($id)
    {
        Drill::find($id)->delete();

        return "true";
    }

    public function editDrills($id)
    {

        $drill = Drill::find($id);

        $drillImage = new DrillImage;

        $drill_images = $drillImage->where('drill_id', $id)->get();

        return view('edit_drills', ['drill' => $drill, 'drill_images' => $drill_images]);
    }


    public function updateDrills(Request $request, $id)
    {
        $drill = Drill::find($id);

        $drill->name = $request->title;
        $drill->description = $request->description;


        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $fileName = 'video_' . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/drill_files', $fileName);
            $drill->video_file = $fileName;
        }

        $drill->save();

        if ($request->hasFile('image_files')) {
            $files = $request->file('image_files');

            $drillId = $drill->id;
            foreach ($files as $key => $file) {
                $fileName = 'image_' . $key . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/drill_files', $fileName);
                $drillImage = new DrillImage;
                $drillImage->drill_id    = $drillId;
                $drillImage->drill_image = $fileName;

                $drillImage->save();
            }
        }
        return back()->with('message', config('strings.success.drill_updated'));
    }


    public function viewDrills($id)
    {
        $drill = Drill::find($id);
        $drillImage = new DrillImage;

        $drill_images = $drillImage->where('drill_id', $id)->get();
        return view('view_drills', ['drill' => $drill, 'drill_images' => $drill_images]);
    }

    public function assignDrills()
    {

        $sessionId = $this->sessionUserId;

        $sessionType = $this->sessionUserType;

        if ($sessionType == "coach") {

            $players = Player::where('coachid', $sessionId)
                ->get();
        } else {

            $players = Player::all();
        }

        $drills = Drill::all();

        return view('assign_drills', ['players' => $players, 'drills' => $drills]);
    }

    public function addAssignDrills(Request $request)
    {
        $playerDetail = Player::select('name')->where('id', $request->player)->first();

        $drillDetail = Drill::select('name')->where('id', $request->drill)->first();


        $event = new Event;

        $event->title = $playerDetail->name . "-" . $drillDetail->name;
        $event->type = 1;
        $event->date_time = Carbon::createFromFormat('d/m/Y h:i A', $request->date_time);

        $event->save();

        $data = ['player_id' => $request->player, 'drill_id' => $request->drill, 'event_id' => $event->id];

        $player_drill = DB::table('drill_players')->insert($data);

        return back()->with('message', config('strings.success.assign_drill'));
    }


    public function viewAssignDrills($id)
    {
        $user = auth()->user();
        $type = $user->getType();
        $drill = new Drill();
        if (
            $type == 'admin' ||
            ($type == 'coach' && $drill->checkDrillPlayerCoach($user->id, $id) ||
                ($type == 'player' && $drill->checkDrillPlayer($user->player->id, $id)))
        ) {
            $assignDrill = DB::table('drill_players')
                ->where('drill_players.id', $id)
                ->join('players', 'players.id', '=', 'drill_players.player_id')
                ->join('drills', 'drills.id', '=', 'drill_players.drill_id')
                ->join('events', 'events.id', '=', 'drill_players.event_id')
                ->select('events.date_time', 'players.name as player', 'drills.name as drill')
                ->first();

            return view('view_assign_drill', ['assignDrill' => $assignDrill]);
        }
        return redirect('error');
    }

    public function drillsExport()
    {

        $drills = drill::all();

        Excel::create('Drills', function ($excel) use ($drills) {

            $excel->sheet('Sheetname', function ($sheet) use ($drills) {

                $sheet->fromArray($drills);
            });
        })->export('xls');

        return back();
    }

    public function DrillsImageDelete($id)
    {

        DrillImage::find($id)->delete();
    }
}