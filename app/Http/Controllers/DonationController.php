<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Http\Requests\DonationRequest;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donation = Donation::paginate(10);

        return view('donation.index',[
            'donation' => $donation
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('donation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DonationRequest $request)
    {
        $data = $request->all();

        $data['picturePath'] = $request->file('picturePath')->store('assets/donation', 'public');

        Donation::create($data);

        return redirect()->route('donation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        return view('donation/edit', [
            'item' => $donation
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DonationRequest $request, Donation $donation)
    {
        $data = $request->all();

        if($request->file('picturePath'))
        {
            $data['picturePath'] = $request->file('picturePath')->store('assets/donation', 'public');
        }

        $donation->update($data);

        return redirect()->route('donation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();

        return redirect()->route('donation.index');
    }
}
