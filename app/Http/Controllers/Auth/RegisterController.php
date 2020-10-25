<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verify_token' => base64_encode($data['email']),
        ]);
        $email = new EmailVerification($user);
        Mail::to($user->email)->send($email);

        return $user;
    }
    public function register(Request $request)
    {
        event(new Registered($user = $this->create( $request->all() )));

        return view('auth.registered');
    }

    //メールアドレスとパスワードを表示して確認させる
    public function pre_check(Request $request){
        $this->validator($request->all())->validate();
        //flash data
        $request->flashOnly( 'email');

        $bridge_request = $request->all();
        // password
        $bridge_request['password_mask'] = $request->password;

        return view('auth.register_check')->with($bridge_request);
    }

    // メールからリンククリックした時
    public function showForm($email_token)
    {
        // 使用可能なトークンか
        if ( !User::where('email_verify_token',$email_token)->exists() )
        {
            return view('auth.main.register')->with('message', '無効なトークンです。');
        } else {
            $user = User::where('email_verify_token', $email_token)->first();
            // 本登録済みユーザーか
            if ($user->status == 1) //REGISTER=1
            {
                logger("status". $user->status );
                return view('auth.main.register')->with('message', 'すでに本登録されています。ログインして利用してください。');
            }
            // ユーザーステータス更新
            $user->status = '2';
            $user->verify_at = Carbon::now();
            if($user->save()) {
                logger("status". $user->status );
                return view('auth.main.register', compact('email_token'));
            } else{
                return view('auth.main.register')->with('message', 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。');
            }
        }
    }

    //確認画面のviewを返すメソッド
     public function mainCheck(Request $request)
    {
        $request->validate([
        'name' => 'required|string',
        'name_pronunciation' => 'required|string',
        // 'birth_year' => 'required|numeric',
        // 'birth_month' => 'required|numeric',
        // 'birth_day' => 'required|numeric',
        ]);
        //データ保持用
        $email_token = $request->email_token;

        $user = new User();
        $user->name = $request->name;
        $user->name_pronunciation = $request->name_pronunciation;
        // $user->birth_year = $request->birth_year;
        // $user->birth_month = $request->birth_month;
        // $user->birth_day = $request->birth_day;

        return view('auth.main.register_check', compact('user','email_token'));
    }

    //本登録処理
    public function mainRegister(Request $request)
    {
        DB::beginTransaction();
        try{
            $user = User::where('email_verify_token',$request->email_token)->first();
            $user->status = '1';
            $user->name = $request->name;
            $user->name_pronunciation = $request->name_pronunciation;
            $user->save();
            $userEmail = User::where('email',$user->email)->first();
            DB::commit();
        } catch(\Exception $e) {
            DB::rollBack();
        }
        return view('auth.main.registered')
        ->with('userEmail',$userEmail);
    }
    //
    public function newmemberguidepageshow(){
        return view('newmemberguide');
    }
}
