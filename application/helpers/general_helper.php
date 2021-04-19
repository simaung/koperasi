<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author RegiJG
 *
 */

if (!function_exists('rpToInt')) {
    function rpToInt($harga)
    {
        $harga_str = preg_replace("/[^0-9]/", "", $harga);
        $harga = (int) $harga_str;
        return $harga;
    }
}

if (!function_exists('removeChar')) {
    function removeChar($string)
    {
        $remove_char = preg_replace("/[^A-Za-z0-9?![:space:]]/", "", $string);
        return $remove_char;
    }
}

function rp($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}

if (!function_exists('akumulasi_jasa')) {
    function akumulasi_jasa($data_anggota)
    {
        $CI = get_instance();
        $CI->load->model('simpanan_model');

        $get_angsuran = $CI->simpanan_model->get_data('t_angsuran', array('pinjam_id' => $data_anggota->pinjam_id, 'MONTH(tgl_entry)' => date('m'), 'status' => 'aktif'), true);
  
        if ($get_angsuran) {
            $jasa = 0;
        } else {
            $last_angsuran = $CI->simpanan_model->get_data('t_angsuran', array('pinjam_id' => $data_anggota->pinjam_id, 'status' => 'aktif'), true);
            if ($last_angsuran) {
                $date = date("Y-m-d");
                $timeStart = strtotime($last_angsuran->created_at);
                $timeEnd = strtotime("$date");
                $numBulan = (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
                $numBulan += date("m", $timeEnd) - date("m", $timeStart);

                $jasa = ($data_anggota->total_pinjam * $data_anggota->bunga / 100) * $numBulan;
            } else {
                $get_pinjam = $CI->simpanan_model->get_data('t_pinjam', array('status' => 'belum'), false);
                if ($get_pinjam) {
                    $date = date("Y-m-d");
                    $timeStart = strtotime($get_pinjam->tgl_persetujuan);
                    $timeEnd = strtotime("$date");
                    $numBulan = (date("Y", $timeEnd) - date("Y", $timeStart)) * 12;
                    $numBulan += date("m", $timeEnd) - date("m", $timeStart);

                    $jasa = ($data_anggota->total_pinjam * $data_anggota->bunga / 100) * $numBulan;
                } else {
                    $jasa = 0;
                }
            }
        }
        return $jasa;
    }
}
