<?php

use Dompdf\Dompdf;


class Pdf extends Dompdf{

    public function saveFile(){

        $this->render();
         
        $filename = $this->guidv4().".pdf";

        file_put_contents(__DIR__."/../storage/pdf/".$filename, $this->output());

        return __DIR__."/../storage/pdf/".$filename;

    }



    private function guidv4() {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

}