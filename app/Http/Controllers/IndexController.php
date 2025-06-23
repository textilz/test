<?php

namespace App\Http\Controllers;

use App\Models\Adv;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', [
            'advs' => Adv::all()
        ]);
    }
}
