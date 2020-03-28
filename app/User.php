<?php

namespace App;

use DB;
use App\BaseModel;
use App\Mail\UserCreated;
use App\Notifications\WelcomeUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password', 'user_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUsersWithType()
    {
        $sql = "SELECT users.*, user_types.type as user_type FROM users
        JOIN user_types
        on users.user_type = user_types.id";
        return DB::select($sql);
    }

    public function parentDetails($usertype, $parent)
    {
        $sql = "select * from users where user_type='$usertype' and ($parent)";
        return \DB::select($sql);
    }

    public function getUserWithType($userId)
    {
        return self::where('users.id', $userId)
            ->join('user_types', 'users.user_type', '=', 'user_types.id')
            ->select('users.email', 'users.name', 'users.id', 'users.profile_picture', 'user_types.type as type')
            ->first();
    }

    public function getType()
    {
        $type = \DB::table('user_types')->where('id', $this->user_type)->first()->type;
        return $type;
    }

    public function sendWelcomeEmail()
    {
        if (App::environment('demo')) {
            return;
        }

        $token = app('auth.password.broker')->createToken($this);;

        \DB::table(config('auth.passwords.users.table'))->insert([
            'email' => $this->email,
            'token' => $token
        ]);

        $resetUrl = url(config('app.url') . route('password.reset', $token, false));

        $this->notify(new WelcomeUser($this, $resetUrl));
    }

    public function getPlayerAttribute()
    {
        $player = Player::where('user_id', $this->id)->first();
        return $player;
    }
}
