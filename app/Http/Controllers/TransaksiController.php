<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        // get list users transaksi
        $transactions = transaksi::all();
        return response()->json([
            'message' => 'Data Fetch Successfully',
            'transaksi' => $transactions
        ]);
    }

    public function userTransaksi($user)
    {
        // get list transaksi of specific user
        $transactions = transaksi::where('user_id', $user)->get();
        return response()->json([
            'message' => 'Data Fetch Successfully',
            'transaksi' => $transactions
        ]);
    }
}
