<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
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
     * @return Response
     */
    public function index()
    {
        $days = Input::get('days', 7);

        $range = \Carbon\Carbon::now()->subDays($days);
        
        $stats = User::where('created_at', '>=', $range)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->remember(1440)
            ->get([
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as value')
            ])
            ->toJSON();
        // return view('home');
        
$this->layout->content = View::make('home', compact('stats'));
    }
}