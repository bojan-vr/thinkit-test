<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ShipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ships = Ship::with(['created_by_user'])->get();
        return view('pages.ships')->with(['ships' => $ships]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.createShip');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:4',
            'image' => 'required|url',
        ]);
        
        $ship = new Ship();
        $ship->name = $request->name;
        $ship->image = $request->image;
        $ship->serial_number = Str::random(8);
        $ship->created_by = auth()->user()->id;
        $ship->save();

        return redirect()->route('ships.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ship = Ship::with(['crew.rank'])->find($id);
        return view('pages.shipDetails')->with(['ship' => $ship]);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ship = Ship::find($id);
        return view('pages.editShip')->with(['ship' => $ship]);   
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
        $validated = $request->validate([
            'name' => 'required|min:4',
            'image' => 'required|url',
        ]);
        
        $ship = Ship::find($id);
        $ship->name = $request->name;
        $ship->image = $request->image;
        $ship->save();

        return redirect()->route('ships.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ship = Ship::find($id);
        $ship->delete();
        return response()->json(['status' => true]);
    }

    /**
     * remove spacific crew from ship
     */
    public function removeCrewMember($id)
    {
        $crew = Crew::find($id);
        $crew->ship_id = null;
        $crew->save();
        return response()->json(['status' => true]);
    }
}
