<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Customer as CModel;
use App\Models\Event as EModel;
use App\Models\EventOrganizer as EOModel;
use App\Models\EventType as ETModel;
use App\Models\Ticket as TModel;
use App\Models\TicketRedeem as TRModel;
use App\Models\Payment as PModel;

class MyTicket extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redeem = TRModel::with(['Customer','Ticket','Payment'])->where('CustomerId','=',Session::get('LoginId'))->where('Status','=','READY')->get();

        return view('customer.dashboard.index',['redeems' => $redeem]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'paymentMethod' => 'required|not_in:0'
        ]);

        $date = new \DateTime('NOW');
        
        $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $int = '0123456789';

        // buat payment
        $paycode = '';
        do {
            $generate = '';
            for ($i = 0; $i < 3; $i++) {
            $generate .= $char[rand(0, 26 - 1)];
            }
            for ($i = 3; $i < 16; $i++) {
                $generate .= $int[rand(0, 10 - 1)];
            }
            $paycode = $generate;
        } while (PModel::where('PaymentCode')->count() > 0);

        // buat redeem
        $code = '';
        do {
            $generate = '';
            for ($i = 0; $i < 3; $i++) {
            $generate .= $char[rand(0, 26 - 1)];
            }
            for ($i = 3; $i < 16; $i++) {
                $generate .= $int[rand(0, 10 - 1)];
            }
            $code = $generate;
        } while (TRModel::where('RedeemCode')->count() > 0);

        // store trm
        $data = [
            'CustomerId' => Session::get('LoginId'),
            'TicketId' => $request->id,
            'RedeemCode' => $code,
            'Status' => 'PENDING',
        ];

        $ticketredeem = TRModel::create($data);

        // payment
        $pay = [
            'TicketRedeemId' => $ticketredeem->TicketRedeemId,
            'PaymentMethod' => $request->paymentMethod,
            'PaymentCode' => $paycode,
            'PaymentVerification' => 'PENDING',
            'PaymentTime' => $date->format('Y-m-d H:i:s')
        ];

        $payment = PModel::create($pay);

        $ticket = TModel::find($request->id);

        $ticket->TicketAmount = $ticket->TicketAmount-1;

        $ticket->save();

        return redirect('/my-ticket/book')->with('status', 'Your ticket is waiting to finish the payment!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $redeem = TRModel::with(['Customer','Ticket','Payment'])->find($id);
        return view('customer.dashboard.ticket',['redeem' => $redeem]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
