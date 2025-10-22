<?php

namespace App\Http\Controllers;

use App\Services\DeshboardServices;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct() {}
    public function __invoke()
    {
        return Inertia::render('Dashboard/Dashboard', ['data' => []]);
    }
}
