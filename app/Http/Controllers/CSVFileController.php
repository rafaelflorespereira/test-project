<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CSVFileController extends Controller
{
    public function storeFile(Request $request) {
        $filename = 'CSVFile'.time();
        $path = $request->file('myFile')->storeAs('myFiles', $filename);
        return self::readFile($filename, $request->subject, $request->message);
    }
 
    public function readFile($filename, $subjects, $messages)
    {
        $file = fopen('../storage/app/myFiles/'.$filename,'r');
        $table = array();// Stores the content of the CSV file in this array
        while(!feof($file)) {
            array_push($table, (fgetcsv($file)));
        }
        fclose($file);
        $headers = array();
        $rows = array();
        //This can be refactored
        foreach($table as $key => $row){
            if($row != false) {
                if($key == 0) {
                    array_push($headers, $row);
                } else {
                    array_push($rows, $row);
                }
            } 
        }
        $foundSubjects = self::getFieldsFromRows($subjects, $rows, $headers);
        $foundMessages = self::getFieldsFromRows($messages, $rows, $headers);
        return view('welcome', ['subjects' => $foundSubjects], ['messages' => $foundMessages]);
    }

    /**
     * Find which Header the interpolated Strings matches
     * then, get the content from the row from the Header Index.
     * also, add the message back with the content from the CSV File.
     * @param array fields(Subjects and Messages)
     * @param array headers(CSV Header)
     * @param array rows(CSV content)
     * 
     * @return array (row fields, or 'blank' when field is empty)
     */
    public function getFieldsFromRows($fields, $rows, $headers) {
        $found = array();
        //check if fields is array
        foreach($fields as $field){
            $foundEachField = array();
            foreach($headers[0] as $keyHeader => $header) {
                if(self::getHeaderFromString($field) == $header) {
                    foreach($rows as $keyRow => $row) {
                        foreach($row as $keyCol => $col) {
                            if($keyCol == $keyHeader) {
                                array_push($foundEachField, self::putContenToTemplate($field, $col));
                            }
                        }
                    }
                }
            }
            array_push($found, $foundEachField);
        }
        return $found;
    }

    /**
     * @return string 
     */
    public function getHeaderFromString($string) {
        return trim(explode('}}', explode('{{', $string)[1])[0]);
    }
    /**
     * @return string string[0] . $content . string[1]
     */
    public function putContenToTemplate($string, $content) {
        return implode( array(explode('{{', $string)[0], $content, explode('}}', $string)[1])); 
    }

    public function findBlank() {}
}
