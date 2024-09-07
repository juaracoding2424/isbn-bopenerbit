<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DropzoneController extends Controller
{
  public function store(Request $request)
  {
     
      $path = public_path('file_tmp_upload');
      $file = $request->file('file');
      $arrayRespones = [];
      $name = uniqid() . '_' . trim($file->getClientOriginalName());
      $file->move($path, $name);
      array_push($arrayRespones, ['name' => $name, 'original_name' => $file->getClientOriginalName()]);
      return response()->json($arrayRespones);
  }

  public function delete(Request $request)
  {
    $filename = public_path('file_tmp_upload/'. $request->input('filename')); // e.g., 'uploads/images/myfile.jpg'

    if (File::exists($filename)) {
        File::delete($filename);
        return response()->json(['success' => 'File deleted successfully']);
    }
    return response()->json(['error' => 'File not found'], 404);
  }
}
