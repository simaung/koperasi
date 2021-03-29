<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Anggota_model extends MY_Model
{
    // public $table = 't_anggota'; //nama tabel dari database
    // public $column = array(null, 'id', 'nama_anggota', 'alamat_anggota', 'tgl_masuk', 'status');
    // public $order = array('id' => 'desc'); // default order 

    public $table = 'v_tabungan_anggota'; //nama tabel dari database
    public $column = array(null, 'id', 'nama_anggota', 'alamat_anggota', 'tgl_masuk', 'status', 'total_tabungan', 'total_pinjam', 'jumlah_angsuran');
    public $order = array('id' => 'desc'); // default order 

    function __construct()
    {
        parent::__construct();
    }

    private function _get_table_query($status)
    {
        $this->db->select($this->column);
        $this->db->from($this->table);
        $i = 0;

        foreach ($this->column as $item) {

            if ($status != '') {
                $this->db->where('status', $status);
            }

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

    function get_datatables($status)
    {
        $this->_get_table_query($status);
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($status)
    {
        $this->_get_table_query($status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function tambah_anggota($id_petugas)
    {
        $post = $this->input->post();

        $total_simpan =  rpToInt($post['simpanan']);
        $pokok = $this->get_data('t_setting', array('name' => 'pokok'), true)[0]->nilai;
        $wajib = $this->get_data('t_setting', array('name' => 'wajib'), true)[0]->nilai;

        $sukarela = $total_simpan - $pokok - $wajib;

        $data_anggota = array(
            'nama_anggota'      => $post['nama_anggota'],
            'alamat_anggota'    => $post['alamat'],
            'jenis_kelamin'     => $post['jenis_kelamin'],
            'pekerjaan'         => $post['pekerjaan'],
            'tgl_masuk'         => tgl_db($post['tgl_masuk']),
            'tgl_lahir'         => tgl_db($post['tgl_lahir']),
            'tempat_lahir'      => $post['tempat_lahir'],
            'telp'              => removeChar($post['telp']),
            'petugas_id'        => $id_petugas,
        );

        $this->db->insert('t_anggota', $data_anggota);
        $anggota = $this->db->insert_id();

        $data_simpanan = array(
            'anggota_id'        => $anggota,
            'jumlah_setor'      => $total_simpan,
            'pokok'             => $pokok,
            'wajib'             => $wajib,
            'sukarela'          => $sukarela,
            'petugas_id'        => $id_petugas,
        );

        $simpanan = $this->db->insert('t_simpan', $data_simpanan);

        if ($simpanan) {
            $result = array(
                'code'          => '200',
                'message'       => 'Tambah Anggota beserta simpanan berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Tambah Anggota beserta simpanan gagal!',
            );
        }
        return $result;
    }

    function update_anggota($id)
    {
        $post = $this->input->post();

        $data_anggota = array(
            'nama_anggota'      => $post['nama_anggota'],
            'alamat_anggota'    => $post['alamat'],
            'jenis_kelamin'     => $post['jenis_kelamin'],
            'pekerjaan'         => $post['pekerjaan'],
            'tgl_masuk'         => tgl_db($post['tgl_masuk']),
            'tgl_lahir'         => tgl_db($post['tgl_lahir']),
            'tempat_lahir'      => $post['tempat_lahir'],
            'telp'              => removeChar($post['telp']),
        );

        $this->db->where('id', $id);
        $anggota = $this->db->update('t_anggota', $data_anggota);;

        // $data_simpanan = array(
        //     'anggota_id'        => $anggota,
        //     'jumlah_setor'      => $total_simpan,
        //     'pokok'             => $pokok,
        //     'wajib'             => $wajib,
        //     'sukarela'          => $sukarela,
        //     'petugas_id'        => $id_petugas,
        // );

        // $simpanan = $this->db->insert('t_simpan', $data_simpanan);

        if ($anggota) {
            $result = array(
                'code'          => '200',
                'message'       => 'Data Anggota berhasil di update!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Data Anggota gagal di update!',
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
