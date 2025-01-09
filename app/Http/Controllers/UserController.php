<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Mail;
use PDF;
use App\Mail\CIMSMail;
use App\Models\Signature;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Branch;
use App\Models\Role;
use App\Models\Agencyname;
use App\Models\Agencytype;
use App\Models\Bank;
use App\Models\Bankaccounttype;
use App\Http\Controllers\UserMapping;
use DB;

class UserController extends Controller
{
    public function index()
    {   
        $users        = User::where("accept_status", "=", 'Not Accepted')->get();
        $roles        = Role::get();
    
        return view('users.index',compact('users','roles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
     
   
    public function create()
    {
        return view('users.create');
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            
        ]);
    
        User::create($request->all());
     
        return redirect()->route('users.index')
                        ->with('success','Product created successfully.');
    }
     
   
    public function show(User $user)
    {
        return view('users.show',compact('user'));
    } 
     
    
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }
    
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            
        ]);
    
        $user->update($request->all());
    
        return redirect()->route('users.index')
                        ->with('success','user updated successfully');
    }
    
    

// added by jigme

    public function UserProfile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('users.profile',compact('adminData'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully', 
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
        
    } // End Method 

    public function Profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('users.profile',compact('adminData'));

    }// End Method 

    public function EditProfile(){

        $id = Auth::user()->id;
        $editData = User::find($id);
        return view('users.admin_profile_edit',compact('editData'));
    }// End Method 

    public function StoreProfile(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if ($request->file('profile_image')) {
        $file = $request->file('profile_image');

        $filename = date('YmdHi').$file->getClientOriginalName();
        $file->move(public_path('upload/admin_images'),$filename);
        $data['profile_image'] = $filename;
        }
        $data->save();


        $notification = array(
            'message' => 'Admin Profile Updated Successfully', 
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);

    }// End Method

    public function ChangePassword(){

        return view('admin.admin_change_password');

    }// End Method


    public function UpdatePassword(Request $request){

        $validated = $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required | same:newpassword',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword,$hashedPassword )) {
            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password Updated Successfully');

            return redirect()->back();
        } else{

            session()->flash('message','old password is not matched');

            return redirect()->back();
        }

    }// End Method
  
    public function approve(Request $request, User $user)
    {
        
        $name         = $request->input('name');
        $email        = $request->input('email');
        $role         = $request->input('role');
        
        $email_data   = array(
            'name' => $name,
            'email' => $email,
        );
        if($request->has('approve'))
        {
           
            $data["email"] = $email;
            $data["title"] = "Registration Accepted";
            $data["body"] = " Your request for registration is successful. Please read the terms and conditions attached herewith and click the link below. ";
  
        // ?$pdf = PDF::loadView('emails.termsandconditions', $data);
  
            // Mail::send('emails.usersemail', $data, function($message)use($data, $pdf) {
            //     $message->to($data["email"], $data["email"])
            //         ->subject($data["title"])
            //         ->attachData($pdf->output(), "Terms & Conditions.pdf");});
             
            Mail::send('emails.usersemail', $data, function($message)use($data) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);});

            User::where('email', $email)
                ->update(array( 
                    'accept_status' => 'Accepted',
                    'role'=> $role));
         

                return redirect()->route('users.index')
          ->with('message','Successfully Accepted!');
        }

        if($request->has('reject'))
        {
           
            $data["email"] = $email;
            $data["title"] = "Registration Rejected";
            $data["body"] = "Your request for registration is rejected";
     
            Mail::send('emails.adminemail', $data, function($message)use($data) {
                $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
                });
    
            User::where('email', $email)
                   ->update(['accept_status' => 'Rejected']);
                   return redirect()->route('users.index')
                   ->with('message','Successfully Rejected!');
        }
    }

    
    public function user_show()
    {   
        $uu  = User::latest()->get();
            
        return view('/users/user_show',compact('uu'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function user_mapping_show()
    {
        $mappings = UserMapping::get();
        return view('/users/user_mapping_show',compact('uu'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function update_password(Request $request, User $user)
    {

        $this->validate($request, [
            
            'email' => 'email',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);

        $email        = $request->input('email');
        $password     = Hash::make($request->input('password'));
        $question     = $request->input('question');
        $answer       = $request->input('answer');
        User::where('email', $email)
                    ->update(array(
                    'password'=>$password,
                    'security_question'=>$question,
                    'security_answer'=>$answer,
                    'status'=>1));
                   // return redirect()->route('home');
                    return view('auth/login')
                    ->with('message','Password Created Successfully! Please login');

    }
    
    public function role_show()
    {
        $roles = Role::get();
    
        return view('users.role_show',compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function addrole(Request $request)
    {
        $request->validate([
            'role_add' => 'required|unique:roles,role_name',
            
        ]);

        $role          = $request->input('role_add');

        Role::create([
            'role_name' => $role
        ]);
        $roles = Role::get();
    
        return view('users.role_show',compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function deleterole(Role $roles)
    {
        $roleid = Route::current()->parameter('role_id');

        DB::delete('delete from roles where role_id = ?',[$roleid]);

        $roles = Role::get();
    
        return view('users.role_show',compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function agency_show()
    {
        $agencies = Agencyname::get();
    
        return view('users.agency_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function addagency(Request $request)
    {
        $request->validate([
            'agency_add' => 'required|unique:agencynames,agency_name_id',
            
        ]);

        $agency          = $request->input('agency_add');

        Agencyname::create([
            'agency_name' => $agency
        ]);
        
        $agencies = Agencyname::get();
    
        return view('users.agency_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function addbranch(Request $request)
    {
        $request->validate([
            'branch_add' => 'required|unique:branches,branch_name',
            
        ]);

        $branch          = $request->input('branch_add');

        Branch::create([
            'branch_name' => $branch
        ]);
        
        $branches = Branch::get();
    
        return view('users.branch_show',compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function deleteagency(Agencyname $roles)
    {
        $agencyid = Route::current()->parameter('agency_name_id');

        DB::delete('delete from agencynames where agency_name_id = ?',[$agencyid]);

        $agencies = Agencytype::get();
    
        return view('users.agency_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function deletebranch(Branch $branch)
    {
        $branchid = Route::current()->parameter('branch_id');

        DB::delete('delete from branches where branch_id = ?',[$branchid]);

        $branches = Branch::get();
    
        return view('users.branch_show',compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function agencytype_show()
    {
        $agencies = Agencytype::get();
    
        return view('users.agencytype_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function addagencytype(Request $request)
    {
        $request->validate([
            'agencytype_add' => 'required|unique:agencytypes,agency_name_id',
            
        ]);

        $agency          = $request->input('agencytype_add');

        Agencytype::create([
            'agency_name' => $agency
        ]);
        
        $agencies = Agencytype::get();
    
        return view('users.agencytype_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function deleteagencytype(Agencytype $roles)
    {
        $agencyid = Route::current()->parameter('agency_name_id');

        DB::delete('delete from agencytypes where agency_name_id = ?',[$agencyid]);

        $agencies = Agencytype::get();
    
        return view('users.agencytype_show',compact('agencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function bank_show()
    {
        $banks = Bank::get();
    
        return view('users.bank_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function addbank(Request $request)
    {
        $request->validate([
            'bank_add' => 'required|unique:banks,bank',
            
        ]);

        $bank          = $request->input('bank_add');

        Bank::create([
            'bank' => $bank
        ]);
        
        $banks = Bank::get();
    
        return view('users.bank_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function deletebank(Bank $bank)
    {
        $bankid = Route::current()->parameter('b_id');

        DB::delete('delete from banks where b_id = ?',[$bankid]);

        $banks = Bank::get();
    
        return view('users.bank_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function bankaccount_show()
    {
        $banks = Bankaccounttype::get();
    
        return view('users.bankaccount_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function addbankaccount(Request $request)
    {
        $request->validate([
            'bankaccount_add' => 'required|unique:bankaccounttypes,accountType',
            
        ]);

        $bank          = $request->input('bankaccount_add');

        Bankaccounttype::create([
            'accountType' => $bank
        ]);
        
        $banks = Bankaccounttype::get();
    
        return view('users.bankaccount_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function deletebankaccount(Bank $bank)
    {
        $bankid = Route::current()->parameter('acc_id');

        DB::delete('delete from bankaccounttypes where acc_id = ?',[$bankid]);

        $banks = Bankaccounttype::get();
    
        return view('users.bankaccount_show',compact('banks'))
            ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function branch_show()
    {
        $branches = Branch::get();
    
        return view('users.branch_show',compact('branches'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        
    }

    public function showregisterpage()
    {   
            
        return view('/users/user_show',compact('uu'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}