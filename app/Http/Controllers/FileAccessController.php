<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;


class FileAccessController extends Controller
{


    // In FileAccessController.php
    public function download(Request $request)  
    {
        // We should do our authentication/authorization checks here
        // We assume you have a FileModel with a defined belongs to User relationship.

        if(Auth::user() && Auth::id() === $file->user->id) {
            
            // filename should be a relative path inside storage/app to your file like 'userfiles/report1253.pdf'
            return Storage::download($file->filename);

        }else{
            return abort('403');
        }
    }

    // In FileAccessController.php
    public function serve(Request $request)
    {
        if(Auth::user() && Auth::id() === $file->user->id) {
            // Here we don't use the Storage facade that assumes the storage/app folder
            // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
            
            $filepath = storage_path($file->filename);
            
            return response()->file($filepath);

        }else{
            return abort('404');
        }
    }


}