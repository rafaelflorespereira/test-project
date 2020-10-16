<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class CSVFileController extends Controller
{
    /**
     * Saves the file into store/app/myFiles
     */
    public function storeFile(Request $request) {
        if($request->file('myFile') == null || $request->message == null || $request->subject == null) {
            return redirect('/')->with(['error' => 'Please, fill the form correctly']);
        } 
        $filename = 'CSVFile'.time();
        $path = $request->file('myFile')->storeAs('myFiles', $filename);
        return $this->readFile($filename, $request->subject, $request->message);
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
        foreach($table as $key => $row){
            if($row != false) {
                if($key == 0 ? array_push($headers, $row) : array_push($rows, $row));
            }
        }
        $dictionary = $this->createDictionary($table);

        $emails = $this->getEmails($rows, $headers[0]);
        $foundSubjects = $this->getFieldsFromRows($subjects, $rows, $headers);
        $foundMessages = $this->getFieldsFromRows($messages, $rows, $headers);
        $contacts = $this->getNonEmpty($foundSubjects, $foundMessages, $subjects, $messages);
        $data = [
            'emails' => $emails,
            'contacts' => $contacts,
        ];
        return view('table')->with($data);
    }

    /**
     * Find which Header the interpolated Strings matches,
     * then get the content from the row from the Header Index.
     *
     * @param array fields(Subjects and Messages)
     * @param array headers(CSV Header)
     * @param array rows(CSV content)
     * 
     * @return array (row fields, or 'blank' when field is empty)
     */
    public function getFieldsFromRows($fields, $rows, $headers) {
        $found = array();
        foreach($fields as $field){
            $foundEachField = array();
            //take off $headers and input its index 0
            foreach($headers[0] as $keyHeader => $header) {
                if($this->getHeaderFromString($field) == $header) {
                    foreach($rows as $keyRow => $row) {
                        foreach($row as $keyCol => $col) {
                            if($keyCol == $keyHeader) {
                                array_push($foundEachField, $col);
                                //array_push($foundEachField, $this->putContentToTemplate($field, $col));
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
        $headers = [];
        return trim(explode('}}', explode('{{', $string)[1])[0]);
    }
    /**
     * @return string string[0] . $content . string[1]
     */
    public function putContentToTemplate($string, $content) {
        return implode(array(explode('{{', $string)[0], $content, explode('}}', $string)[1])); 
    }
    /**
     * Email field must be exactly like 'email'
     */
    public function getEmails($rows, $headers) {
        $emails = array();
        foreach($rows as $row){
            foreach($row as $colHeader => $column) {
                if($headers[$colHeader] == 'email') {
                    array_push($emails, $column);
                }
            }
        }
        return $emails;
    }
    //THIS NEEDS TO BE REFACTORED
    public function getNonEmpty($subjects, $messages, $subjectsText, $messagesText) {
        $nonEmpty = [];
        foreach($subjects as $key => $subject) {
            foreach($subject as $k => $field) {
                if($key == 0) {
                    array_push($nonEmpty,([
                        'subject' => $this->putContentToTemplate($subjectsText[$key], $field ),
                        'message' => $this->putContentToTemplate($messagesText[$key], $messages[$key][$k] ),
                    ]));
                } 
                elseif ( $nonEmpty[$k]['subject'] == '' || $nonEmpty[$k]['message'] == '') {
                    $nonEmpty[$k]['subject'] = $this->putContentToTemplate($subjectsText[$key], $field);
                    $nonEmpty[$k]['message'] = $this->putContentToTemplate($messagesText[$key], $messages[$key][$k]);
                }
            }
        }
        return $nonEmpty;
    }

    /**
     * @return Array Dictionary
     */
    public function createDictionary($table) {
        $headers = array();
        $rows = array();
        foreach($table as $key => $row){
            if($row != false) {
                if($key == 0 ? array_push($headers, $row) : array_push($rows, $row));
            }
        }
        $dictionary = [];
        foreach($rows as $key => $row) {
            $contact = [];
            foreach ($row as $k => $col) {
                array_push($contact, [ $headers[0][$k] => $col ?? '' ]);
            }
            array_push($dictionary, $contact);
        }
        return $dictionary;
    }
}
