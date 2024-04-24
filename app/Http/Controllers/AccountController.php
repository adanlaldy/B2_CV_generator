<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\CVController;
use App\Models\User;
use App\Models\Hobby;
use App\Models\Academic_experience;
use App\Models\Professional_experience;
use App\Models\Cv;
use PDF;

class AccountController extends Controller
{    
    //GET
    public function home()
    {
        $user = auth()->user(); // collect connected user
        $cvs_list = Cv::where('user_id', $user->id)->get();

        return view('my-account',compact('cvs_list'));
    }
    //POST
    public function logout(){
        auth()->logout(); // logout
        return redirect('/'); // redirection to home page
    }
    //POST
    public function templates_form(){
        return redirect('/templates');
    }
    //GET
    public function form(){
        return view('/templates');
    }
    //POST
    public function templates_handling(Request $request){
        // check if the button blue or red is pressed and redirect to the good template
        if($request->submit == "blue"){
            return redirect('/blue-template');
        }else if ($request->submit=="red") {
            return redirect('/red-template');
        }
    }
    //DELETE
    public function delete_cv(Request $request)
    {
        $user = auth()->user(); // collect connected user
        // check if the request contains the CV ID to delete
        if ($request->has('cv_id')) {
            $cv_id = $request->input('cv_id');// get the ID of the CV to delete
            $cv = Cv::find($cv_id); // get the CV associated with the provided ID

            // checks if the CV exists and belongs to the logged in user
            if ($cv && $cv->user_id === $user->id) {
                $cv->delete();// delete CV
            }
        }
        return redirect()->back();
    }
    //POST
    public function download_cv(Request $request){
        $user = auth()->user(); // collect connected user
        // check if the request contains the CV ID to download
        if ($request->has('cv_id')) {
            $cv_id = $request->input('cv_id');// get the ID of the CV to delete
            $cv = Cv::find($cv_id); // get the CV associated with the provided ID

            // checks if the CV exists and belongs to the logged in user
            if ($cv && $cv->user_id === $user->id) {


                if ($cv->pdf_path != ''){ // check if already downloaded
                    $cv = Cv::where('user_id', $user->id)->first(); // collect the cv according to the user
                    return response()->download($cv->pdf_path);
                } else { // if not already downloaded

                    //load cv's data
                    $professional_experiences = Professional_experience::where('cv_id', $cv->id)->get();
                    $academic_experiences = Academic_experience::where('cv_id', $cv->id)->get();
                    $hobbies = Hobby::where('cv_id', $cv->id)->get();

                    $pdf = PDF::loadView($cv->template . '-template', compact('professional_experiences', 'academic_experiences', 'hobbies','cv')); // import infos into the view

                    $pdfPath = public_path('cv.pdf'); // pdf path to save
                    $pdf->save($pdfPath); // save pdf locally

                    // create à CV for the connected user
                    $cv->update([
                        'pdf_path' => $pdfPath,
                    ]);
                    return response()->download($pdfPath); // download the pdf and delete
                }
            }
        }
            return redirect()->back();
    }
    //UPDATE
    public function update_cv(Request $request){
        $user = auth()->user(); // collect connected user
        // check if the request contains the CV ID to download
        if ($request->has('cv_id')) {
            $cv_id = $request->input('cv_id');// get the ID of the CV to delete
            $cv = Cv::find($cv_id); // get the CV associated with the provided ID
        
            // checks if the CV exists and belongs to the logged in user
            if ($cv && $cv->user_id === $user->id) {
                
                if ($cv->template == 'blue'){
                    return redirect('/blue-template');
                } else{
                    return redirect('/red-template');
                }
            }   
        }
        return redirect()->back();
    }
}
