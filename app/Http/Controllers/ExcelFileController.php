<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelFile\StoreRequest;
use App\Http\Resources\File\ContentFileResource;
use App\Http\Resources\File\FileIdResource;
use App\Imports\TableImport;
use App\Jobs\SendImportedFile;
use App\Jobs\SendImportedTable;
use App\Models\ExcelFile;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class ExcelFileController extends Controller
{
    public function show(ExcelFile $file): HttpResponse
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        if ($file->importedTable) {
            SendImportedTable::dispatch($file);
        } else {
            Excel::import(new TableImport($file), $file->path);
        }

        return response([
            'processing' => true,
        ]);
    }

    public function create(): Response
    {
        return inertia('ExcelFile/Create');
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();

        $filePath = Storage::put('/files', $data['file']);

        $file = Auth::user()->files()->create([
            'path' => $filePath,
        ]);

        return FileIdResource::make($file)->resolve();
    }
}
