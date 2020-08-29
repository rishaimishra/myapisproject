<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function CountryList(){
        return response()->download(public_path('demo.png'),'User Image');

    }

    public function CountrySaveFile(Request $request){
        $fileName = "user_image.jpg";
        $path = $request->file('photo')->move(public_path("/"),$fileName);
        $photoUrl = url('/'.$fileName);
        return response()->json(['url' => $photoUrl],200);
    }
}
