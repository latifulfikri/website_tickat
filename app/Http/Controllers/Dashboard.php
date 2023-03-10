<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use App\Models\TicketRedeem;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\EventSales;
use App\Models\EventSalesPerMonth;

class Dashboard extends Controller
{
    public function index()
    {
        if(!Session::get('Login') || Session::get('LoginRole') != 'Master')
        {
            return redirect('/login/master')->with('status', 'You have to login first!');
        }

        $eventSales = EventSales::take(3)->orderBy('JumlahPenjualan','DESC')->get();
        $redeems = TicketRedeem::where('Status','=','PENDING')->get();
        $eventHighSold = EventSalesPerMonth::where('month','=',date_format(Carbon::now(),'Y-m'))->orderBy('JumlahPenjualan','DESC')->first();

        return view('dashboard.index',['redeems'=>$redeems,'eventSales'=>$eventSales,'eventHighSold'=>$eventHighSold]);
    }

    public function EventOrganizer()
    {
        if(!Session::get('Login') || Session::get('LoginRole') != 'EventOrganizer')
        {
            return redirect('/login/event-organizer')->with('status', 'You have to login first!');
        }

        $upcomingEvents = Event::with(['EventOrganizer','EventType'])->where('EventOrganizerId','=',Session::get('LoginId'))->where('EventStart','>',Carbon::now())->orderBy('EventStart','ASC')->skip(1)->take(3)->get();
        $upcomingEvent = Event::with(['EventOrganizer','EventType'])->where('EventOrganizerId','=',Session::get('LoginId'))->where('EventStart','>',Carbon::now())->orderBy('EventStart','ASC')->first();
        
        // count days
        $curdate = new DateTime();
        if($upcomingEvent == NULL) {
            $eventDate = new DateTime();
            $soldCount = null;
        } else {
            $eventDate = new DateTime($upcomingEvent->EventStart);

            $soldCount = TicketRedeem::whereHas('Ticket', function($query) use($upcomingEvent){
            $query->where('EventId','=',$upcomingEvent->EventId);
        })->count();
        }
        
        $interval = $curdate->diff($eventDate);
        $daystogo = $interval->format('%a');

        

        $eventSales = EventSales::where('EventOrganizerId','=',Session::get('LoginId'))->get();

        return view('dashboard.my-event',['upcomingEvents'=>$upcomingEvents,'upcomingEvent'=>$upcomingEvent,'daystogo'=>$daystogo,'soldCount'=>$soldCount,'eventSales'=>$eventSales]);
    }
}
