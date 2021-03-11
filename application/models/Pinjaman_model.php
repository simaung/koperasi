<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pinjaman_model extends MY_Model
{
    public $table = 't_pinjam'; //nama tabel dari database
    public $column = array(null, 't_pinjam.id', 'anggota_id', 'total_pinjam', 'lama_angsuran', 'bunga', 'tgl_entry', 't_pinjam.status', 'status_pengajuan', 'status_ambil', 'tgl_persetujuan');
    public $order = array('t_pinjam.id' => 'desc'); // default order 

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query()
    {
        $this->db->select($this->column);
        $this->db->select('t_anggota.nama_anggota');
        $this->db->join('t_anggota', $this->table . '.anggota_id = t_anggota.id');
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) {

            if ($this->input->post('nomor_anggota')) {
                if ($i === 0) {
                    $this->db->like('anggota_id', $_POST['nomor_anggota']);
                } else {
                    $this->db->or_like($item, $this->input->post('nomor_anggota'));
                }
            }

            if ($this->input->post('nama_anggota')) {
                if ($i === 0) {
                    $this->db->like('nama_anggota', $_POST['nama_anggota']);
                } else {
                    $this->db->or_like($item, $this->input->post('nama_anggota'));
                }
            }

            if ($this->input->post('status_pengajuan')) {
                if ($i === 0) {
                    $this->db->where('status_pengajuan', $_POST['status_pengajuan']);
                } else {
                    $this->db->or_where($item, $this->input->post('status_pengajuan'));
                }
            }
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

    function tambah_pengajuan($id_petugas)
    {
        $post = $this->input->post();

        $data_pinjam = array(
            'anggota_id'        => $post['id_anggota'],
            'total_pinjam'      => $post['total_pinjaman'],
            'lama_angsuran'     => $post['lama_angsuran'],
            'bunga'             => $post['bunga'],
            'petugas_id'        => $id_petugas,
        );

        $this->db->insert('t_pinjam', $data_pinjam);
        $pinjam = $this->db->insert_id();

        if ($pinjam) {
            $result = array(
                'code'          => '200',
                'message'       => 'Tambah pengajuan pinjaman berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Tambah pengajuan pinjaman gagal!',
            );
        }
        return $result;
    }

    function get_data_pinjaman($where)
    {
        $this->db->select('a.*');
        $this->db->select('b.id as anggota_id, b.nama_anggota');
        $this->db->where($where);
        $this->db->join('t_anggota b', 'a.anggota_id = b.id');
        $this->db->order_by('a.tgl_entry', 'desc');
        $query = $this->db->get('t_pinjam a');
        return $query->result();
    }

    function get_data_anggota($id)
    {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('v_tabungan_anggota');
        return $query->row();
    }

    function ambil_pinjaman()
    {
        $post = $this->input->post();

        $this->update_data('t_pinjam', array('status_ambil' => 'ya'), array('id' => $post['id']));

        $get_pinjam = $this->get_data('t_pinjam', array('id' => $post['id']), 'true');

        $data_ambil = array(
            'pinjam_id'     => $get_pinjam->id,
            'anggota_id'    => $get_pinjam->anggota_id,
            'total_ambil'   => $get_pinjam->total_pinjam,
        );

        $this->db->insert('t_pengambilan', $data_ambil);
        $ambil = $this->db->insert_id();

        if ($ambil) {
            $result = array(
                'code'          => '200',
                'message'       => 'Tambah pengajuan pinjaman berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Tambah pengajuan pinjaman gagal!',
            );
        }
        return $result;
    }
}
