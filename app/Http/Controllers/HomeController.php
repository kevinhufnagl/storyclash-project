<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $reports = DB::select('select * from reports');
        return view('home', ['reports' => $reports]);
    }
}
