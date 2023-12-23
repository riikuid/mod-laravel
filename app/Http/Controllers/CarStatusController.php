<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarStatusRequest;
use App\Models\CarStatus;
use Illuminate\Http\Request;

class CarStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $status = CarStatus::all()->first();
        // dd($status);

        return view('pages.dashboard.status.index', compact('status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $status = CarStatus::find($id);
        // dd($status);
        return view('pages.dashboard.status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarStatusRequest $request, String $id)
    {
        $data = $request->all();
        $status = CarStatus::find($id);
        $status->update($data);

        return redirect()->route('dashboard.car-status.index');
    }
}
