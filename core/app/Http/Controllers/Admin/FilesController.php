<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FilesController extends Controller {
    public function index(Request $request) {
        $pageTitle    = 'All Files';
        $emptyMessage = 'No file found';
        $files        = File::query();

        if ($request->search) {
            $files->where('name', 'LIKE', "%$request->search%");
        }

        $files = $files->where('status', 1)->latest()->paginate(getPaginate());
        return view('admin.file.index', compact('pageTitle', 'emptyMessage', 'files'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max: 40|unique:files,name',
        ]);

        $file       = new File();
        $file->name = $request->name;
        $file->save();

        $notify[] = ['success', 'File added successfully.'];
        return back()->withNotify($notify);
    }

    public function update(Request $request) {
        $file = File::findOrFail($request->id);
        $request->validate([
            'name' => 'required|unique:files,name,' . $file->id,
        ]);
        $file->name = $request->name;
        $file->save();

        $notify[] = ['success', $file->name . ' has been updated.'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request) {
        $file = File::findOrFail($request->id);

        if ($file->status == 1) {
            $file->status = 0;
            $notify[]     = ['success', $file->name . ' has been deleted'];
        } else {
            $file->status = 1;
            $notify[]     = ['success', $file->name . ' has been restored'];
        }

        $file->save();
        return back()->withNotify($notify);
    }

    public function trash(Request $request) {
        $pageTitle    = 'All Files';
        $emptyMessage = 'No file found';
        $files        = File::query();

        if ($request->search) {
            $files->where('name', 'LIKE', "%$request->search%");
        }

        $files = $files->where('status', 0)->latest()->paginate(getPaginate());
        return view('admin.file.index', compact('pageTitle', 'emptyMessage', 'files'));
    }

}
