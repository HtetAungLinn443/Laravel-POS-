<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // User
    // User Contact Page
    public function contactPage(){
        return view('user.contact.contactForm');
    }

    // send contact info
    public function contactInfo(Request $request){
        $this->infoValidationCheck($request);
        $data = $this->requestContactInfo($request);
        Contact::create($data);
        return redirect()->route('user#home')->with(['response' => 'Your Suggession Send Finish...']);
    }

    // Info Validation Check
    private function infoValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'message' => 'required|min:5'
        ])->validate();
    }

    // contact info data
    private function requestContactInfo($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
    }

    // Admin
    // admin contact list page
    public function contactListPage(){
        $contact = Contact::paginate('3');
        return view('admin.contactList.list',compact('contact'));
    }

    // Admin Contact info
    public function adminContactInfo($id){
        $contactData = Contact::where('id',$id)->first();

        return view('admin.contactList.info',compact('contactData'));
    }

    // Delete Contact
    public function deleteContact($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleteSuccess' => 'Delete Success...']);
    }
}
