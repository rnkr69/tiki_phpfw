<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail extends PHPMailer{


    public function __construct($body = '', $reply = null)
    {
        //Don't forget to do this or other things may not be set correctly!
        parent::__construct(ENV("MAIL_EXCEPTIONS"));
        //Set a default 'From' address
        $this->setFrom(ENV("MAIL_USERNAME"));
        if(ENV("SMTP")){
            //Send via SMTP
            $this->isSMTP();
            //Equivalent to setting `Host`, `Port` and `SMTPSecure` all at once
            $this->Host = ENV("MAIL_HOST");
        }
        if(ENV("SMTP_AUTH")){
            //Send via SMTP
            $this->isSMTP();
            //Equivalent to setting `Host`, `Port` and `SMTPSecure` all at once
            $this->Host = ENV("MAIL_HOST");

            //Whether to use SMTP authentication
            $this->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $this->Username = ENV("MAIL_USERNAME");

            //Password to use for SMTP authentication
            $this->Password = ENV("MAIL_PASSWORD");
        }
        

        if($reply){
            //Set an alternative reply-to address
            $this->addReplyTo($reply);
        }
        
        
        //Set an HTML and plain-text body, import relative image references
        $this->msgHTML($body, './images/');

        if(ENV("ENVIRONMENT") == "dev"){
            //Show debug output
            $this->SMTPDebug = SMTP::DEBUG_SERVER;
            //Inject a new debug output handler
            $this->Debugoutput = static function ($str, $level) {
                echo "Debug level $level; message: $str\n";
            };
        }
        
    }

   

}


