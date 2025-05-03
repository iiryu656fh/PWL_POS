<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanDetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanDetailController extends Controller
{
    public function index() {
        $penjualan_detail = PenjualanDetailModel::with('penjualan', 'barang')->get();
        return response()->json($penjualan_detail, 200);
    }

    public function store (Request $request) {
        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $penjualan_detail = PenjualanDetailModel::create($request->all());

        return response()->json($penjualan_detail->load('penjualan', 'barang'), 201);
    }

    public function show($id){
        $penjualan_detail = PenjualanDetailModel::with('penjualan', 'barang')->findOrFail($id);

        if (!$penjualan_detail) {
            return response()->json(['message' => 'Penjualan Detail not found'], 404);
        }

        return response()->json($penjualan_detail, 200);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'penjualan_id' => 'required|exists:t_penjualan,penjualan_id',
            'barang_id' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $penjualan_detail = PenjualanDetailModel::findOrFail($id);
        $penjualan_detail->update($request->all());

        return response()->json($penjualan_detail->load('penjualan', 'barang'), 200);
    }

    public function destroy($id) {
        $penjualan_detail = PenjualanDetailModel::findOrFail($id);
        $penjualan_detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Penjualan Detail deleted successfully'
        ], 200);
    }
}
