<?php

namespace App\Http\Controllers;

use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(SubmissionFile $file)
    {
        abort_unless(Storage::disk('local')->exists($file->storage_key), 404);

        return Storage::disk('local')->response(
            $file->storage_key,
            $file->original_name,
            ['Content-Type' => $file->mime_type]
        );
    }
}
