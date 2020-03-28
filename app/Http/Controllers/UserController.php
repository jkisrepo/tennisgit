<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\UserType;
use App\User;
use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use Excel;
use Carbon\Carbon;
use App\Player;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{

    private $user;
    private $userType;

    public function __construct(User $user, UserType $userType)
    {
        parent::__construct();
        $this->user = $user;
        $this->userType = $userType;
    }

    public function index(Request $request)
    {

        $type = $request->type;
        $userType = $this->userType::where('type', $type)
            ->first();

        if ($userType) {
            $id = $userType->id;
            $users = $this->user->select('users.*', 'user_types.type')
                ->where('user_type', $id)
                ->join('user_types', 'user_types.id', '=', 'users.user_type');

            if ($request->has('searchColumn') && $request->has('searchBy')) {

                $column = $request->searchColumn;
                $searchBy = $request->searchBy;

                $users->where($column,  'iLIKE', '%' . $searchBy . '%');
            }
            $users = $users->paginate(10);
        } else {
            return redirect('users?type=admin');
        }

        foreach ($users as $user) {
            $user->image = asset('images') . '/' . $user->profile_picture;
        }

        return view('users', ['users' => $users]);
    }

    public function createUser(Request $request)
    {
        \Session::forget('_old_input');

        $userType = $this->userType::where('type', $request->type)
            ->first();

        if ($userType != null) {

            return view('add_user', ['user_types' => $userType]);
        } else {
            return redirect('users?type=admin');
        }
    }

    public function newUser(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);

        if ($validate->fails()) {
            return back()->with('ErrorMessage', config('strings.warning.already_registered'));
        }

        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_-=+?";
        $key = substr(str_shuffle($chars), 0, 8);


        $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_-=+?";
        $password = substr(str_shuffle($chars1), 0, 6);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($password);
        $user->user_type = $request->usertype;
        $user->verified = 1;


        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = str_replace(" ", "_", $user->name) . '_' . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path() . '/images', $fileName);
            $user->profile_picture = $fileName;
        }
        $user->save();
        $user->sendWelcomeEmail();

        if ($request->has('addNew')) {

            return back()->with('message', config('strings.success.user_added'));
        } else {
            return redirect('users?type' . $request->type)->with('message', config('strings.success.match_added'));
        }
    }

    public function editUser($id, Request $request)
    {
        $userType = $this->userType::where('type', $request->type)
            ->first();
        if ($userType != null) {

            \Session::flash('_old_input', User::find($id));
            return view('add_user', ['user_types' => $userType]);
        } else {
            return redirect('users?type=admin');
        }
    }

    public function viewUser($id, Request $request)
    {

        $userType = userType::where('type', $request->type)
            ->first();
        if (($userType)) {
            \Session::flash('_old_input', User::find($id));
            return view('view_user', ['user_types' => $userType]);
        } else {
            return redirect('users?type=admin');
        }
    }

    public function updateUser($id, Request $request)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            if ($request->email != $user->email) {
                $validate = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users'
                ]);
                if ($validate->fails()) {
                    return response('Email exists', 400);
                }
            }
            $user->email = $request->email;

            $user->user_type = $request->usertype;


            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fileName = str_replace(" ", "_", $user->name) . '_' . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/images', $fileName);
                $user->profile_picture = $fileName;
            }

            $user->save();
            return back()->with('message', config('strings.success.user_updated'));
        } else {
            return response('Invalid user', 400);
        }
    }

    public function deleteUser($id)
    {

        $userType = userType::where('type', 'admin')->first();

        $user = User::find($id);

        if ($user->user_type == $userType->id) {

            $count = User::where('user_type', $user->user_type)->count();
            if ($count > 1) {

                User::find($id)->delete();
            } else {
                return "false";
            }
        } else {

            User::find($id)->delete();
        }

        return "true";
    }

    public function changePassword($id, Request $request)
    {
        $password = $request->password;
        $user = $this->user->find($id);
        $user->password = Hash::make($password);
        $user->save();

        return back()->with('message', config('strings.success.changePassword'));
    }


    public function changeMyPassword(Request $request)
    {

        $id = $this->sessionUserId;
        $type = $this->sessionUserType;

        if ($type == "player") {

            $user = User::join('players', 'players.user_id', '=', 'users.id')
                ->where('players.id', $id)
                ->select('users.*')
                ->first();
            $id = $user->id;
        }


        $password = $request->password;

        $user = $this->user->find($id);
        $user->password = md5($password);
        $user->save();

        return back()->with('message', config('strings.success.changePassword'));
    }

    public function profile()
    {

        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $sessionUser = auth()->user();
        $id = $sessionUser->id;
        $type = $sessionUser->getType();

        if ($type == "player") {

            $userDetails = User::join('players', 'players.user_id', 'users.id')
                ->where('players.id', $id)
                ->select('users.*')
                ->first();

            $id = $userDetails->id;
        }

        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;

            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $fileName = str_replace(" ", "_", $user->name) . '_' . time() . "." . $file->getClientOriginalExtension();
                $file->move(public_path() . '/images', $fileName);
                $user->profile_picture = $fileName;
            }

            $user->save();
            $user->type = $sessionUser->type;
            $user->id = $sessionUser->id;
        }

        return back()->with('message', config('strings.success.profile_updated'));
    }

    public function usersExport(Request $request)
    {

        $userType = $this->userType->where('type', $request->type)
            ->first();
        if ($userType != null) {

            $id = $userType->id;
            $users = $this->user
                ->select('users.*', 'user_types.type')
                ->join('user_types', 'user_types.id', '=', 'users.user_type')
                ->where('user_type', $id)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            return redirect('users?type=admin');
        }

        Excel::create('Users', function ($excel) use ($users) {

            $excel->sheet('Sheetname', function ($sheet) use ($users) {

                $sheet->fromArray($users);
            });
        })->export('xls');

        return back();
    }

    public function forgotPassword()
    {

        return view('forgot_password');
    }

    public function forgotPasswordRequest(Request $request)
    {

        $email = $request->email;
        $userDetail = $this->user->where('email', $email)->first();


        if ($userDetail !== NULL) {

            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*_-=+?";
            $key = substr(str_shuffle($chars), 0, 8);


            $user = $this->user->find($userDetail->id);
            $user->verification_key = $key;
            $user->save();

            $link = url('/users/' . $user->id . '/reset_password/' . $key);

            $msg = config('strings.mailMsg.forgot_pass_msg');


            //send email

            return redirect('login')->with('message', config('strings.mailMsg.check_email'));
        } else {
            return back()->with('warning', config('strings.warning.invalid_login'));
        }
    }



    public function resetPasswordForm($id, $key)
    {

        $count = $this->user->where('id', $id)
            ->where('verification_key', $key)->count();

        if ($count > 0) {
            return view('reset_password')->withId($id);
        } else {
            return redirect('login')->with('warning', config('strings.warning.reset_invalid'));
        }
    }


    public function resetPassword($id, Request $request)
    {

        $user = $this->user->find($id);

        $user->password = Hash::make($request->password);
        $user->verification_key = NULL;
        $user->save();

        return redirect('login')->with('message', config('strings.success.changePassword'));
    }
}
