<?php

namespace App\Http\Controllers;

use App\activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TimeSpentController extends Controller
{
    /** function index returns all data from table activities
    as object to index view */

    public function index(){
        $activities = activity::latest()->simplePaginate(10);
        return view('index', compact('activities'));
    }



    /** function store gets the inputs from the form, do some
    checking if the request is sent by our form, sanitize
    strings and do validation of all inputs */

    public function store(Request $request){

        //Check if the request url is same as this page url...

        $this_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        if($request->url() != $this_url){
            die("Please use input form.");
        }

        //Validate inputs...

        $this->validate($request,[
            'title'=>'required|max:150',
            'description'=>'nullable|max:2000',
            'time_spent'=>'required|numeric|min:1|max:525600',
        ]);

        //Get all inputs from $request into $activity array...

        $activity = $request->all();

        //Sanitize strings...

        $activity['title'] = trim(filter_var($activity['title'], FILTER_SANITIZE_STRING));
        $activity['description'] = trim(filter_var($activity['description'], FILTER_SANITIZE_STRING));

        if($activity['title']==""){
            return back()->withErrors("Please insert valid information in the input fields.");
        }

        //Save inputs to database...

        activity::create($activity);

        Session::flash('message', "Activity saved.");

        return redirect()->back();

    }


    public function destroy(Request $request){
        $id = $request->delete_activity_id;
        activity::findOrFail($id)->delete();
        Session::flash('message', "Activity deleted.");
        return redirect()->back();
    }



}
