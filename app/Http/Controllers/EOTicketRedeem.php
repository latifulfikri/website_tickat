<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\TicketRedeem as TRModel;
use App\Models\Customer as CModel;
use App\Models\Payment as PModel;
use App\Models\Ticket as TModel;
use App\Models\Event as EModel;
use App\Models\EventOrganizer as EOModel;

class EOTicketRedeem extends Controller
{
    public function index()
    {
        if(!Session::get('Login') || Session::get('LoginRole') != 'EventOrganizer')
        {
            return redirect('/login/event-organizer')->with('status', 'You have to login first!');
        } 

        $redeems = TRModel::whereHas('Ticket.Event', function($query){
            $query->where('EventOrganizerId','=',Session::get('LoginId'));
        })->get();
        
        return view('my-event.ticketreedem.index',['redeems' => $redeems]);
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show($id)
    {
        if(!Session::get('Login') || Session::get('LoginRole') != 'EventOrganizer')
        {
            return redirect('/login/event-organizer')->with('status', 'You have to login first!');
        }
        $redeems = TRModel::with(['Ticket.Event'])->where('TicketRedeemId','=',$id)->first();
        $event = EModel::where('EventId','=',$redeems->Ticket->EventId)->first();
        $EventStart=  explode(" ", $event->EventStart );
        $EventEnd=  explode(" ", $event->EventEnd );
        $ticket = TModel::find($redeems->TicketId);
        $payments = PModel::where('TicketRedeemId','=',$id)->orderBy('PaymentId','DESC')->get();

        $colors = [
            'primary',
            'secondary',
            'success',
            'info',
            'warning',
            'danger'
        
        ];
        return view ('my-event.ticketreedem.show',['redeems' => $redeems,'colors' => $colors,'EventStart' => $EventStart,'EventEnd' => $EventEnd,'event' => $event,'est' => $EventStart,'een' => $EventEnd,'ticket' => $ticket,'payments' => $payments]);
        }
        
    

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        
    }
}
