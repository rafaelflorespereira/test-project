<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVFileController extends Controller
{
    public function readFile(Request $request)
    {
        $filename = 'CSVFile'.time();
        $path = $request->file('myFile')->storeAs('myFiles', $filename);
        $csv = fgetcsv(fopen('../storage/app/myFiles/'.$filename,'r'));
        dd($csv);
        fclose($csv);
        dd($path);
    }
}
