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
            $data_kas = array(
                'description'   => 'Biaya Admin Pinjaman Nomor Anggota : ' . $get_pinjam->anggota_id . ' Sebesar : ' . rp($get_pinjam->total_pinjam),
                'type'          => 'debet',
                'amount'        => $post['provisi'],
            );

            $this->db->insert('t_kas', $data_kas);

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

    function pelunasan_pinjaman($id_petugas)
    {
        $post = $this->input->post();

        $data_ambil = array(
            'anggota_id'        => $post['id_anggota'],
            'type'              => 'pengambilan simpanan',
            'petugas_id'        => $id_petugas,
        );

        if ($post['status'] == 'keluar') {
            $data_ambil['total_ambil'] = $post['tabungan'];
        } else {
            $data_ambil['total_ambil'] = $post['pinjaman'] + $post['jasa'];
        }

        $this->db->insert('t_pengambilan', $data_ambil);

        $data_simpan = array(
            'anggota_id'        => $post['id_anggota'],
            'petugas_id'        => $id_petugas,
        );

        if ($post['status'] == 'keluar') {
            $data_simpan['jumlah_setor'] = $post['tabungan'] + $post['total'];
        } else {
            $data_simpan['jumlah_setor'] = $post['pinjaman'] + $post['jasa'];
        }

        $this->db->insert('t_simpan', $data_simpan);
        $simpan = $this->db->insert_id();

        $data_angsuran = array(
            'pinjam_id'         => $post['id_pinjam'],
            'simpan_id'         => $simpan,
            'jasa'              => $post['jasa'],
            'sisa_pinjaman'     => 0,
        );

        if ($post['status'] == 'keluar') {
            $data_angsuran['jumlah_angsuran'] = $post['tabungan'] + $post['kurang'];
        } else {
            $data_angsuran['jumlah_angsuran'] = $post['pinjaman'];
        }

        $this->db->where('id', $post['id_pinjam']);
        $this->db->update('t_pinjam', array('status' => 'lunas'));

        $angsuran = $this->db->insert('t_angsuran', $data_angsuran);

        if ($post['status'] == 'keluar') {
            $data_kas = array(
                'type'          => 'debet',
                'description'   => 'Tambah kekurangan pelunasan pinjaman nomor anggota : ' . $post['id_anggota'],
                'amount'        => $post['total']
            );
            $kas = $this->db->insert('t_kas', $data_kas);
        }

        if ($post['status'] == 'keluar') {
            $this->update_data('t_anggota', array('status' => 'keluar', 'tgl_keluar' => date('Y-m-d')), array('id' => $post['id_anggota']));

            //update transaksi anggota sebelum keluar menjadi nonaktif
            $this->update_data('t_simpan', array('status' => 'nonaktif'), array('anggota_id' => $post['id_anggota']));
            $this->update_data('t_pengambilan', array('status' => 'nonaktif'), array('anggota_id' => $post['id_anggota']));
            $this->update_data('t_angsuran', array('status' => 'nonaktif'), array('pinjam_id' => $post['id_pinjam']));
        }

        if ($angsuran) {
            $result = array(
                'code'          => '200',
                'message'       => 'Pelunasan pinjaman berhasil!',
            );
        } else {
            $result = array(
                'code'          => '400',
                'message'       => 'Pelunasan pinjaman gagal!',
            );
        }
        return $result;
    }
}
