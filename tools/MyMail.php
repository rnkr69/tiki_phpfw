<?php


include_once __DIR__."/../kernel/Mail.php";
include_once __DIR__."/../kernel/Controller.php";
include_once __DIR__."/../kernel/Pdf.php";


class MyMail {

    
    public function __construct(){

    }

    

    public static function welcomeMail($toUser){
        
        
        
        $options = [
            "to_user" => $toUser->getArray(), 
            "action_url" => config("documentation_url"), 
            "help_url"=>config("help_url"), 
            "support_email"=>config("support_email")
        ];
       
        
        $body = Controller::getView("mail_welcome", $options, true);

       
        try{
            $mail = new Mail( $body, config("support_email"));
        
            
            //Now you only need to set things that are different from the defaults you defined
            $mail->addAddress($toUser->email);
            $mail->Subject = 'Welcome to '.ENV("APP_NAME");
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ]
            ];
            
            $pdf = new Pdf();
            $pdf->loadHtml($body);
            $pdffile = $pdf->saveFile();
            

            
            $mail->addAttachment($pdffile, 'welcome.pdf');
            
            $mail->send();
                
        } catch(Exception $e){

            echo $e->getMessage();

        }
        
        
    }



}