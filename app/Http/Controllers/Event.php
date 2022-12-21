<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event as EModel;
use App\Models\EventOrganizer as EOModel;
use App\Models\EventType as ETModel;

class Event extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = EModel::with(['EventOrganizer','EventType'])->get();
        return view('dashboard.event.index',['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $eos = EOModel::all();
        $ets = ETModel::all();
        return view('dashboard.event.create',['eos' => $eos,'ets' => $ets]);
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
            'name' => 'required',
            'eventOrganizer' => 'required|exists:EventOrganizer,EventOrganizerId',
            'eventType' => 'required|exists:EventType,EventTypeId',
            'description' => 'required',
            'eventStartDate' => 'required|date|after:today',
            'eventStartTime' => 'required',
            'eventEndDate' => 'required|date|after:today',
            'eventEndTime' => 'required',
            'eventLocation' => 'required',
            'gmapsCode' => 'required',
            'detailPlace' => 'required'
        ]);

        $data = [
            'EventName' => $request->name,
            'EventOrganizerId' => $request->eventOrganizer,
            'EventTypeId' => $request->eventType,
            'EventDesc' => $request->description,
            'EventStart' => $request->eventStartDate.' '.$request->eventStartTime,
            'EventEnd' => $request->eventEndDate.' '.$request->eventEndTime,
            'EventLocation' => $request->eventLocation,
            'EventGmapsCode' => $request->gmapsCode,
            'EventDetailPlace' => $request->detailPlace
        ];
        
        EModel::create($data);
        
        return redirect('/dashboard/event')->with('status', $request->name.' has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $eos = EOModel::all();
        $ets = ETModel::all();
        $es = EModel::find($id);
        $EventStart=  explode(" ", $es->EventStart );
        $EventEnd=  explode(" ", $es->EventEnd );

        return view('dashboard.event.edit',['eos' => $eos,'ets' => $ets, 'es' => $es, 'est' => $EventStart, 'een' => $EventEnd]);
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
        $request->validate([
            'name' => 'required',
            'eventOrganizer' => 'required|exists:EventOrganizer,EventOrganizerId',
            'eventType' => 'required|exists:EventType,EventTypeId',
            'description' => 'required',
            'eventStartDate' => 'required|date|after:today',
            'eventStartTime' => 'required',
            'eventEndDate' => 'required|date|after:today',
            'eventEndTime' => 'required',
            'eventLocation' => 'required',
            'gmapsCode' => 'required',
            'detailPlace' => 'required'
        ]);

        $event = EModel::find($id);

        $event->EventName = $request->name;
        $event->EventOrganizerId = $request->eventOrganizer;
        $event->EventTypeId = $request->eventType;
        $event->EventDesc = $request->description;
        $event->EventStart = $request->eventStartDate.' '.$request->eventStartTime;
        $event->EventEnd = $request->eventEndDate.' '.$request->eventEndTime;
        $event->EventLocation = $request->eventLocation;
        $event->EventGmapsCode = $request->gmapsCode;
        $event->EventDetailPlace = $request->detailPlace;

        $event->save();

        return redirect('/dashboard/event')->with('status', $request->name.' has been updated!');
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
