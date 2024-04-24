<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Academic_experience;
use App\Models\Professional_experience;
use App\Models\Cv;
use PDF;

class CVController extends Controller
{

    public function if_blue_template(Request $request){
        $previousUrl = $request->headers->get('referer');// collect previous url 
        $template = strpos($previousUrl, 'blue') !== false ? 'blue' : 'red'; // set if this is blue or red template
        if ($template === 'blue'){
            return true;
        }else{
            return false;
        }
    }
    //POST 
    public function add_cv(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template

        // check if inputs are correctly filled
        request()->validate([
            'cv_title' => ['required'],
        ]);
        
        $cv = $user->cvs()->create([
            'template' => $template,
            'title' => request('cv_title'),
            'pdf_path' => '',
        ]);
        return redirect()->back();
    }
    //GET
    public function blue_template(){
        $user = auth()->user(); // collect connected user
        $cv = Cv::where('user_id', $user->id)->where('template', 'blue')->first();

        //load user's data
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $phone_number = $user->phone_number;

        //load cv's data
        if ($cv){
            $professional_experiences = Professional_experience::where('cv_id', $cv->id)->get();
            $academic_experiences = Academic_experience::where('cv_id', $cv->id)->get();
            $hobbies = Hobby::where('cv_id', $cv->id)->get();
        }else{
            $professional_experiences = [];
            $academic_experiences = [];
            $hobbies = [];
        }
        return view('blue-template', compact('first_name','last_name','email','phone_number','professional_experiences','academic_experiences','hobbies','cv'));
    }

    //GET
    public function red_template(){
        $user = auth()->user(); // collect connected user
        $cv = Cv::where('user_id', $user->id)->where('template', 'red')->first();

        //load user's data
        $first_name = $user->first_name;
        $last_name = $user->last_name;
        $email = $user->email;
        $phone_number = $user->phone_number;

        //load cv's data
        if ($cv){
            $professional_experiences = Professional_experience::where('cv_id', $cv->id)->get();
            $academic_experiences = Academic_experience::where('cv_id', $cv->id)->get();
            $hobbies = Hobby::where('cv_id', $cv->id)->get();
        }else{
            $professional_experiences = [];
            $academic_experiences = [];
            $hobbies = [];
        }
        return view('red-template', compact('first_name','last_name','email','phone_number','professional_experiences','academic_experiences','hobbies','cv'));
    }

    //POST
    public function add_hobby(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user

        // check if inputs are correctly filled
        request()->validate([
            'description' => ['required'],
        ]);

        // create new hobby for the connected user
        $hobby = $cv->hobbies()->create([
            'description' => request('description'),
        ]);

        return redirect()->back();
    }

    public function delete_hobby(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user with the good template


        // check if the request contains the hobby ID to delete
        if ($request->has('hobby_id')) {
            $hobby_id = $request->input('hobby_id');// get the ID of the hobby to delete
            $hobby = Hobby::find($hobby_id); // get the hobby associated with the provided ID

            // checks if the hobby exists and belongs to the logged in user
            if ($hobby && $hobby->cv_id === $cv->id) {
                $hobby->delete();// delete hobby
            }
        }
        return redirect()->back();
    }

    public function add_academic_experience(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user

        // check if inputs are correctly filled
        request()->validate([
            'name' => ['required'],
            'location' => ['required'],
            'description' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        // create new academic experience for the connected user
        $academic_experience = $cv->academic_experiences()->create([
            'name' => request('name'),
            'location' => request('location'),
            'description' => request('description'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
        return redirect()->back();
    }

    public function delete_academic_experience(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user with the good template

        // check if the request contains the academic experience ID to delete
        if ($request->has('academic_experience_id')) {
            $academic_experience_id = $request->input('academic_experience_id');// get the ID of the academic experience to delete
            $academic_experience = Academic_experience::find($academic_experience_id); // get the academic experience associated with the provided ID

            // checks if the academic experience exists and belongs to the logged in user
            if ($academic_experience && $academic_experience->cv_id === $cv->id) {
                $academic_experience->delete();// delete academic experience
            }
        }
        return redirect()->back();
    }

    public function add_professional_experience(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user

        // check if inputs are correctly filled
        request()->validate([
            'name' => ['required'],
            'location' => ['required'],
            'description' => ['required'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
        
        // create new professional experience for the connected user
        $professional_experience = $cv->professional_experiences()->create([
            'name' => request('name'),
            'location' => request('location'),
            'description' => request('description'),
            'start_date' => request('start_date'),
            'end_date' => request('end_date'),
        ]);
        return redirect()->back();
    }

    public function delete_professional_experience(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue' : 'red'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->where('template', $template)->first(); // collect the cv according to the user with the good template

        // check if the request contains the professional experience ID to delete
        if ($request->has('professional_experience_id')) {
            $professional_experience_id = $request->input('professional_experience_id');// get the ID of the professional experience to delete
            $professional_experience = Professional_experience::find($professional_experience_id); // get the professional experience associated with the provided ID

            // checks if the professional experience exists and belongs to the logged in user
            if ($professional_experience && $professional_experience->cv_id === $cv->id) {
                $professional_experience->delete();// delete professional experience
            }
        }
        return redirect()->back();
    }

    public function generate_cv(Request $request){
        $user = auth()->user(); // collect connected user
        $template = $this->if_blue_template($request) ? 'blue-template' : 'red-template'; // init blue or red template
        $cv = Cv::where('user_id', $user->id)->first(); // collect the cv according to the user
    
        //load cv's data
        $professional_experiences = Professional_experience::where('cv_id', $cv->id)->get();
        $academic_experiences = Academic_experience::where('cv_id', $cv->id)->get();
        $hobbies = Hobby::where('cv_id', $cv->id)->get();

        $pdf = PDF::loadView($template, compact('professional_experiences', 'academic_experiences', 'hobbies','cv')); // import infos into the view

        $pdfPath = public_path('cv.pdf'); // pdf path to save
        $pdf->save($pdfPath); // save pdf locally

        // create à CV for the connected user
        $cv->update([
            'pdf_path' => $pdfPath,
        ]);
    
        return response()->download($pdfPath); // download the pdf and delete
    }
}