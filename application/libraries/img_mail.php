<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set("include_path", "application/libraries/phpmailer/");
require 'PHPMailerAutoload.php';

class img_mail
{
    var $Host = "mail.huynhgiatien.com";
    var $isHTML =  "true";
    var $Username = "sale.online@huynhgiatien.com";
    var $Password ="abc@123";
    var $From="sale.online@huynhgiatien.com";
    var $FromName="ShotLancer";
    var $AddAddress;
    var $Subject;
    var $Body;
    var $mail;
    
    
    public function __construct()
    {
        $this->mail = new PHPMailer(); 
    }
    
    public function sendmail($config)
    {
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth = true;
        $this->mail->Host = $this->Host;
        $this->mail->isHTML($this->isHTML);
        $this->mail->Username = $this->Username;
        $this->mail->Password = $this->Password;
        $this->mail->From = $this->From;
        $this->mail->FromName = $this->FromName;
        $this->mail->addAddress($config['to']);
        $this->mail->Subject = $config['subject'];
        $this->mail->Body = file_get_contents("http://shotlancer.com/application/views/email/".$config['template']);
        if(!$this->mail->send()) {
            return false;
        } else {
            return true;
        }
    }

}