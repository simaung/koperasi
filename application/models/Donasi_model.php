<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Donasi_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}

	function get_donasi()
	{
		$this->db->select('a.*');
		$this->db->select('b.*');
		$this->db->join('mst_donasi b', 'a.id = b.id', 'left');
		$query = $this->db->get('v_jumlah_donasi a');

		return $query->result();
	}

	function detail($slug)
	{
		$this->db->select('a.*');
		$this->db->select('b.*');
		$this->db->where('b.slug', $slug);
		$this->db->join('mst_donasi b', 'a.id = b.id', 'left');
		$query = $this->db->get('v_jumlah_donasi a');

		return $query->row();
	}

	function donatur($slug, $limit = 3)
	{
		$this->db->select('a.*, c.full_name');
		$this->db->where('b.slug', $slug);
		$this->db->join('mst_donasi b', 'a.donasi_id = b.id', 'left');
		$this->db->join('user_partner c', 'a.partner_id = c.partner_id', 'left');
		$this->db->order_by('a.id', 'DESC');
		$this->db->limit($limit);
		$query = $this->db->get('trans_donasi a');

		return $query->result();
	}

	function total_donatur($slug)
	{
		$this->db->select('a.id');
		$this->db->where('b.slug', $slug);
		$this->db->join('mst_donasi b', 'a.donasi_id = b.id', 'left');
		$query = $this->db->get('trans_donasi a');

		return $query->num_rows();
	}
}
