<?php

namespace App\Http\Controllers;

use App\Models\Crew;
use App\Models\Rank;
use App\Models\Ship;
use Illuminate\Http\Request;

class CrewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crew = Crew::with(['rank', 'ship', 'created_by_user'])->get();
        return view('pages.crewList')
            ->with([
                'crew' => $crew
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ships = Ship::get();
        $ranks = Rank::get();
        return view('pages.createCrew')
            ->with([
                'ships' => $ships,
                'ranks' => $ranks
            ]);
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
            'surname' => 'required|min:4',
            'email' => 'required|email'
        ]);

        $crew = new Crew();
        $crew->name = $request->name;
        $crew->surname = $request->surname;
        $crew->email = $request->email;
        $crew->ship_id = $request->ship;
        $crew->rank_id = $request->rank;
        $crew->created_by = auth()->user()->id;
        $crew->save();

        return redirect()->route('crew.index');

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
        $crew = Crew::find($id);
        $ships = Ship::get();
        $ranks = Rank::get();
        return view('pages.editCrew')
            ->with([
                'crew'  => $crew,
                'ships' => $ships,
                'ranks' => $ranks
            ]);
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
            'surname' => 'required|min:4',
            'email' => 'required|email'
        ]);

        $crew = Crew::find($id);
        $crew->name = $request->name;
        $crew->surname = $request->surname;
        $crew->email = $request->email;
        $crew->ship_id = $request->ship;
        $crew->rank_id = $request->rank;
        $crew->save();

        return redirect()->route('crew.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $crew = Crew::find($id);
        $crew->delete();
        return response()->json(['status' => true]);
    }
}
