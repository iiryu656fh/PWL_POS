<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form

        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $acttiveMenu = 'kategori'; // set menu yang aktif

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $acttiveMenu]);
    }

    // ambil data kategori dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_kode) {
            $kategori->where('kategori_kode', $request->kategori_kode);
        }

        return DataTables::of($kategori)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                // $btn = '<a href="'.url('/kategori/' .$kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/kategori/' .$kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'.url('/kategori/'.$kategori->kategori_id).'">'
                //      . csrf_field() . method_field('DELETE')
                //      . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button>';
                $btn .= '<button onclick="modalAction(\''.url('/kategori/' . $kategori->kategori_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn; 
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah Kategori']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; // set menu yang aktif
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax() {
        $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form
        return view('kategori.create_ajax', ['kategori' => $kategori]);
    }

    public function store(Request $request) {
        $request->validate([
            'kategori_kode' => 'required|string',
            'kategori_nama' => 'required|string'
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('status', 'Data kategori berhasil ditambahkan');
    }

    public function store_ajax(Request $request) {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:6|regex:/^[A-Z0-9]+$/',
                'kategori_nama' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/'
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return response()->json([
                    'status' => false, //response sttaus, false: error/gagal, true=berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            KategoriModel::create([
                'kategori_kode' => $request->kategori_kode,
                'kategori_nama' => $request->kategori_nama
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
        redirect('/kategori');
    }

    public function show(string $id) {
        $kategori = KategoriModel::find($id); // ambil data kategori untuk ditampilkan di form
        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail Kategori']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang aktif
        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id) {
        $kategori = KategoriModel::find($id); // ambil data kategori untuk ditampilkan di form
        return view('kategori.show_ajax', ['kategori' => $kategori]);
    }

    public function edit(string $id) {
        $kategori = KategoriModel::find($id); // ambil data kategori untuk ditampilkan di form
        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit Kategori']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang aktif
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id) {
        $kategori = KategoriModel::find($id); // ambil data kategori untuk ditampilkan di form
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update(Request $request, string $id) {
        $request->validate([
            'kategori_kode' => 'required|string',
            'kategori_nama' => 'required|string'
        ]);

        KategoriModel::where('kategori_id', $id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    public function update_ajax(Request $request, string $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|max:6|regex:/^[A-Z0-9]+$/',
                'kategori_nama' => 'required|string|min:3|max:50|regex:/^[a-zA-Z\s]+$/',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response json, true:berhasil, false;gagl
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = KategoriModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil diubah'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }
        }
        return redirect('/kategori');
    }

    public function destroy(string $id) {
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kategori')->with('error', 'Data kategori tidak bisa dihapus karena terdapat data yang terkait');
        }
    }

    public function confirm_ajax(string $id) {
        $kategori = KategoriModel::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, string $id) {
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = KategoriModel::find($id);
            if (!$kategori) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori tidak ditemukan'
                ]);
            }

            try {
                $kategori->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data kategori berhasil dihapus'
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori gagal dihapus karena terdapat data yang terkait'
                ]);
            }
        }
        return redirect('/kategori');
    }

    public function import(){
        return view('kategori.import');
    }

    public function import_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_kategori' => 'required|mimes:xls,xlsx|max:1024',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            try {
                $file = $request->file('file_kategori');

                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();

                $data = $sheet->toArray(null, false, true, true);
                
                $insert = [];
                if (count($data) > 1) {
                    foreach ($data as $baris => $value) {
                        if ($baris > 1) {
                            $insert[] = [
                                'kategori_kode' => $value['A'],
                                'kategori_nama' => $value['B'],
                                'created_at' => now(),
                            ];
                        }
                    }

                    if (count($insert) > 0) {
                        KategoriModel::insertOrIgnore($insert);
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'Data kategori berhasil diimport'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data kategori tidak ditemukan'
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data kategori gagal diimport',
                ]);
            }
        }
        return redirect('/kategori');
    }

    public function export_excel(){
        // ambil data kategori yang akan di export
        $kategori = KategoriModel::select('kategori_kode', 'kategori_nama')->get();

        //load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Kategori');
        $sheet->setCellValue('C1', 'Nama Kategori');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($kategori as $data) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $data->kategori_kode);
            $sheet->setCellValue('C' . $baris, $data->kategori_nama);
            $no++;
            $baris++;
        }

        // set lebar kolom
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // set nama file
        $sheet->setTitle('Data Kategori');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Kategori_' . date('Y-m-d_H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output'); // simpan file ke output
        exit; // hentikan script setelah file di download
    }
}
