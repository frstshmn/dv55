<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ImageController extends Controller {
    public function upload(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file'], 422);
        }
        $uploadDir = public_path('uploads');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name = time() . '_' . uniqid() . '.' . ($ext ?: 'png');
        $file->move($uploadDir, $name);
        return response()->json(['location' => '/uploads/' . $name]);
    }

    public function uploadVideo(Request $request) {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file'], 422);
        }
        $uploadDir = public_path('uploads/videos');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name = time() . '_' . uniqid() . '.' . ($ext ?: 'mp4');
        $file->move($uploadDir, $name);
        return response()->json(['location' => '/uploads/videos/' . $name, 'type' => $file->getClientMimeType()]);
    }
}
