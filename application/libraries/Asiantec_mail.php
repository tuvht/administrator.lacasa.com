<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set("include_path", "application/libraries/phpmailer/");
require 'PHPMailerAutoload.php';
class Asiantec_mail
{
    var $Host = "mail.asiantechhub.com";
    var $isHTML =  "true";
    var $Username = "info@asiantechhub.com";
    var $Password ="abc@123";
    var $From="info@asiantechhub.com";
    var $FromName="B2C Marketplace";
    var $AddAddress;
    var $Subject;
    var $Body;
    var $mail;
    
    
    public function __construct()
    {
        $CI =& get_instance();
        $this->_model = $CI;
        $this->_model->load->model("model_config");
        $this->mail = new PHPMailer();  
    }
    
    public function sendmail($config)
    {
        $main_config = json_decode($this->_model->model_config->get_config_by_name('main_config'));
        $this->Host = $main_config->mail_server;
        $this->Username = $main_config->mail_account;
        $this->Password = $main_config->mail_password;
        $this->From = $main_config->mail_account;
        $this->FromName = $main_config->mail_account;
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
        $this->mail->Body = $config['template'];
        
        if (!$this->mail->send()) 
        {
            return false;
        } 
        else 
        {
            return true;
        }
    }
}