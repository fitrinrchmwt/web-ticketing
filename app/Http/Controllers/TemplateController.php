<?php

namespace App\Http\Controllers;

use App\Models\PenggunaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TemplateModel;
use App\Models\SubjectModel;

class TemplateController extends Controller
{
    public function kelola_template()
    {
        if (!Session::has('loginId')) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = PenggunaModel::find(Session::get('loginId'));

        $datatemplate = TemplateModel::select('id_template','label_template', 'isi_template',)
        ->where('template.status_hapus', 0)
        ->orderByRaw('CAST(SUBSTRING(id_template, 5) AS UNSIGNED) ASC')->get();
    

        // Generate ID Bahan otomatis
        $lasttemplate = TemplateModel::selectRaw("MAX(CAST(SUBSTRING(id_template, 5) AS UNSIGNED)) AS max_id")->first();
        $lastNumber = $lasttemplate->max_id ?? 0;
        $newNumber = $lastNumber + 1;
        $kodeOtomatis = 'TMP-' . $newNumber;

        $list_subject = SubjectModel::all();

    	return view('Kelola_Template.Template', compact('datatemplate', 'kodeOtomatis', 'list_subject'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_template' => 'required|unique:template,id_template',
            'label_template' => 'required',
            'isi_template' => 'required',
        ],[
            'isi_template.unique' => 'Template sudah tersedia.',
        ]);

        TemplateModel::create([
            'id_template' => $request->id_template,
            'label_template' => $request->label_template,
            'isi_template' => $request->isi_template,
        ]);

        return redirect('/kelolatemplate')->with('success', 'Data Template masuk berhasil disimpan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_template' => 'required|exists:template,id_template',
            'label_template' => 'required',
            'isi_template' => 'required',
        ],[
            'isi_template.unique' => 'Template sudah tersedia.',
        ]);

        $template = TemplateModel::find($request->id_template);
        $template->update([
            'label_template' => $request->label_template,
            'isi_template' => $request->isi_template,

        ]);

        return redirect('/kelolatemplate')->with('success', 'Data Template berhasil diupdate.');
    }

    public function delete($id_template)
    {
        $template = TemplateModel::findOrFail($id_template);

        // Update status_hapus jadi 1 (soft delete manual)
        $template->update([
            'status_hapus' => 1
        ]);

        return redirect('/kelolatemplate')->with('success', 'Data Template berhasil dihapus (soft delete).');
    }
}