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
        } else if ($single == 'all') {
            // $this->db->limit(1);
        } else {
            $this->db->limit(1);
        }

        $query = $this->db->get($table);

        if ($single == 'false') {
            return $query->result();
        } else if ($single == 'all') {
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

    function get_data_kas($sebelumnya = '')
    {
        $post = $this->input->post();
        $where = '';
        $where_kredit = '';
        $where_debet = '';
        $union_all = ' union all ';

        $debet = "
            select
            'debet' as type,
            concat('Simpanan nomor anggota : ', b.id) as description,
            jumlah_setor as amount,
            b.id as nomor_anggota, b.nama_anggota,
            created_at as tgl_transaksi
            from t_simpan a
            left join t_anggota b on a.anggota_id = b.id
        ";

        $kredit = "
            select 
            'kredit' as type,
            concat(type, ' nomor anggota : ', b.id) as description,
            total_ambil as amount,
            b.id as nomor_anggota, b.nama_anggota,
            tgl_ambil as tgl_transaksi
            from t_pengambilan a
            left join t_anggota b on a.anggota_id = b.id
        ";

        $select_kas = "
            select
            type,
            description,
            amount,
            '' as nomor_anggota, '' as nama_anggota,
            tgl_entry as tgl_transaksi
            from t_kas
        ";

        if (!empty($post['status'])) {
            if ($post['status'] == 'kredit') {
                $where = "where type = 'kredit'";
                $select_debet = '';
                $select_kredit = $kredit;
                $select_kas .= $where;
            } else if ($post['status'] == 'debet') {
                $where = "where type = 'debet'";
                $select_debet = $debet . "where show_report = '1'";
                $select_kredit = '';
                $select_kas .= $where;
            }
        } else {
            $select_debet = $debet . "where show_report = '1'";
            $select_kredit = $kredit;
        }

        // if (!empty($post['bulan'])) {
        //     if ($select_kredit != '') {
        //         $where_kredit = "where ";
        //         $select_kredit .= $where_kredit . "MONTH(tgl_ambil ) = '" . $post['bulan'] . "'";
        //     }
        //     if ($select_debet != '') {
        //         $where_debet = "and ";
        //         $select_debet .= $where_debet . "MONTH(created_at ) = '" . $post['bulan'] . "'";
        //     }

        //     if ($where != '') {
        //         $where = ' and ';
        //     } else {
        //         $where = ' where ';
        //     }
        //     $select_kas .= $where . " MONTH(tgl_entry) = '" . $post['bulan'] . "'";
        // }

        // if (!empty($post['tahun'])) {
        //     if ($select_kredit != '') {
        //         if ($where_kredit != '') {
        //             $where_kredit = ' and ';
        //         } else {
        //             $where_kredit = ' where ';
        //         }
        //         $select_kredit .= $where_kredit . "YEAR(tgl_ambil ) = '" . $post['tahun'] . "'";
        //     }
        //     if ($select_debet != '') {
        //         if ($where_debet != '') {
        //             $where_debet = ' and ';
        //         } else {
        //             $where_debet = ' where ';
        //         }
        //         $select_debet .= $where_debet . "YEAR(created_at ) = '" . $post['tahun'] . "'";
        //     }

        //     if ($where != '') {
        //         $where = ' and ';
        //     } else {
        //         $where = ' where ';
        //     }
        //     $select_kas .= $where . " YEAR(tgl_entry) = '" . $post['tahun'] . "'";
        // }

        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);
            $tgl_sebelum = date('Y-m-d', strtotime($tgl_awal . ' - 7 days'));

            if ($select_kredit != '') {
                if ($where_kredit != '') {
                    $where_kredit = ' and ';
                } else {
                    $where_kredit = ' where ';
                }
                if ($sebelumnya == '') {
                    $where_kredit .= "tgl_ambil >= '" . $tgl_awal . " 00:00:00'";
                    $where_kredit .= "and tgl_ambil <= '" . $tgl_akhir . " 23:59:59'";
                } else {
                    $where_kredit .= "tgl_ambil >= '" . $tgl_sebelum . " 00:00:00'";
                    $where_kredit .= "and tgl_ambil <= '" . $tgl_sebelum . " 23:59:59'";
                }

                $select_kredit .= $where_kredit;
            }
            if ($select_debet != '') {
                if ($where_debet != '') {
                    $where_debet = ' and ';
                } else {
                    $where_debet = ' and ';
                }
                if ($sebelumnya == '') {
                    $where_debet .= "created_at >= '" . $tgl_awal . " 00:00:00'";
                    $where_debet .= " and created_at <= '" . $tgl_akhir . " 23:59:59'";
                } else {
                    $where_debet .= "created_at >= '" . $tgl_sebelum . " 00:00:00'";
                    $where_debet .= " and created_at <= '" . $tgl_sebelum . " 23:59:59'";
                }

                $select_debet .= $where_debet;
            }

            $where_kas = '';
            $condition = ($where != '') ? 'and' : 'where';
            if ($sebelumnya == '') {
                $where_kas .= " $condition tgl_entry >= '" . $tgl_awal . " 00:00:00'";
                $where_kas .= " and tgl_entry <= '" . $tgl_akhir . " 23:59:59'";
            } else {
                $where_kas .= " $condition tgl_entry >= '" . $tgl_sebelum . " 00:00:00'";
                $where_kas .= " and tgl_entry <= '" . $tgl_sebelum . " 23:59:59'";
            }

            $select_kas .= $where_kas . ' and';
        } else {
            $select_kas .= ' and';
        }

        if (!empty($post['status'])) {
            if ($post['status'] == 'kredit') {
                $select_kredit = $select_kredit . $union_all;
            } else if ($post['status'] == 'debet') {
                $select_debet = $select_debet . $union_all;
            }
        } else {
            $select_debet = $select_debet . $union_all;
            $select_kredit = $select_kredit . $union_all;
        }

        $sql = "
            select * from(
                " . $select_debet . "
                " . $select_kredit . "
                " . $select_kas . "  description not like '%Biaya Admin Pinjaman Nomor Anggota%'
            )as trans_kas order by trans_kas.tgl_transaksi asc
        ";

        $query = $this->db->query($sql)->result();
        if ($query) {
            return $query;
        } else {
            return FALSE;
        }
    }

    function get_data_saldo()
    {
        $post = $this->input->post();
        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);

            $this->db->select('*');
            $this->db->where('tanggal <', $tgl_awal);
            $this->db->order_by('tanggal', 'DESC');
            $saldo = $this->db->get('t_saldo')->row();
            return $saldo;
        }
    }

    function get_data_transaksi()
    {
        $post = $this->input->post();

        $debet = "
            select
            'debet' as type,
            'setor' as description,
            pokok,wajib,sukarela,
            pokok + wajib + sukarela as amount,
            jumlah_angsuran as angsuran,
            jasa,
            b.id as nomor_anggota, b.nama_anggota,
            created_at as tgl_transaksi
            from t_simpan a
            left join t_anggota b on a.anggota_id = b.id
            left join t_angsuran c on c.simpan_id = a.id
            where show_report = '1'
        ";

        $kredit = "
            select 
            'kredit' as type,
            type as description,
            0 as pokok,0 as wajib,0 as sukarela,
            total_ambil as amount,
            0 as angsuran,
            0 as jasa,
            b.id as nomor_anggota, b.nama_anggota,
            tgl_ambil as tgl_transaksi
            from t_pengambilan a
            left join t_anggota b on a.anggota_id = b.id
            where type = 'pengambilan simpanan'
        ";

        if (!empty($post['tahun'])) {
            $debet .= "and YEAR(created_at ) = '" . $post['tahun'] . "'";
            $kredit .= "and YEAR(tgl_ambil ) = '" . $post['tahun'] . "'";
        };

        if (!empty($post['id_anggota'])) {
            $debet .= "and b.id = '" . $post['id_anggota'] . "'";
            $kredit .= "and b.id = '" . $post['id_anggota'] . "'";
        };

        $debet_akhir = $debet;
        $kredit_akhir = $kredit;

        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);

            $kredit .= "and tgl_ambil >= '" . $tgl_awal . " 00:00:00'";
            $kredit .= "and tgl_ambil <= '" . $tgl_akhir . " 23:59:59'";

            $debet .= "and created_at >= '" . $tgl_awal . " 00:00:00'";
            $debet .= " and created_at <= '" . $tgl_akhir . " 23:59:59'";
        }

        $sql = "select * from(
            " . $debet . "
            union all 
            " . $kredit . "
        ) as transaksi 
        order by transaksi.tgl_transaksi asc";

        $query = $this->db->query($sql)->result();
        $query_akhir = 0;
        $idAnggota = false;

        if (!empty($post['id_anggota'])) {
            if (!empty($post['periode'])) {
                $debet_akhir .= " and created_at <= '" . $tgl_awal . " 00:00:00'";
                $kredit_akhir .= "and tgl_ambil <= '" . $tgl_awal . " 00:00:00'";
                $sql = "select (sum(
                    CASE
                    WHEN transaksi.type = 'debet' THEN
                        amount
                    ELSE
                        0
                    END
                )-
                sum(
                    CASE
                    WHEN transaksi.type = 'kredit' THEN
                        amount
                    ELSE
                        0
                    END
                )) saldo
                 from(
                    " . $debet_akhir . "
                    union all 
                    " . $kredit_akhir . "
                    ) as transaksi 
                    order by transaksi.tgl_transaksi asc";
                $query_akhir = $this->db->query($sql)->row();
                $query_akhir = $query_akhir->saldo;
            } else {
                $query_akhir = 0;
            }
            $idAnggota = true;
        };

        if ($query) {
            return array(
                'transaksi' => $query,
                'saldo_akhir' => $query_akhir,
                'idAnggota' => $idAnggota
            );
        } else {
            return FALSE;
        }
    }
}
