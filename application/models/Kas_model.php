<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kas_model extends MY_Model
{
    public $table = 't_kas';
    public $column = array(null, 'id', 'type', 'description', 'amount', 'tgl_entry');
    public $order = array('id' => 'desc');

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query()
    {
        $this->db->select($this->column);
        $this->db->not_like('description', 'Biaya Admin Pinjaman');
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) {
            if ($this->input->post('description')) {
                if ($i === 0) {
                    $this->db->like('description', $_POST['description']);
                } else {
                    $this->db->or_like($item, $this->input->post('description'));
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

    function tambah_transaksi($id_petugas)
    {
        $post = $this->input->post();

        for ($i = 0; $i < count($post['description']); $i++) {
            if (!empty($post['debet'][$i])) {
                $type = 'debet';
                $amount = preg_replace('/\D/', '', $post['debet'][$i]);
            } else {
                $type = 'kredit';
                $amount = preg_replace('/\D/', '', $post['kredit'][$i]);
            }

            $data_kas = array(
                'description'   => $post['description'][$i],
                'type'          => $type,
                'amount'        => $amount,
            );

            $simpan = $this->db->insert('t_kas', $data_kas);
        }

        if ($simpan) {
            $result = array(
                'code'          => '200',
                'message'       => 'Transaksi berhasil disimpan!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Transaksi gagal disimpan!',
            );
        }
        return $result;
    }

    function get_data_simpanan($where)
    {
        $this->db->select('a.*');
        $this->db->select('t_anggota.id as anggota_id, t_anggota.nama_anggota');
        $this->db->where($where);
        $this->db->where('a.show_report', '1');
        $this->db->select('t_angsuran.jumlah_angsuran, t_angsuran.jasa');
        $this->db->join('t_anggota', 'a.anggota_id = t_anggota.id');
        $this->db->join('t_angsuran', 'a.id = t_angsuran.simpan_id', 'left');
        $this->db->order_by('a.created_at', 'desc');
        $query = $this->db->get('t_simpan a');
        return $query->result();
    }
}
