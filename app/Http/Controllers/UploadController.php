<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUploadRequest;

class UploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUploadRequest  $request
     */
    public function store(StoreUploadRequest $request, Participant $slug)
    {
        $path = $request->file('filename')->store('uploads');
        Log::info('Upload::store', [$slug->staff_id, $request->validated(), $path]);

        $slug->uploads()->create(array_merge($request->validated(), ['filename' => $path]));

        return redirect()->route('registration_show', ['slug' => $slug->load('uploads')])->with('status', 'Upload captured successfully. We will notify you with email notification together with QR codes once your payment is verified.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show(Request $request, Upload $upload)
    {
        $extension = pathinfo(storage_path('app/'.$upload->filename), PATHINFO_EXTENSION);
        Log::info('Upload::show', [$upload->participant->staff_id, $upload, $request->user()]);

        return response()->file(storage_path('app/'.$upload->filename), ['Content-Disposition' => "inline; filename={$upload->participant->staff_id}_{$upload->id}.{$extension}"]);
    }
}
