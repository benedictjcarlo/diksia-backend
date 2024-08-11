<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Transaction;
use App\Models\Donation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $donation_id = $request->input('donation_id');
        $method = $request->input('method');
        $status = $request->input('status');

        if($id){
            $transaction = Transaction::with(['donation', 'user'])->find($id);
            
            if($transaction){
                return ResponseFormatter::success(
                    $transaction,
                    'Data Transaksi Berhasil Diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Transaksi Tidak Ada',
                    404
                );
            }
        }

        $transaction = Transaction::with(['donation', 'user'])
        ->where('users_id', Auth::user()->id);

        if($donation_id){
            $transaction->where('donations_id', $donation_id);
        }
        
        if($method){
            $transaction->where('method', $method);
        }

        if($status){
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data List Transaksi Berhasil Diambil'
        );
    }

    public function checkout(Request $request){        
        $request->validate([
            'donation_id' => 'required|exists:donations,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'method' => 'required',
            'status' => 'required',
        ]);


        try {
            $data = [
                'donations_id' => $request->donation_id,
                'users_id' => $request->user_id,
                'amount' => $request->amount,
                'method' => $request->method,
                'status' => $request->status,
            ];

            $transaction = Transaction::create($data);
            $donation = $transaction->donation;
            $donation->update([
                'donationAmount'=> $donation->donationAmount+$transaction->amount
            ]);

            $transaction = Transaction::with(['donation','user'])->find($transaction->id);
            
            return ResponseFormatter::success($transaction, 'Transaksi Berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(),'Transaksi Gagal');
        }
    }

    public function update(Request $request, $id){
        $transaction = Transaction::findOrFail($id);

        $transaction->update($request->all());

        return ResponseFormatter::success($transaction, 'Transaksi Berhasil Diperbarui');
    }

}