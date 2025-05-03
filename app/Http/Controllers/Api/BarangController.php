<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index() {
        $barang = BarangModel::with('kategori')->get();
        return response()->json($barang, 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:255',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->store('images', 'public');
            $data['image'] = $image->hashName();

        }
        $barang = BarangModel::create($data);
        if ($barang) {
            return response()->json([
                'message' => true,
                'barang' => $barang
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }

    public function show(BarangModel $barang) {
        return response()->json($barang->load('kategori'), 200);
    }

    public function update(Request $request, BarangModel $barang) {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|integer|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:255',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($barang->image_path) {
                Storage::delete('public/' . $barang->image_path);
            }

            $image = $request->file('image');
            $image->store('images', 'public');
            $data['image_path'] = $image->hashName();
        }

        $barang->update($data);
        return response()->json($barang->load('kategori'), 200);
    }

    public function destroy(BarangModel $barang) {
        // hapus gambar
        if ($barang->image_path) {
            Storage::delete('public/' . $barang->image_path);
        }
        // hapus data barang
        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus',
        ], 200);
    }
}
