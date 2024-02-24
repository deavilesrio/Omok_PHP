<?php
class new_Game{
    function addNote($note) {
        $file = "pids.txt";
        if (!empty($note)) {
        $fp = fopen($file, 'a');
        fputs($fp, nl2br($note) . "\n");
        fclose($fp);
        // $this -> showNotes();
        }
    }
    static function showNotes() {
        // Write your code here!
        $file = 'C:\Users\diego\OneDrive\Desktop\Hello World\OmokService\src\new\pids.txt';
        $handle = fopen($file, "r");
        $array = array();
        $i = 0;
                // Check if the file was opened successfully
        if ($handle) {
            // Read one line at a time until end of file
            while (($line = fgets($handle)) !== false) {
                // Process each line
                $array[$i] = $line;
                $i++;
            }
            
            // Close the file handle
            fclose($handle);
        } else {
            // Handle error opening the file
            echo "Unable to open file.";
        }
        return $array;    
    }
    function savePid($pid){
        $this->addNote($pid);    
        return true;

    }
    
}