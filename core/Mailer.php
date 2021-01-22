<?php
namespace app\core;
require_once "/var/www/time.test/vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public $mail = '';
    public $path = '';
    public $linkText = '';
    public $subject = '';
    public function __construct(){
        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug  = 2;
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $this->mail->isSMTP();
        $this->mail->Host = "localhost";
        $this->mail->SMTPSecure = "tls";
        $this->mail->Port = 25;
        $this->mail->From = "noreply@framework.wrk";
        $this->mail->FromName = "Framework.wrk";
        $this->mail->isHTML(true);
    }

    public function configure($path, $subject, $linkText){
        $this->path = $path;
        $this->subject = $subject;
        $this->linkText = $linkText;
    }

    public function send($mail, $link){
        $this->mail->addAddress($mail, "Recepient Name");
        $this->mail->Subject = $this->subject;
        $htmlLink = sprintf("<a href='http://%s/%s/%s'>%s</a>",
        Application::$DOMAIN_NAME,
        $this->path,
        $link,
        $this->linkText);
        $this->mail->Body = $htmlLink;
        $this->mail->AltBody = $htmlLink;
        try {
            $this->mail->send();
            return "Message has been sent successfully";
        } catch (Exception $e) {
            return "Mailer Error: " . $this->mail->ErrorInfo;
        }
        }
}