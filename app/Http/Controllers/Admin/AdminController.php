<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Doctor;
use App\Models\Appointment;

Use Notification;

use App\Notifications\SendEmailNotification;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addview()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype==1)
            {
                return view('admin.add_doctor');
            }
        
            else
            {
                return redirect()->back();
            }
            
        }

        else
        {
            return redirect('login');
        }
        
    }

    public function upload(Request $request)
    {
        $doctor=new doctor;
        $image=$request->file;
        $imagename=time().'.'.$image->getClientoriginalExtension();
        $request->file->move('doctorimage',$imagename);
        $doctor->image=$imagename;

        $doctor->name=$request->name;
        $doctor->phone=$request->number;
        $doctor->room=$request->room;
        $doctor->specialty=$request->speciality;

        $doctor->save();
        # with('...') to display u admin successfully add doctor
        return redirect()->back()->with('message','Doctor Added Successfully');

    }

    public function showappointment()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype==1)
            {
                # find and get all data from appointment table and use the appointment model.  1. all $data will be sent to the admin.showappointment
                $data=appointment::all();
                return view('admin.showappointment', compact('data'));
            }
            else
            {
                return redirect()->back();
            }

        }
        else 
        {
            return redirect ('login');
        }
    }

    public function approved($id)
    {
       #finding specific id on the table appointment
        $data=appointment::find($id);
        $data->status='approved';
        $data->save();
        return redirect()->back();
    }

    public function canceled($id)
    {
       
        $data=appointment::find($id);
        $data->status='canceled';
        $data->save();
        return redirect()->back();
    }


    public function showdoctor()
    {
        # 2. take all data in doctor table
        $data = doctor::all();
        # 1. create blade for showdoctor
        return view('admin.showdoctor',compact('data'));
    }

    #delete doctor in showdoctor.blade
    public function deletedoctor($id)
    {
       
        $data=doctor::find($id);
        #after find just delete
        $data->delete();
        return redirect()->back();
    }

    
    public function updatedoctor($id)
    {
        # 2. find some data in doctor table
        $data = doctor::find($id);
        # 1. create blade for updatedoctor
        return view('admin.update_doctor',compact('data'));
    }

    public function editdoctor(Request $request, $id)
    {
        $doctor = doctor::find($id);

        $doctor->name=$request->name;
        $doctor->phone=$request->phone;
        $doctor->specialty=$request->specialty;
        $doctor->room=$request->room;
        
        $image=$request->file;

        # 2. if admin put new image
        if($image)
        {
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->file->move('doctorimage',$imagename);
            $doctor->image=$imagename;
        }

        $doctor->save();
        return redirect()->back()->with('message','Doctor Details Updated Successfully');
    }

    # view mail
    public function emailview($id)
    {
        $data=appointment::find($id);
        return view('admin.email_view',compact('data'));
    }
   

    # send mail
    
    public function sendemail(Request $request, $id)
    {
        $data=appointment::find($id);
        
        # 1. $details from SendEmailNotification.php 2. $request from he form email_view.blade
            $details=[
                    'greeting' => $request->greeting,
                    'body' => $request->body,
                    'actiontext' => $request->actiontext,
                    'actionurl' => $request->actionurl,
                    'endpart' => $request->endpart,

            ];
    
            $data->notify(new SendEmailNotification($details));

            return redirect()->back()->with('message','Email send is successful');
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
