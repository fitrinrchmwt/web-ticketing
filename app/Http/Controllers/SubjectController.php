<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectModel; 

class subjectController extends Controller
{
    public function kelola_subject()
    {
       $datasubject = SubjectModel::where('status_hapus', 0)
        ->select('id_subject', 'isi_subject')
        ->orderByRaw('CAST(SUBSTRING(id_subject, 5) AS UNSIGNED) ASC')->get();

        // Generate ID Bahan otomatis
        $lastsubject = SubjectModel::selectRaw("MAX(CAST(SUBSTRING(id_subject, 5) AS UNSIGNED)) AS max_id")->first();
        $lastNumber = $lastsubject->max_id ?? 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'SUB-' . $newNumber;


    	return view('kelola_subject.subject', compact('datasubject', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_subject' => 'required|unique:subject,id_subject',
            'isi_subject' => 'required',
        ]);

        subjectModel::create([
            'id_subject' => $request->id_subject,
            'isi_subject' => $request->isi_subject,
            'status_hapus' => 0
        ]);

        return redirect()->route('subject.kelola')->with('success', 'Data Subject berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_subject' => 'required|exists:subject,id_subject',
            'isi_subject' => 'required',
        ]);

        $subject = subjectModel::find($request->id_subject);
        $subject->update([
            'isi_subject' => $request->isi_subject,
          
        ]);

        return redirect()->route('subject.kelola')->with('success', 'Data subject berhasil diupdate.');
    }

    public function delete($id_subject)
    {
        $subject = subjectModel::findOrFail($id_subject);

        // Update status_hapus jadi 1 (soft delete manual)
        $subject->update([
            'status_hapus' => 1
        ]);

        return redirect()->route('subject.kelola')->with('success', 'Data subject berhasil dihapus.');
    }
}
