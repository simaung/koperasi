<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Simpanan_model extends MY_Model
{
    public $table = 't_simpan'; //nama tabel dari database
    public $column = array(null, 't_simpan.id', 'anggota_id', 'created_at', 'jumlah_setor', 'pokok', 'wajib', 'sukarela');
    public $order = array('created_at' => 'desc'); // default order 

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query()
    {
        $this->db->select($this->column);
        $this->db->select('t_anggota.nama_anggota');
        $this->db->select('t_angsuran.jumlah_angsuran, t_angsuran.jasa');
        $this->db->join('t_anggota', $this->table . '.anggota_id = t_anggota.id');
        $this->db->join('t_angsuran', $this->table . '.id = t_angsuran.simpan_id', 'left');
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) {

            if ($this->input->post('nomor_anggota')) {
                if ($i === 0) {
                    $this->db->like('id', $_POST['nomor_anggota']);
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

            if ($this->input->post('status_anggota')) {
                if ($i === 0) {
                    $this->db->where('status', $_POST['status_anggota']);
                } else {
                    $this->db->or_where($item, $this->input->post('status_anggota'));
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

    function get_simpanan()
    {
        $this->db->select('sum(pokok) + sum(wajib) + sum(sukarela) as total_simpanan');
        $this->db->select('sum(total_pinjam) - sum(jumlah_angsuran) as total_pinjaman');
        $query = $this->db->get('v_tabungan_anggota');
        return $query->row();
    }

    function tambah_simpanan($id_petugas)
    {
        $post = $this->input->post();

        $data_simpan = array(
            'anggota_id'        => $post['id_anggota'],
            'jumlah_setor'      => $post['jumlah_setor'],
            'wajib'             => $post['wajib'],
            'sukarela'          => $post['sukarela'],
            'petugas_id'        => $id_petugas,
        );

        $this->db->insert('t_simpan', $data_simpan);
        $simpan = $this->db->insert_id();

        if ($post['sisa_pinjaman'] > 0) {
            $sisa_pinjaman = $post['sisa_pinjaman'] - $post['angsuran'];

            $data_angsuran = array(
                'pinjam_id'         => $post['pinjam_id'],
                'simpan_id'         => $simpan,
                'jumlah_angsuran'   => $post['angsuran'],
                'jasa'              => $post['jasa'],
                'sisa_pinjaman'     => $sisa_pinjaman,
            );

            $angsuran = $this->db->insert('t_angsuran', $data_angsuran);
        }

        if ($simpan || $angsuran) {
            $result = array(
                'code'          => '200',
                'message'       => 'Tambah Anggota beserta simpanan berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Tambah jamaah beserta tabungan gagal!',
            );
        }
        return $result;
    }

    function get_data_simpanan($where)
    {
        $this->db->select('a.*');
        $this->db->select('t_anggota.id as anggota_id, t_anggota.nama_anggota');
        $this->db->where($where);
        $this->db->select('t_angsuran.jumlah_angsuran, t_angsuran.jasa');
        $this->db->join('t_anggota', 'a.anggota_id = t_anggota.id');
        $this->db->join('t_angsuran', 'a.id = t_angsuran.simpan_id', 'left');
        $this->db->order_by('a.created_at', 'desc');
        $query = $this->db->get('t_simpan a');
        return $query->result();
    }
}
