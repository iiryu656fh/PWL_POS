<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Penjualan Barang',
            'list' => ['Home', 'Penjualan Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Penjualan Barang'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')
            ->with('user', 'penjualan_detail');

        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('total_harga', function ($row) {
                $total = $row->penjualan_detail->sum(function ($d) {
                    return $d->harga * $d->jumlah;
                });
                return 'Rp ' . number_format($total, 0, ',', '.');
            })

            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();
        return view('penjualan.create_ajax')
            ->with('barang', $barang);
    }


    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_kode' => 'required|string|unique:t_penjualan,penjualan_kode',
                'pembeli' => 'required|string',
                'penjualan_tanggal' => 'required|date',
                'barang_id' => 'required|array|min:1',
                'barang_id.*' => 'required|exists:m_barang,barang_id',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|integer|min:1',
                'harga' => 'required|array',
                'harga.*' => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // simpan penjualan
            $penjualan = PenjualanModel::create([
                'user_id' => auth()->user()->user_id,
                'penjualan_kode' => $request->penjualan_kode,
                'pembeli' => $request->pembeli,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            // lopp detail barang
            $dataDetail = [];
            foreach ($request->barang_id as $i => $barang_id) {
                $dataDetail[] = new PenjualanDetailModel([
                    'barang_id' => $barang_id,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                    'penjualan_id' => $penjualan->penjualan_id,
                ]);
            }

            // simpan relasi detail sekaligus
            $penjualan->penjualan_detail()->saveMany($dataDetail);

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan dan detail berhasil disimpan',
                'penjualan_id' => $penjualan->penjualan_id,
            ]);
        }
        return redirect('/penjualan');
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('user', 'penjualan_detail.barang')->find($id);

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    public function edit_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama', 'harga_jual')->get();
        $user = UserModel::select('user_id', 'nama')->get();

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan'
            ]);
        }
        return view('penjualan.edit_ajax', ['penjualan' => $penjualan, 'barang' => $barang, 'user' => $user]);
    }

    public function update_ajax(Request $request, string $id)
    {
        if (!($request->ajax() || $request->wantsJson())) {
            return redirect('/penjualan');
        }
        $request->validate([
            'user_id' => 'required|exists:m_user,user_id',
            'pembeli' => 'required|string',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|exists:m_barang,barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga' => 'required|array',
            'harga.*' => 'required|numeric|min:0',
        ]);
        
        try {
            $penjualan = PenjualanModel::find($id);
            if (!$penjualan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }
            $penjualan->update([
                'user_id' => $request->user_id,
                'pembeli' => $request->pembeli,
                'penjualan_tanggal' => $request->penjualan_tanggal,
            ]);

            //hapus semua detail sebelumnya lalu tambah ulang
            $penjualan->penjualan_detail()->delete();
            $dataDetail = [];
            foreach ($request->barang_id as $i => $barang_id) {
                $dataDetail[] = new PenjualanDetailModel([
                    'barang_id' => $barang_id,
                    'harga' => $request->harga[$i],
                    'jumlah' => $request->jumlah[$i],
                    'penjualan_id' => $penjualan->penjualan_id,
                ]);
            }
            // simpan relasi detail sekaligus
            $penjualan->penjualan_detail()->saveMany($dataDetail);
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan dan detail berhasil diupdate',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data penjualan dan detail',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(string $id)
    {
        $check = PenjualanModel::find($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id);
            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data penjualan tidak bisa dihapus karena masih digunakan pada tabel lain');
        }
    }

    public function confirm_ajax(string $id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }
    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::with('penjualan_detail')->find($id);
            if (!$penjualan) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak ditemukan'
                ]);
            }

            try {
                $penjualan->penjualan_detail()->delete();

                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data penjualan tidak bisa dihapus karena masih digunakan pada tabel lain'
                ]);
            }
        }
        redirect('/penjualan');
    }

    public function export_excel()
    {
        $penjualan = PenjualanModel::with(['penjualan_detail', 'penjualan_detail.barang'])
            ->orderBy('penjualan_tanggal')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Tanggal Penjualan');
        $sheet->setCellValue('D1', 'Pembeli');
        $sheet->setCellValue('E1', 'Barang Nama');
        $sheet->setCellValue('F1', 'Jumlah');
        $sheet->setCellValue('G1', 'Harga');
        $sheet->setCellValue('H1', 'Total Harga');

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);


        $no = 1;
        $baris = 2;
        foreach ($penjualan as $penjualanItem) {
            foreach ($penjualanItem->penjualan_detail as $detail) {
                $sheet->setCellValue("A" . $baris, $no);
                $sheet->setCellValue('B' . $baris, $penjualanItem->penjualan_kode);
                $sheet->setCellValue("C" . $baris, $penjualanItem->penjualan_tanggal);
                $sheet->setCellValue('D' . $baris, $penjualanItem->pembeli);
                $sheet->setCellValue("E" . $baris, $detail->barang->barang_nama);
                $sheet->setCellValue('F' . $baris, $detail->jumlah);
                $sheet->setCellValue("G" . $baris, $detail->harga);
                $sheet->setCellValue('H' . $baris, $detail->jumlah * $detail->harga);
                $baris++;
                $no++;
            }
        }

        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Penjualan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Penjualan_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $penjualan = PenjualanModel::with(['penjualan_detail', 'penjualan_detail.barang'])
            ->orderBy('penjualan_tanggal')
            ->get();
        
        $pdf = PDF::loadview('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('A4', 'portait');
        $pdf->setOption("isRemoteEnabled", true);
        $pdf->render();
        return $pdf->stream('Data_Penjualan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
