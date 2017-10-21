<?php
class Model_news extends CI_Model
{
	private $_table = "news";

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function get_news($limit = NULL, $off = NULL, $order = NULL)
	{
		$this->db->from($this->_table);
		$this->db->limit($limit, $off);

		if (!empty($order))
		{
			$this->db->order_by($order);
		}
		else
		{
			$this->db->order_by('datetime DESC');
		}

		$query = $this->db->get();
		$data = $query->result_array();

        return $data;
    }

	public	function count_rows()
	{
        return $this->db->count_all($this->_table);
    }

    public function get_news_by_id($id)
    {
        $this->db->from($this->_table);
        $this->db->where('id', (int) $id);

        $query = $this->db->get();
        $data = $query->row_array();

        return $data;
    }

    public function insert_news($data)
    {
        if($this->db->insert($this->_table, $data))
            return true;
        else
            return false;
    }

    public function update_news($data, $id)
    {
        $this->db->where("id", (int) $id);

        if($this->db->update($this->_table, $data))
            return true;
        else
            return false;
    }
}
