<?php
class Model_config extends CI_Model
{
	private $_site_config = 'site_config';
	private $_banner = 'banner';
	private $_company_shipper = 'company_shipper';
	private $_order_extra_fee = 'order_extra_fee';

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_config()
	{
		$query = $this->db->get($this->_site_config);

		if (!$query)
		{
			return false;
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_config_by_name($config_name)
	{
		$this->db->where('config_name', $config_name);
		$query = $this->db->get($this->_site_config);

		if (!$query)
		{
			return false;
		}
		else
		{
			$ret = $query->row_array();
			
			return $ret['config_value'];
		}
	}
	
	public function check_login($email, $pass)
	{
		$flag = 0;
		$config_username = $this->get_config_by_name ('admin_username');
		$config_password = $this->get_config_by_name ('admin_password');
		if($email != "" || $pass != "")
		{
			if($email == $config_username)
			{
				if(md5($pass) == $config_password)
				{
					$sess = array('sup_email' => $config_username,
								  'sup_id' => $config_username);
					$this->session->sess_expiration = 3600;
					$this->session->set_userdata($sess);
					$flag = 3;
				}
				else 
				{
					$flag = 2;
				}
			}
			else
			{
				$flag = 1;
			}
		}
		return $flag;
	}

	public function get_banner()
	{
		$query = $this->db->get($this->_banner);

		if (!$query)
		{
			return false;
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_banner_by_pos($pos)
	{
		$this->db->where('banner_position', (int) $pos);
		$query = $this->db->get($this->_banner);

		if (!$query)
		{
			return false;
		}
		else
		{
			return $query->num_rows();
		}
	}

	public function get_shipping()
	{
		$query = $this->db->get($this->_company_shipper);

		if (!$query)
		{
			return false;
		}
		else
		{
			return $query->result_array();
		}
	}

	public function insert_shipping($data)
	{
        if($this->db->insert($this->_company_shipper, $data))
			return true;
		else
			return false;
    }

    public function update_shipping($data, $id)
	{
        $this->db->where("com_shipper_id", (int) $id);

        if($this->db->update($this->_company_shipper, $data))
        {
			return true;
        }
		else
		{
			return false;
		}
    }

    public function insert_banner($data)
	{
        if($this->db->insert($this->_banner, $data))
			return true;
		else
			return false;
    }

    public function update_banner($data, $pos)
	{
        $this->db->where("banner_position", (int) $pos);

        if($this->db->update($this->_banner, $data))
        {
			return true;
        }
		else
		{
			return false;
		}
    }

    public function update_config($data, $config_name)
	{
        $this->db->where("config_name", (string) $config_name);

        if($this->db->update($this->_site_config, $data))
        {
			return true;
        }
		else
		{
			return false;
		}
    }

    public function update_tax_value($data, $id)
	{
        $this->db->where("order_extra_fee_id", (int) $id);

        if($this->db->update($this->_order_extra_fee, $data))
        {
			return true;
        }
		else
		{
			return false;
		}
    }
}
?>
