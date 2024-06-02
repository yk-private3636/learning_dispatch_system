<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response as InertiaResponse;

class TopController extends Controller
{
    public function index(): InertiaResponse
    {
        return inertia('top/index');
    }
}
