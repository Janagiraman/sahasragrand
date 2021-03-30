<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;
use App\Booking;
use App\User;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carbon = Carbon::now();
        $booking_date =  $carbon->format('Y-m-d');
        $users = User::where('type','!=','superadmin')->where('active','=',1)->get();
        $bookings = Booking::where('booking_date','=',$booking_date)->get();
        return view('home',compact(['users','bookings']));
    }

    /**
     * home page
     */
    public function homePage(){
        $tickers =  Ticker::all();
        return view('welcome',compact(['tickers']));
    }
   
    /**
     * User Dashboard
     */
    public function userDashboard(){
        $user = Auth::user();
        $bookings = Booking::where('user_id','=',$user->id)->get();
        $result['booking_count'] = $bookings->count();
        return view('dashboards.user',compact(['result']));
    }


}
