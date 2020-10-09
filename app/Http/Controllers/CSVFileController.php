<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVFileController extends Controller
{
    public function readFile(Request $request)
    {
        $filename = 'CSVFile'.time();
        $path = $request->file('myFile')->storeAs('myFiles', $filename);
        $file = fopen('../storage/app/myFiles/'.$filename,'r');
        $table = array();
        while(!feof($file)) {
            array_push($table, (fgetcsv($file)));
        }
        fclose($file);
        $headers = array();
        $rows = array();
        foreach($table as $key => $row){
            if($key == 0) {
                array_push($headers, $row);
            } else {
                array_push($rows, $row);
            }
        }
        return view('welcome', ['headers' => $headers], ['rows' => $rows]);
        dd($table);
    }
}
