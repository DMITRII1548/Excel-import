<?php

namespace App\Http\Controllers;

use App\Exports\TableExport;
use App\Http\Requests\ExcelFile\PushColumnRequest;
use App\Http\Requests\ExcelFile\StoreRequest;
use App\Http\Resources\File\FileIdResource;
use App\Imports\StoredTableImport;
use App\Imports\UpdatedTableImport;
use App\Jobs\SendImportedTable;
use App\Models\ExcelFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelFileController extends Controller
{
    public function show(ExcelFile $file): Response
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        SendImportedTable::dispatch($file);

        $file = FileIdResource::make($file)->resolve();

        return inertia('ExcelFile/Show', compact('file'));
    }

    public function create(): Response
    {
        return inertia('ExcelFile/Create');
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();

        $filePath = Storage::disk('public')->put('/files', $data['file']);

        $file = Auth::user()->files()->create([
            'path' => $filePath,
        ]);

        Excel::import(new StoredTableImport($file), 'storage/' . $file->path);

        return FileIdResource::make($file)->resolve();
    }

    public function download(ExcelFile $file): BinaryFileResponse
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        return response()->download(public_path('storage/' . $file->path));
    }

    public function addColumn(ExcelFile $file): Response
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        return inertia('ExcelFile/AddColumn', compact('file'));
    }

    public function pushColumn(PushColumnRequest $request, ExcelFile $file): RedirectResponse
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        $data = $request->validated();
        $column = [];
        array_push($column, $data['title']);

        foreach ($data['items'] as $item) {
            array_push($column, $item);
        }

        $table = collect(json_decode($file->importedTable->content));
        $i = 0;
        foreach ($table as $item) {
            if (isset($column[$i])) {
                array_push($item, $column[$i]);
                $table[$i] = $item;
            }

            $i++;
        }

        $file->importedTable->update([
            'content' => '',
        ]);

        Excel::store(new TableExport($table, $file), $file->path, 'public')
            ->chain([
                function () use ($file) {
                    Excel::import(new UpdatedTableImport($file), $file->path, 'public');
                },
            ]);

        return redirect()->route('files.show', $file->id);
    }

    public function editField(ExcelFile $file): Response
    {
        if ($file->user != Auth::user()) {
            abort(419);
        }

        $file = FileIdResource::make($file)->resolve();

        return inertia('ExcelFile/EditField', compact('file'));
    }
}
