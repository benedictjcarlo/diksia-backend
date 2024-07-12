<?php

namespace App\Http\Controllers\API;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class DonationController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $title = $request->input('title');
        $types = $request->input('types');

        $sortby= $request->input('sortby');
        $raisedby = $request->input('raisedby');

        if($id){
            $donation = Donation::find($id);
            
            if($donation){
                return ResponseFormatter::success(
                    $donation,
                    'Data Penggalangan Dana Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Penggalangan Dana Tidak Ada',
                    404
                );
            }
        }

        $donation = Donation::query();

        if($title){
            $donation->where('title', 'like', '%' . $title . '%');
        }

        if($types){
            $donation->where('types', 'like', '%' . $types . '%');
        }

        return ResponseFormatter::success(
            $donation->paginate($limit),
            'Data List Penggalangan Dana Berhasil Diambil'
        );
    }
}
