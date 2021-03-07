<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Petugas_model extends MY_Model
{
    public $table = 't_user'; //nama tabel dari database
    public $column = array(null, 'id', 'nik', 'nama', 'phone', 'tgl_masuk', 'level', 'access_system');
    public $order = array('id' => 'desc'); // default order 

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query()
    {
        $this->db->select($this->column);
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) {

            if ($this->input->post('nomor_petugas')) {
                if ($i === 0) {
                    $this->db->like('id', $_POST['nomor_petugas']);
                } else {
                    $this->db->or_like($item, $this->input->post('nomor_petugas'));
                }
            }

            if ($this->input->post('nama')) {
                if ($i === 0) {
                    $this->db->like('nama', $_POST['nama']);
                } else {
                    $this->db->or_like($item, $this->input->post('nama'));
                }
            }

            if ($this->input->post('level')) {
                if ($i === 0) {
                    $this->db->where('level', $_POST['level']);
                } else {
                    $this->db->or_where($item, $this->input->post('level'));
                }
            }

            // if ($this->input->post('status_anggota')) {
            //     if ($i === 0) {
            //         $this->db->where('status', $_POST['status_anggota']);
            //     } else {
            //         $this->db->or_where($item, $this->input->post('status_anggota'));
            //     }
            // }
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_table_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_table_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function tambah_petugas($id_petugas)
    {
        $post = $this->input->post();

        $data_petugas = array(
            'nik'               => $post['nik'],
            'nama'              => $post['nama_petugas'],
            'tgl_entri'         => date('Y-m-d'),
            'tgl_masuk'         => tgl_db($post['tgl_masuk']),
            'password'          => MD5('123456'),
            // 'level'             => $post['level'],
            // 'access_system'     => $post['access_system'],
        );

        $this->db->insert('t_user', $data_petugas);
        $petugas = $this->db->insert_id();



        if ($petugas) {
            $result = array(
                'code'          => '200',
                'message'       => 'Tambah petugas berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Tambah petugas gagal!',
            );
        }
        return $result;
    }

    function get_data_anggota($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('v_tabungan_anggota');
        return $query->row();
    }
}
