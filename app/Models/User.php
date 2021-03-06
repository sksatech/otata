<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */
    public function userinfo(){

        return $this->hasOne(UsersInfo::class,'user_id','id');
    }

    public function usersubscribe(){

        return $this->hasOne(UserSubscribe::class,'user_id','id');
    }

    /*
    |--------------------------------------------------------------------------
    | End Relationship
    |--------------------------------------------------------------------------
    */

    public function getUserList($selector="*", $order="ASC", $status="all" , $type="")
    {
        $getUser = User::select($selector)
                        ->with('userinfo');
        if($type!=""){
            $getUser = $getUser->where('type', $type); 
        }
        $getUser = $getUser->orderBy('id',$order);

        return $getUser->get();
    }

    public function getUserById($id)
    {
        $getData = User::find($id);

        return $getData;
    }
}
