<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRegister extends Model
{
    use HasFactory;

    protected $table = 'event_register';

    protected $fillable = [
        'event_id', 'user_id'
    ];

    protected $dates = [
        'deleted_at','created_at', 'updated_at'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationship
    |--------------------------------------------------------------------------
    */
    /*
    |--------------------------------------------------------------------------
    | End Relationship
    |--------------------------------------------------------------------------
    */


    //get event list
    public function getEventList($selector="*", $order="ASC", $status="all")
    {
        $getEvent = EventRegister::select($selector)
                        ->orderBy('id',$order);

        return $getEvent->get();
    }

    public function getEventById($id)
    {
        $getData = EventRegister::find($id);

        return $getData;
    }
}

