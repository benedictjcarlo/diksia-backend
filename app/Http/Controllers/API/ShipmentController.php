<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Shipment;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShipmentController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $donation_id = $request->input('donation_id');
        $jenis = $request->input('jenis');
        $kondisi = $request->input('kondisi');
        $kurir = $request->input('kurir');

        if($id){
            $shipment = Shipment::with(['donation', 'user'])->find($id);
            
            if($shipment){
                return ResponseFormatter::success(
                    $shipment,
                    'Data Pengiriman Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Pengiriman Tidak Ada',
                    404
                );
            }
        }

        $shipment = Shipment::with(['donation', 'user'])
        ->where('users_id', Auth::user()->id);

        if($donation_id){
            $shipment->where('donations_id', $donation_id);
        }
        
        if($jenis){
            $shipment->where('jenis', $jenis);
        }

        if($kondisi){
            $shipment->where('kondisi', $kondisi);
        }

        if($kurir){
            $shipment->where('kurir', $kurir);
        }

        return ResponseFormatter::success(
            $shipment->paginate($limit),
            'Data List Pengiriman Berhasil Diambil'
        );
    }

    public function shipmentGadget(Request $request){        
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required',
            'kondisi' => 'required',
            'merk' => 'required',
            'kendala' => 'required',
            'kurir' => 'required',
            'resi' => 'required',
            'status' => 'required',
            'amount' => 'required',
        ]);


        try {
            $data = [
                'donations_id' => $request->donation_id,
                'users_id' => $request->user_id,
                'jenis' => $request->jenis,
                'kondisi' => $request->kondisi,
                'merk' => $request->merk,
                'kendala' => $request->kendala,
                'kurir' => $request->kurir,
                'resi' => $request->resi,
                'status' => $request->status,
                'amount' => $request->amount,
            ];
            $shipment = Shipment::create($data);
            $donation = $shipment->donation;
            $donation->update([
                'donationAmount'=> $donation->donationAmount+$shipment->amount
            ]);

            $shipment = Shipment::with(['donation','user'])->find($shipment->id);
            
            return ResponseFormatter::success($shipment, 'Pengiriman Berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }

    public function updateShipmentPhoto(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048'
        ]);

        if($validator->fails()){
            return ResponseFormatter::error([
                'error' => $validator->errors()
            ], 'Update Photo Files', 401);
        }

        if($request->file('file')){
            $file = $request->file->store('assets/user', 'public');

            //Menyimpan Foto ke Database (URL)
            $user = Auth::user();
            $user->shipment_photo_path = $file;
            $user->update();

            return ResponseFormatter::success($file, 'File Successfully Uploaded');
        }
    }

    public function update(Request $request, $id){
        $shipment = Shipment::findOrFail($id);

        $shipment->update($request->all());

        return ResponseFormatter::success($shipment, 'Pengiriman Berhasil Diperbarui');
    }
}