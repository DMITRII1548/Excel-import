<?php

namespace App\Http\Controllers;

use App\Models\ExcelFile;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadsFileController extends Controller
{
    public function download(ExcelFile $file): BinaryFileResponse
    {
        return response()->download(public_path('storage/' . $file->path));
    }
}
