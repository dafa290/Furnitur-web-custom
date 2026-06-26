<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return "<h1>FurniNest Test - Laravel Works!</h1><p>Server is running properly.</p>";
    }
}
