<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = Status::all();

        return response($status, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info("Save Status");

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        Log::info("Validate");

        if ($validator->fails()) {
            return response("Validation Failed");
        }

        $status = Status::create([
            'name' => $request->name
        ]);

        return response($status, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //find status
        $status = Status::findorfail($id);

        return response($status, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info("Save Status");

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        Log::info("Validate");

        if ($validator->fails()) {
            return response("Validation Failed");
        }

        $status = Status::findorfail($id);

        Log::info("Update");

        $status->update($request->all());

        return response($status, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = Status::destroy($id);

        return response("Status deleted", 401);
    }
}
