<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Fuel\CreateRequest;
use App\Models\Fuel;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.home', [
            'fuels' => Fuel::orderBy('check_date', 'desc')->get(),
        ]);
    }
}
