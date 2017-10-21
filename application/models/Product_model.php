<?php



class product_model extends CI_Model

{
    
    public function __construct()

    {
        $this->load->database();
        
    }

    public function get_Images($image_id = FALSE)
    {

        if ($image_id == FALSE)
        {
            $sql = "select * from images where status='available' ORDER BY upload_date DESC";
            $query=$this->db->query($sql);
            if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            }
            else
            {
                return $query->result_array();}
        }
        $query=$this->db->get_where('images',array('image_id' => $image_id, 'status' => 'available'));
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            return $query->row_array();}
    }
    
        
    public function insert_image($img_data)
    {
        $this->db->insert('images',$img_data);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
    }
    
    public function insert_imagecity($city)
    {
        $sql = "update city_images set number = number + 1 where CONCAT(city_name , ', ' , country_name) = '".$city."'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
    }
    
    public function get_cityimages()
    {
        $sql = "select * from city_images where number !='0'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->result_array();
            return $returnval;
        } 
    }
    
    public function get_citycount()
    {
        $sql = "select count(city_code) as count from city_images where number !='0'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval['count'];
        } 
    }
    
    public function update_image($img_data)
    {
        $this->db->where('image_id', $img_data['image_id']);
        $this->db->update('images',$img_data);  
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }  
    }
    
    public function delete_image($img_data)
    {
        $this->db->where('image_id', $img_data['image_id']);
        $this->db->update('images',$img_data);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
    }
    
    public function download_image($download_data)
    {
        //insert data to downloads table
        $this->db->insert('downloads',$download_data);
        
        //insert payment into photographer payment_item
        $this->insert_photographer_payment_item($download_data['image_id'],$download_data['download_date']);
        
        //insery payment into supervisor_payment_item
        $this->insert_supervisor_payment_item($download_data['image_id'],$download_data['download_date']);
        
        //insert payment into admin_payment_item
        $this->insert_admin_payment_item($download_data['image_id'],$download_data['download_date']);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        } 
    }
    
    public function insert_photographer_payment_item ($image_id,$download_date)
    {
        $this->load->helper('date');
        $timestamp=date('jmohis');
        
        $img_info=$this->get_imageinfo($image_id);
        
        $payment_item_info['payment_item_id'] = 'photographer_payment_item'.$image_id.$timestamp;
        $payment_item_info['image_id']=$image_id;
        $payment_item_info['download_date']=$download_date;
        $payment_item_info['expected_date']= date('Y-m-d', mktime(0, 0, 0, date('m')+1, 1, date('Y')));
        $payment_item_info['commission_rate']=$this->get_configuration('commission_photographer');
        
        $payment_item_info['amount']=($img_info['price'] * $this->get_configuration('commission_photographer'))/100;
        $payment_item_info['username'] = $img_info['owner'];
        $payment_item_info['status'] = 'new';
        $payment_item_info['payment_id'] = '';
        
        $this->db->insert('photographer_payment_item',$payment_item_info);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        } 
    }
    
    public function insert_supervisor_payment_item ($image_id,$download_date)
    {
        $this->load->helper('date');
        $timestamp=date('jmohis');
        
        $img_info=$this->get_imageinfo($image_id);
        
        $payment_item_info['payment_item_id'] = 'supervisor_payment_item'.$image_id.$timestamp;
        $payment_item_info['image_id']=$image_id;
        $payment_item_info['download_date']=$download_date;
        $payment_item_info['expected_date']= date('Y-m-d', mktime(0, 0, 0, date('m')+1, 1, date('Y')));
        $payment_item_info['commission_rate']=$this->get_configuration('commission_supervisor');
        $payment_item_info['amount']=($img_info['price'] * $this->get_configuration('commission_supervisor'))/100;
        $payment_item_info['username'] = $this->get_image_supervisor($image_id);
        $payment_item_info['status'] = 'new';
        $payment_item_info['payment_id'] = '';
        
        $this->db->insert('supervisor_payment_item',$payment_item_info);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        } 
    }
    
    public function insert_admin_payment_item ($image_id,$download_date)
    {
        $this->load->helper('date');
        $timestamp=date('jmohis');
        
        $img_info=$this->get_imageinfo($image_id);
        
        $payment_item_info['payment_item_id'] = 'admin_payment_item'.$image_id.$timestamp;
        $payment_item_info['image_id']=$image_id;
        $payment_item_info['download_date']=$download_date;
        $payment_item_info['commission_rate']=$this->get_configuration('commission_admin');
        $payment_item_info['amount']=$img_info['price'] * $this->get_configuration('commission_admin');
        $payment_item_info['status'] = 'new';
        
        $this->db->insert('admin_payment_item',$payment_item_info);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        } 
    }
    
    public function get_configuration ($name)
    {
        $sql = "select $name as value from configuration";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval['value'];
        }
    }
    
    public function get_image_supervisor ($image_id)
    {
        $owner = $this->get_imageowner($image_id);
        $sql = "select supervisor from photographers WHERE email='".$owner."'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval['supervisor'];
        }
    }
    
    public function get_imageowner($image_id)
    {
        $sql = "select u.* from photographers as u, images where images.image_id='".$image_id."' and images.owner=u.email";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_imagebase64($image_id)
    {
        $sql = "select base64 from images, users where image_id='$image_id' AND owner=username";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_imageinfo($image_id)
    {
        $sql = "select * from images where image_id='$image_id'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_imagedownloadtimes_status($status)
    {
        $sql = "select images.image_id, count(download_id) as count from images, downloads where images.image_id=downloads.image_id AND images.status='available' GROUP BY images.image_id";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            return $query->result_array();
        } 
    }

    public function get_imagedownloadtimes($image_id)
    {
        $sql = "select count(download_id) as count from images, downloads where images.image_id=downloads.image_id AND downloads.image_id='$image_id'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_imagepayment($image_id)
    {
        $sql = "select sum(value) as sum from user_payment where image_id='$image_id' AND status='complete'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_uncounteddownload($image_id)
    {
        $sql = "select count(download_id) as count from downloads where image_id='$image_id' AND payment_count='false'";
        
        $query=$this->db->query($sql);
          
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval;
        } 
    }
    
    public function get_uncounteddownloadlist($image_id)
    {
        $sql = "select * from downloads where image_id='$image_id' AND payment_count='false'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->result_array();
            return $returnval;
        } 
    }
    
    public function insert_payment($image_id, $download)
    {
        $this->load->helper('date');
        $img_info=$this->get_imageinfo($image_id);
        $paymentinfo['payment_id']=$img_info['image_id'].date('jmohis');
        $paymentinfo['image_id']=$img_info['image_id'];
        $paymentinfo['value']=$img_info['price'];
        $paymentinfo['date']=mdate("%y-%m-%d");
        $paymentinfo['expected_date']= date('Y-m-d', mktime(0, 0, 0, date('m')+1, 1, date('Y')));
        $paymentinfo['status']='new';
        $paymentinfo['user']=$img_info['owner'];
        $paymentinfo['receive_account']=$img_info['paypalaccount'];
        
        //insert the new row for payment table
        $sql = "INSERT INTO `user_payment`(`payment_id`, `image_id`, `value`, `date`, `expected_date`, `status`, `transaction_id`, `receive_account`, `user`) VALUES ('".$paymentinfo['payment_id']."','".$paymentinfo['image_id']."','".$paymentinfo['value']."','".$paymentinfo['date']."','".$paymentinfo['expected_date']."','".$paymentinfo['status']."','','". $paymentinfo['receive_account'] ."','".$paymentinfo['user']."')";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        //update the download id to counted
        foreach ($download as $download_item)
        {
            $this->update_paymentcount($download_item);
        }
        
    }
    
    public function update_paymentcount($download_item)
    {
        $id=$download_item['download_id'];
        $sql = "update downloads set payment_count='true' where download_id='$id'";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
    }
    
    public function get_imagesbyowner($owner)
    {
        $sql="select * from images where owner='$owner' and status='available' ORDER BY upload_date DESC";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else    
            {return $query->result_array();}
    }
    
    public function get_newimagesbyowner($owner)
    {
        $sql="select * from images where owner='$owner' and status='new' ORDER BY upload_date DESC";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else    
            {return $query->result_array();}
    }
    
    public function get_downloadinfo($image_id,$mode)
    {
        $sql = "select count(download_id) as count from images, downloads where images.image_id=downloads.image_id AND downloads.image_id='$image_id' AND downloads.type='$mode'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            return $returnval['count'];
        } 
    }
    
    //review code
    
    function get_latestreviewcode($imageid,$type)
    {
        $sql="SELECT result, review_id from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' and value='' ORDER BY image_review.review_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            $latestreviewapproveid = $this->get_reviewapproveid($imageid,$type);
            
            if ($returnval['review_id']>$latestreviewapproveid)
                return $returnval['result'];
            return '-1';
        }
    }
    
    function get_reviewapproveid($imageid,$type)
    {
        $sql="SELECT review_id from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' and result='0' ORDER BY image_review.review_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            return $returnval['review_id'];
        }
    }
    
    function check_ifinreview($imageid,$type)
    {
        $sql="SELECT review_id from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' and result='-1' and value!='' ORDER BY image_review.review_id DESC LIMIT 1";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit();
        }
        $latestupdate = $query->row_array();
        
        $sql1="SELECT review_id from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' and value='' ORDER BY image_review.review_id DESC LIMIT 1";
        $query1=$this->db->query($sql1);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit ();
        }
        $latestreview = $query1->row_array();
       
        if ($latestreview == null && $latestupdate == null)
            return false;
        else if ($latestreview == null && $latestupdate != null)
            return true;
        else if ($latestreview != null && $latestupdate == null)
            return false;
        else
        {
            if ($latestupdate['review_id'] > $latestreview['review_id'])
                return true;
            return false;
        
        }
    }
    
    function get_latestreviewvalue($code)
    {
        if ($code=='0') return '';
        
        $sql="SELECT detail from reject_type WHERE id='$code'";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            return $returnval['detail'];
        }
    }
    
    function get_latestreviewtext($imageid,$type)
    {
        $sql="SELECT review_id, value from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' and result='-1' and value!='' ORDER BY image_review.review_id DESC LIMIT 1";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit();
        }
        $latestupdate = $query->row_array();
        
        $sql1="SELECT review_id from image_review WHERE image_review.image_id='$imageid' AND image_review.type='$type' AND value='' AND result='0' ORDER BY image_review.review_id DESC LIMIT 1";
        $query1=$this->db->query($sql1);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit ();
        }
        $latestreview = $query1->row_array();
        
        
        if ($latestreview == null && $latestupdate == null)
            return '-1';
        else if ($latestreview == null && $latestupdate != null)
            return $latestupdate['value'];
        else if ($latestreview != null && $latestupdate == null)
            return '-1';
        else
        {
            if ($latestupdate['review_id'] > $latestreview['review_id'])
                return $latestupdate['value'];
            return '-1';
        
        }
    }
    
    public function update_imagedetailreview($img_data)
    {
        $id = $img_data['imageid'];
        $type = $img_data['type'];
        $value = $img_data['value'];
        $date = $img_data['date'];
        // insert initial quality review
        $sql="INSERT INTO `image_review` (image_id,type,result,review_date, value) VALUES ('$id','$type','-1','$date','$value')";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            return false;
        }
        
        return true;
    }
    
    public function get_reviewhistory($image_id)
    {
        $sql = "select * from image_review where image_id='$image_id'";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->result_array();
            if ($returnval == null)
                return '-1';
            return $returnval;
        } 
    }
    
    //change code
    
    public function get_changehistory($image_id)
    {
        $sql = "select * from image_change where image_id='$image_id' ORDER BY review_date ASC";
        $query=$this->db->query($sql);
        
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->result_array();
            if ($returnval == null)
                return '-1';
            return $returnval;
        } 
    }
    
    function get_latestchangecode($imageid,$type)
    {
        $sql="SELECT result, change_id from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' and value='' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            $latestreviewapproveid = $this->get_changeapproveid($imageid,$type);
            
            if ($returnval['change_id']>$latestreviewapproveid)
                return $returnval['result'];
            return '-1';
        }
    }
    
    function get_latestchangeid($imageid,$type)
    {
        $sql="SELECT result, change_id from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' AND result='-1' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            $latestchangeapproveid = $this->get_changeapproveid($imageid,$type);
            if ($returnval['change_id']>$latestchangeapproveid)
                return $returnval['change_id'];
            return '-1';
        }
    }
    
    function get_latestopenchangeid($imageid,$type)
    {
        $sql="SELECT result, change_id from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' AND result='-1' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            $latestchangeapproveid = $this->get_changeapproveid($imageid,$type);
            if ($returnval['change_id']>$latestchangeapproveid)
                return $returnval['change_id'];
            return '-1';
        }
    }
    
    function get_changeapproveid($imageid,$type)
    {
        $sql="SELECT change_id from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' and result='0' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            return $returnval['change_id'];
        }
    }
    
    
    function check_ifinchange($imageid,$type)
    {
        $sql="SELECT change_id,review_date from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' and result='-1' and value!='' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit();
        }
        $latestupdate = $query->row_array();
        
        $sql1="SELECT change_id,review_date from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' and value='' ORDER BY image_change.change_id DESC LIMIT 1";
        $query1=$this->db->query($sql1);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit ();
        }
        $latestreview = $query1->row_array();
       
        if ($latestreview == null && $latestupdate == null)
            return false;
        else if ($latestreview == null && $latestupdate != null)
            return true;
        else if ($latestreview != null && $latestupdate == null)
            return false;
        else
        {
           
            if ($latestupdate['review_date'] > $latestreview['review_date'])
                return true;
            return false;
        
        }
    }
    
    function get_latestchangevalue($code)
    {
        if ($code=='0') return '';
        
        $sql="SELECT detail from reject_type WHERE id='$code'";
        $query=$this->db->query($sql);

        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
        }
        else
        {
            $returnval = $query->row_array();
            if ($returnval == null)
                return '-1';
            return $returnval['detail'];
        }
    }
    
    function get_latestchangetext($imageid,$type)
    {
        $sql="SELECT change_id, value from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' and result='-1' and value!='' ORDER BY image_change.change_id DESC LIMIT 1";
        $query=$this->db->query($sql);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit();
        }
        $latestupdate = $query->row_array();
        
        $sql1="SELECT change_id from image_change WHERE image_change.image_id='$imageid' AND image_change.type='$type' AND value='' AND result='0' ORDER BY image_change.change_id DESC LIMIT 1";
        $query1=$this->db->query($sql1);
        if ($this->db->_error_number()){
            show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
            exit ();
        }
        $latestreview = $query1->row_array();
        
        
        if ($latestreview == null && $latestupdate == null)
            return '-1';
        else if ($latestreview == null && $latestupdate != null)
            return $latestupdate['value'];
        else if ($latestreview != null && $latestupdate == null)
            return '-1';
        else
        {
            if ($latestupdate['change_id'] > $latestreview['change_id'])
                return $latestupdate['value'];
            return '-1';
        
        }
    }
    
    public function update_imagedetail($img_data)
    {
        $id = $img_data['imageid'];
        $type = $img_data['type'];
        $value = $img_data['value'];
        $date = $img_data['date'];
        
        //search for current open change request, if yes overwrite it, if no insert new record
        $latestchange = $this->get_latestchangeid($id,$type);
        if ($latestchange == '-1')
        {
            $sql="INSERT INTO `image_change` (image_id,type,result,review_date, value) VALUES ('$id','$type','-1','$date','$value')";
            $query=$this->db->query($sql);
            if ($this->db->_error_number()){
                show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
                return false;
            }
        }
        else
        {
            $sql="UPDATE `image_change` SET review_date='$date', value ='$value' WHERE change_id='$latestchange'";
            $query=$this->db->query($sql);
            if ($this->db->_error_number()){
                show_error('Our system is having some difficulties processing your request at the moment. <br> Please try again later, we are sorry for this inconvenience.<br> <a href="/">Back to home</a>',500,'Opps! There is something wrong');
                return false;
            }
        }
        
        
        
        
        
        return true;
    }
    
    
    


}


?>
