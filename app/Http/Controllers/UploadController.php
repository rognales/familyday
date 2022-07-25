<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Http\Requests\StoreUploadRequest;
use App\Http\Requests\UpdateUploadRequest;
use App\Participant;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create(Participant $slug)
    {
        return view('registration.upload', ['participant' => $slug->load('uploads')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUploadRequest  $request
     */
    public function store(StoreUploadRequest $request, Participant $slug)
    {
        $path = $request->file('filename')->store('uploads');

        $slug->uploads()->create(array_merge($request->validated(), ['filename' => $path]));

        return redirect()->route('registration_show', ['slug' => $slug->load('uploads')])->with('success', 'Upload captured successfully. Admin will verify and issue your receipt accordingly.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     //  * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        $extension = pathinfo(storage_path('app/' . $upload->filename), PATHINFO_EXTENSION);
        return response()->file(storage_path('app/' . $upload->filename), ['Content-Disposition' => "inline; filename={$upload->participant->staff_id}_{$upload->id}.{$extension}"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
    //
    }
}