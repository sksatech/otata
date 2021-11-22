<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Event;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('super');
    }

    public function payment()
    {
        $title = "Report Summary";

        return view('report.payment.index', compact('title'));
    }

    public function event()
    {
        $title = "Event Summary";
        
        $getEvent = (new Event())->getEventList("*", "ASC", "active");

        return view('report.event.index', compact('title', 'getEvent'));
    }
}
