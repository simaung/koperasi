<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table = '';
    protected $column_order = array();
    protected $column_search = array();
    protected $order = array();

    public function __construct()
    {
        parent::__construct();
    }

    function get_data($table, $where = array(), $single = 'false', $order_by = '', $order_cond = 'ASC')
    {
        $this->db->select('*');
        if (!empty($where)) {
            $this->db->where($where);
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by, $order_cond);
        }

        if ($single == 'false') {
            $this->db->limit(10);
        } else {
            $this->db->limit(1);
        }

        $query = $this->db->get($table);

        if ($single == 'false') {
            return $query->result();
        } else {
            return $query->row();
        }
    }

    function get_setting($table, $where = array(), $single = 'false')
    {
        $this->db->select('*');
        if (!empty($where)) {
            $this->db->where($where);
        }
        $query = $this->db->get($table);

        if ($single == 'false') {
            return $query->result();
        } else {
            return $query->row();
        }
    }

    function update_data($table, $set, $where)
    {
        $this->db->where($where);
        $query = $this->db->update($table, $set);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_data_kas($where)
    {
        $sql = "
        select * from
        (
            select 
            'kredit' as type,
            type as description,
            total_ambil as amount,
            b.id as nomor_anggota, b.nama_anggota,
            tgl_ambil as tgl_transaksi
            from t_pengambilan a
            left join t_anggota b on a.anggota_id = b.id

            union all

            select
            'debet' as type,
            'Simpanan' as description,
            jumlah_setor as amount,
            b.id as nomor_anggota, b.nama_anggota,
            created_at as tgl_transaksi
            from t_simpan a
            left join t_anggota b on a.anggota_id = b.id
        ) as trans_kas        
        order by trans_kas.tgl_transaksi ASC;
        ";

        $query = $this->db->query($sql)->result();
        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }
}
