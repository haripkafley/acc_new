<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Banner;
use App\Models\Contact;
use App\Mail\ContactMail;
use App\Mail\ResetPassword;
use App\Models\IndustryProfile;
use App\Models\IndustrySubmission;
use Mail;
use Auth;
use Hash;
use App\Models\Time;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logindata()
    {
        return view('auth.custom_login');
    }
    

    public function customLogin(Request $request)
    {
        $userDataEmail=User::where('email',$request->username)->first();
        if ($userDataEmail) {
          
           if (!\Hash::check($request->password,$userDataEmail->password)) {
               return redirect()->back()->with('error','Incorrect Password');
            }
   
            
            Auth::login($userDataEmail);
            if (auth()->user()->role=="IND") {
                return redirect()->route('industry.get.notification');
            }else{
                return redirect()->route('focal_dashboard');
            }
            
        }else{
            return redirect()->back()->with('error','Wrong Credentials Are Given');
        }
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();
        return $this->loggedOut($request) ?: redirect('/');
    }


    public function forgetShow()
    {
        return view('forget_password.forget_password');
    }

    public function forgetPassword(Request $request)
    {
        $getdata = User::where('email',$request->email)->first();
        if ($getdata === null) {
           return back()->with('error','This email is not registered yet');
        }else{
            $update_vcode = User::where('email',$request->email)->update(['email_vcode'=>time()]);
            $get_vcode = User::where('email',$request->email)->first();
             $data = [
                'email'=>$request->email,
                'name'=>$get_vcode->name,
                'email_vcode'=>$get_vcode->email_vcode,
                'id'=>$get_vcode->id,
                
            ];
            Mail::send(new ResetPassword($data));
            return back()->with('success','A reset password link send to your email');
        }
    }

    public function resetPassowrd($id,$vcode)
    {
       $data = User::where('email_vcode',$vcode)->where('id',$id)->first();
       if ($data===null) {
           return redirect()->route('login')->with('error','Link expired');
       }
       return view('forget_password.reset_password',compact('data'));
    }

    public function newPassword(Request $request)
    {
        $password = $request->input('password'); 
       
        $updatepassword = User::where('id',$request->id)->update([
            'password'=>Hash::make($password),
            'email_vcode'=>''
        ]); 

        return redirect()->route('login.data')->with('success','Password changed successfully');
    }


    public function homePage()
    {
        $data = [];
        $data['banner'] = Banner::get();
        $data['service'] = IndustryProfile::whereIn('inspect_one',['CSI-SERVICE','ML-SERVICE'])->count();
        
        
        $data['construction'] = IndustryProfile::whereIn('inspect_one',['CSI-CONSTRUCTION','ML-CONSTRUCTION'])->count();
        $data['pam'] = IndustryProfile::whereIn('inspect_one',['CSI-PAM','ML-PAM'])->count();
                $data['total'] = IndustryProfile::count();
        $data['domestic'] = IndustryProfile::whereIn('scale_investment',['M','L'])->count();
        $data['cottage'] = IndustryProfile::whereIn('scale_investment',['S','C'])->count();

        $data['foreign'] = IndustryProfile::where('type_of_investment','!=','D')->count();
        $data['notification'] = IndustrySubmission::where('data_type','N')->orderBy('publish_date','desc')->limit('4')->get();
        $data['data_submission'] = Time::whereIn('year',[date('Y'),date('Y')-1])->orderBy('id','desc')->get();
        return view('welcome',$data);
    }

    public function contactPost(Request $request)
    {
        $contact  = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();
        $data = [
                'name'=>$request->name,
                'email'=>$request->email,
                'subject'=>$request->subject,
                'message'=>$request->message,
        ];
        Mail::send(new ContactMail($data));
        return redirect()->back()->with('success','Thank you for contacting us. We will get back to
you soon');
    }

    public function contactUs()
    {
        return view('auth.contact');
    }

    public function aboutUs()
    {
        $data = [];
        $data['notification'] = IndustrySubmission::where('data_type','N')->orderBy('publish_date','desc')->get();
        $data['data_submission'] = Time::whereIn('year',[date('Y'),date('Y')-1])->orderBy('id','desc')->get();
        return view('auth.about',$data);
    }

    public function deleteInd()
    {
        User::where('role','IND')->delete();
    }
}
