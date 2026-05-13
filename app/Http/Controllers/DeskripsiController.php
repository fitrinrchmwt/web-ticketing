<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeskripsiModel;
use App\Models\PenggunaModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class DeskripsiController extends Controller
{
    public function kelola_template_Deskripsi()
    {
        if (!Session::has('loginId')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = PenggunaModel::find(Session::get('loginId'));

        $datades = DeskripsiModel::where('status_hapus', 0)
            ->select('id_deskripsi', 'label_deskripsi', 'deskripsi')
            ->orderByRaw('CAST(SUBSTRING(id_deskripsi, 5) AS UNSIGNED) ASC')
            ->get();

        // Ambil angka terbesar dari kolom id_departemen (bagian setelah DEP-)
        $lastDes = DeskripsiModel::selectRaw("MAX(CAST(SUBSTRING(id_deskripsi, 5) AS UNSIGNED)) AS max_id")->first();

        $lastNumber = $lastDes->max_id ?? 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'DES-' . $newNumber;
        return view('Kelola_Template_Deskripsi.Deskripsi', compact('datades', 'kodeOtomatis'));
    }

    public function uploadSummernote(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());

            // SIMPAN KE storage/app/public/uploads/summernote
            $file->storeAs('uploads/deskripsi', $filename, 'public');

            // URL HARUS LEWAT /storage
            return response()->json([
                'url' => asset('storage/uploads/deskripsi/' . $filename)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id_deskripsi' => 'required|unique:deskripsi,id_deskripsi',
                'label_deskripsi' => 'required|unique:deskripsi,label_deskripsi',
                'deskripsi' => 'required',
            ], [
                'label_deskripsi.unique' => 'Label sudah terdaftar.',
            ]);

            DeskripsiModel::create([
                'id_deskripsi' => $request->id_deskripsi,
                'label_deskripsi' => $request->label_deskripsi,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect('/kelola_template_deskripsi')->with('success', 'Data Deskripsi masuk berhasil disimpan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $analisis = "Gagal Tambah Data: ";
            foreach ($errors as $error) {
                $analisis .= $error . ' ';
            }

            return redirect()->back()->with('error', $analisis);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }



    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_deskripsi' => 'required|exists:deskripsi,id_deskripsi',
                'label_deskripsi' => 'required',
                'deskripsi' => 'required',
            ], [
                'label_deskripsi.unique' => 'Label sudah terdaftar.',
            ]);

            $deskripsi = DeskripsiModel::findOrFail($request->id_deskripsi);

            // konten lama & baru
            $oldContent = $deskripsi->deskripsi;   // dari DB
            $newContent = $request->deskripsi;     // dari form

            // ambil semua gambar
            preg_match_all('/<img[^>]+src="([^">]+)"/', $oldContent, $oldImages);
            preg_match_all('/<img[^>]+src="([^">]+)"/', $newContent, $newImages);

            $oldImages = $oldImages[1] ?? [];
            $newImages = $newImages[1] ?? [];

            // cari gambar yang dihapus
            $deletedImages = array_diff($oldImages, $newImages);

            // hapus file yang tidak dipakai
            foreach ($deletedImages as $img) {
                $path = str_replace(asset('storage') . '/', '', $img);

                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            // update data
            $deskripsi->update([
                'label' => $request->label,
                'deskripsi' => $newContent,
            ]);

            return redirect('/kelola_template_deskripsi')->with('success', 'Data Deskripsi berhasil diupdate.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            $analisis = "Gagal Tambah Data: ";
            foreach ($errors as $error) {
                $analisis .= $error . ' ';
            }

            return redirect()->back()->with('error', $analisis);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function delete($id_deskripsi)
    {
        $deskripsi = DeskripsiModel::findOrFail($id_deskripsi);


        // Update status_hapus jadi 1 (soft delete manual)
        $deskripsi->update([
            'status_hapus' => 1
        ]);

        return redirect('/kelola_template_deskripsi')->with('success', 'Data Deskripsi berhasil dihapus (soft delete).');
    }
}