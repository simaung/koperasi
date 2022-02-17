<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Saldo_model extends MY_Model
{
    public $table = 't_saldo';
    public $column = array('id', 'tanggal', 'saldo');
    public $order = array('tanggal' => 'desc');

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query()
    {
        $this->db->select($this->column);
        $this->db->from($this->table);
        $i = 0;

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

    function tambah_transaksi()
    {
        $post = $this->input->post();

        $data_saldo = array(
            'tanggal'      => tgl_db($post['tanggal']),
            'saldo'        => $post['saldo'],
        );

        $simpan = $this->db->insert('t_saldo', $data_saldo);

        if ($simpan) {
            $result = array(
                'code'          => '200',
                'message'       => 'Saldo berhasil disimpan!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Saldo gagal disimpan!',
            );
        }
        return $result;
    }

    function update_transaksi()
    {
        $post = $this->input->post();

        $data_saldo = array(
            'saldo'        => $post['saldo'],
        );

        $this->db->where('id', $post['id']);
        $update = $this->db->update('t_saldo', $data_saldo);;

        if ($update) {
            $result = array(
                'code'          => '200',
                'message'       => 'Saldo berhasil diupdate!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Saldo gagal diupdate!',
            );
        }
        return $result;
    }

    function delete_transaksi($id)
    {
        $this->db->where('id', $id);
        $delete = $this->db->delete('t_saldo');

        if ($delete) {
            $result = array(
                'code'          => '200',
                'message'       => 'Data berhasil dihapus!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Data gagal dihapus!',
            );
        }
        return $result;
    }
}
