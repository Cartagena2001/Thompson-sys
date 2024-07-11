<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
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
    public function serveCif(Request $request)
    {
        if (Auth::check()) { 

            $usr = auth()->User();

            //if(Auth::user() && Auth::id() === $file->user->id) {

            if($usr->rol_id === 0 || $usr->rol_id === 1) {
                // Here we don't use the Storage facade that assumes the storage/app folder
                // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
                
                $filepath = Storage::path( '/private/cifs/'.$request->data );
                
                return response()->file($filepath);


                /*
                try {

                    $filepath = Storage::path( '/private/'.$request->data );

                    return response()->file($filepath);

                } catch (Exception $e) {

                    Log::debug($e->getMessage());

                    //echo 'Message: ' .$e->getMessage();

                    return false;
                }
                */

            } elseif( $usr->rol_id === 2 ) {

                $filepath = Storage::path( '/private/cifs/'.$request->data );
                
                return response()->file($filepath);

            } else{
                return abort('404');
            }
        } else {
            return abort('404');
        }

    }


    public function serveCp(Request $request)
    {
        if (Auth::check()) { 

            $usr = auth()->User();

            //if(Auth::user() && Auth::id() === $file->user->id) {

            if($usr->rol_id === 0 || $usr->rol_id === 1) {
                // Here we don't use the Storage facade that assumes the storage/app folder
                // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
                
                $filepath = Storage::path( '/private/comp_pago/'.$request->data );
                
                return response()->file($filepath);


                /*
                try {

                    $filepath = Storage::path( '/private/'.$request->data );

                    return response()->file($filepath);

                } catch (Exception $e) {

                    Log::debug($e->getMessage());

                    //echo 'Message: ' .$e->getMessage();

                    return false;
                }
                */

            } elseif( $usr->rol_id === 2 ) {

                $filepath = Storage::path( '/private/comp_pago/'.$request->data );
                
                return response()->file($filepath);

            } else{
                return abort('404');
            }
        } else {
            return abort('404');
        }

    }


    public function serveHs(Request $request)
    {
        if (Auth::check()) { 

            $usr = auth()->User();

            //if(Auth::user() && Auth::id() === $file->user->id) {

            if($usr->rol_id === 0 || $usr->rol_id === 1 || $usr->rol_id === 3) {
                // Here we don't use the Storage facade that assumes the storage/app folder
                // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
                
                $filepath = Storage::path( '/private/hojas_sal/'.$request->data );
                
                return response()->file($filepath);


                /*
                try {

                    $filepath = Storage::path( '/private/'.$request->data );

                    return response()->file($filepath);

                } catch (Exception $e) {

                    Log::debug($e->getMessage());

                    //echo 'Message: ' .$e->getMessage();

                    return false;
                }
                */

            } elseif( $usr->rol_id === 2 ) {

                $filepath = Storage::path( '/private/hojas_sal/'.$request->data );
                
                return response()->file($filepath);

            } else{
                return abort('404');
            }
        } else {
            return abort('404');
        }

    }


    public function servePDF(Request $request)
    {
        if (Auth::check()) { 

            $usr = auth()->User();

            //if(Auth::user() && Auth::id() === $file->user->id) {

            if($usr->rol_id === 0 || $usr->rol_id === 1) {
                // Here we don't use the Storage facade that assumes the storage/app folder
                // So filename should be a relative path inside storage to your file like 'app/userfiles/report1253.pdf'
                
                $filepath = Storage::path( '/private/pdf/'.$request->data );
                
                return response()->file($filepath);


                /*
                try {

                    $filepath = Storage::path( '/private/'.$request->data );

                    return response()->file($filepath);

                } catch (Exception $e) {

                    Log::debug($e->getMessage());

                    //echo 'Message: ' .$e->getMessage();

                    return false;
                }
                */

            } else{
                return abort('404');
            }
        } else {
            return abort('404');
        }

    }



}