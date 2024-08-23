<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

Use App\Models\User;
Use App\Models\Doctor;
Use App\Models\Appointment;



class HomeController extends Controller
{

    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0')
            { 
                /* Display doctor also in user page*/
                $doctor=doctor::all(); 
                return view ('user.home',compact('doctor'));
            }
            else
            {
                return view ('admin.home');
            }
        }
        else
        {
            return redirect()->back();
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::id())
        {
            return redirect('home');
        }
        else
        {
            
            $doctor=doctor::all();
            return view('user.home', compact('doctor'));
        }

    }

     /*request name,email,...,status. from the POST method on appointment.blade*/
    public function appointment(Request $request)
    {
        $data = new appointment;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->date=$request->date;
        $data->phone=$request->number;
        $data->message=$request->message;
        $data->doctor=$request->doctor;
        $data->status='In Progress';

        if(Auth::id())
        {
            $data->user_id=Auth::user()->id;
        }
       
        $data->save();

        return redirect()->back()->with('message','Appointment Request Successful. We will contact you soon');

    }

    /*user view the appointment my_appointment.blade*/
    public function myappointment()
    {
        /*the user will see appointment based on their own account*/
        if(Auth::id())
        {
            if(Auth::user()->usertype==0)
            {
                $userid=Auth::user()->id;

                $appoint=appointment::where('user_id',$userid)->get();
    
                return view('user.my_appointment',compact('appoint'));
            }

        
        
        }
        else
        {
            return redirect()->back();
        }
    }


     /*user delete the appointment my_appointment.blade*/
    public function cancel_appoint($id)
    {
        /*from table appointment find the id to delete*/
        $data=appointment::find($id);
        $data->delete();
        return redirect()->back();
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
