<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipment = Shipment::with(['donation', 'user'])->paginate(10);

        return view('shipments.index', [
            'shipments' => $shipment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return view('shipments.detail', [
            'item' => $shipment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipment.index');
    }

    public function changeStatus(Request $request, $id, $status)
    {
        $shipment = Shipment::with(['donation', 'user'])->findOrFail($id);

        $shipment->status = $status;
        $shipment->save();

        return redirect()->route('shipment.show', $id);
    }
}