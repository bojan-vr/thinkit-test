<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\Notification;
use App\Models\Rank;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::with(['created_by_user'])->orderBy('created_at', 'Desc')->get();
        return view('pages.notifications')
            ->with([
                'notifications' => $notifications
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ranks = Rank::get();
        return view('pages.createNotification')
            ->with([
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
            'notification' => 'required',
            'ranks' => 'required'
        ]);

        /** 
         * Save wysiwyg to database just for test reasons 
         * better option is to save to cloud services
         * */
        $editor_content=$request->notification;
        $dom = new \DomDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHtml($editor_content);

        $editor_content_save= $dom->saveHTML();
        $notification = new Notification();
        $notification->name = $request->name;
        $notification->content = $editor_content_save;
        $notification->created_by = auth()->user()->id;
        $notification->save();
        foreach($request->ranks as $rank) {
            $notification->ranks()->attach($rank);
        }
        return redirect()->route('notifications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notification = Notification::with(['created_by_user','ranks.crew'])->find($id);
        return view('pages.notioficationDetails')
            ->with([
                'notification' => $notification
            ]);
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
        $ship = Notification::find($id);
        $ship->delete();
        return response()->json(['status' => true]);
    }

    public function sendNotification($id) {
        $notification = Notification::with(['ranks.crew'])->find($id);
        $mailTo = [];
        foreach($notification->ranks as $rank) {
            foreach($rank->crew as $crew) {
                array_push($mailTo, $crew->email);
            }
        }
        $mail = Mail::to($mailTo)->send(new NotificationMail($notification->content, $notification->name));
        return response()->json(['status' => true]);
    }
}
