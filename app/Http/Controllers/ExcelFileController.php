<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelFile\StoreRequest;
use App\Http\Resources\File\FileIdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;

class ExcelFileController extends Controller
{
    public function create(): Response
    {
        return inertia('ExcelFile/Create');
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $filePath = Storage::put('/files', $data['file']);

        $file = Auth::user()->files()->create([
            'path' => $filePath,
        ]);

        return FileIdResource::make($file)->resolve();
    }
}
