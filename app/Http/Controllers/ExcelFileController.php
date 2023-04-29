<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Response;

class ExcelFileController extends Controller
{
    public function create(): Response
    {
        return inertia('ExcelFile/Create');
    }
}
