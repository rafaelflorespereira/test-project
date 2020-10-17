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
        $dictionary = $this->createDictionary($rows, $headers);
        //Todos Refactor
        $subjectHeaders = [];
        foreach($subjects as $subject) {
          array_push($subjectHeaders, $this->getHeaderFromString($subject));
        }
        //Todos Refactor
        $messageHeaders = [];
        foreach($messages as $message) {
          array_push($messageHeaders, $this->getHeaderFromString($message));
        }

        $subjectContent = $this->getHeaderContent($dictionary, $subjectHeaders);
        $messageContent = $this->getHeaderContent($dictionary, $messageHeaders);

        $subjectText = $this->getTextFromString($subjects[0]);
        $messageText = $this->getTextFromString($messages[0]);

        $subjectSentence = $this->concatenateContentWithText($subjectContent, $subjectText);
        $messageSentence = $this->concatenateContentWithText($messageContent, $messageText);

        //Todos Refactor
        $contacts = [];
        foreach($subjectSentence as $key => $subject)
          array_push($contacts, [
            'subject' => $subject,
            'message' => $messageSentence[$key]
          ]);

        $emails = $this->getEmails($rows, $headers[0]);
       
        $data = [
            'emails' => $emails,
            'contacts' => $contacts,
        ];
        return view('table')->with($data);
    }
    
    /**
     * @return string 
     */
    public function getHeaderFromString($text) {
      preg_match_all('~\{\{\s*(.*?)\s*\}\}~', $text, $match);
      return $match[1];
    }
    public function getTextFromString($text)
    { 
      preg_match_all('/(?<=}{2}|^)(?!{{2}).*?(?={{2}|$)/s',$text,$out);
      return $out;
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
    
    /**
     * @return Array Dictionary
     */
    public function createDictionary($rows, $headers) {
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
    public function getHeaderContent($dictionary, $headers){
      $content = [];
      // Going through all elements of the contacts
      foreach($dictionary as $contact) {
        $each = [];
        foreach($contact as $element) {
          //Comparing each input header with the element's headers
          foreach($headers as $key => $header) {
            foreach($header as $head) {
              if($head == key($element)){
                //!! IF ELEMENT IS NOT PRESENT DO NOT PASS...
                //!! IF ELEMENT IS NOT PRESENT DO NOT PASS...
                $content[] = $element;
              }
            }
          }
        }
        if(!empty($each)) {
          $content[] = $each;
        }
      }
      dd($content);
      return $content;
    }

    public function concatenateContentWithText($contents, $text) {
      $wholeText = [];
      foreach($contents as $content) {
        $sentence = [];
        foreach($content as $key => $field) {
          array_push($sentence, $text[0][$key] . array_values($field)[0]);
        }
        array_push($wholeText, implode($sentence));
      }
      return $wholeText;
    }

    //!IS NOT BEING USED
    /**
     * @return string string[0] . $content . string[1]
     */
    public function putContentToTemplate($string, $content) {
      $header = implode(array(explode('{{', $string)[0], $content, explode('}}', $string)[1]));
      return $header;
    }
    //!IS NOT BEING USED
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
    //!IS NOT BEING USED
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
}
