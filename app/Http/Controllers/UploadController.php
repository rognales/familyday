<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUploadRequest;
use App\Participant;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUploadRequest  $request
     */
    public function store(StoreUploadRequest $request, Participant $slug)
    {
        $path = $request->file('filename')->store('uploads', 'local');
        $path = $request->file('filename')->store('uploads', 's3');
        Log::info('Upload::store', [$slug->staff_id, $request->validated(), $path]);

        $slug->uploads()->create(array_merge($request->validated(), ['filename' => $path]));

        return redirect()->route('registration_show', ['slug' => $slug->load('uploads')])->with('status', 'Upload captured successfully. We will notify you with email notification together with QR codes once your payment is verified.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function show(Request $request, Upload $upload)
    {
        $extension = pathinfo(storage_path('app/'.$upload->filename), PATHINFO_EXTENSION);
        $filename = "{$upload->participant->staff_id}_{$upload->id}.{$extension}";
        $headers = ['Content-Disposition' => "inline; filename={$filename}"];

        Log::info('Upload::show', [$upload->participant->staff_id, $upload, $request->user()]);

        if (Storage::disk('s3')->exists($upload->filename)) {
            return Storage::disk('s3')->download($upload->filename, $filename, $headers);
        }

        if (Storage::disk('local')->exists($upload->filename)) {
            return Storage::disk('local')->download($upload->filename, $filename, $headers);
        }

        return response('Files are not found locally or in AWS S3', 404);
    }
}
