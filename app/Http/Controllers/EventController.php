<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request['search']??"";
        $data['events'] = Event::orderBy('id','asc')->where('event_name', 'LIKE', "%$search%")->paginate(5);
        $data1['search'] = $search;
        return view('events.index',$data, $data1);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
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
           'event_name'=>'required',
            'event_description'=>'required',
            'event_time'=>'required'
        ]);

        $event = new Event;

        $event->event_name=$request->event_name;
        $event->event_description=$request->event_description;
        $event->event_time=$request->event_time;

        $event->save();

        return redirect()->route('event.index')->with('success','Event has been created successfully');
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
     * @param  \App\event $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit',compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event    $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'event_name'=>'required',
            'event_description'=>'required',
            'event_time'=>'required'
        ]);
        $event = Event::find($id);

        $event->event_name=$request->event_name;
        $event->event_description=$request->event_description;
        $event->event_time=$request->event_time;

        $event->save();

        return redirect()->route('event.index')->with('success','Event has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.index')->with('success','Event has been deleted successfully');
    }
}
