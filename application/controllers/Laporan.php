<?php

defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Laporan extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('petugas_model');

        $this->check_logged();
        $this->authData = $this->session->userdata('auth_data');
    }

    function index()
    {
        $data['menu'] = 'laporan';
        $data['js'] = '/assets/js/page/laporan.js';
        $content = $this->load->view('laporan', $data, TRUE);
        $this->template->load(array(), $content);
    }

    function anggota()
    {
        $this->load->model('anggota_model');
        $post = $this->input->post();
        $where = array();

        if (!empty($post['status'])) {
            $where['status'] = $post['status'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(tgl_masuk)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(tgl_masuk)'] = $post['tahun'];
        }

        $data_anggota = $this->anggota_model->get_data_anggota(null, $where);

        if ($this->input->post("cetak") == "cetakPdf") {
            $this->cetakPdf($data_anggota, 'anggota');
        } elseif ($this->input->post("cetak") == "cetakExcel") {
            $this->cetakExcel($data_anggota, 'anggota');
        }
    }

    function transaksi()
    {
        $this->load->model('simpanan_model');

        $data_transaksi = $this->simpanan_model->get_data_transaksi();

        if ($this->input->post("cetak") == "cetakPdf") {
            $this->cetakPdf($data_transaksi, 'transaksi');
        } elseif ($this->input->post("cetak") == "cetakExcel") {
            $this->cetakExcel($data_transaksi, 'transaksi');
        }
    }

    function simpanan()
    {
        $this->load->model('simpanan_model');
        $post = $this->input->post();

        $where = array();

        if (!empty($post['id_anggota'])) {
            $where['a.anggota_id'] = $post['id_anggota'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(created_at)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(created_at)'] = $post['tahun'];
        }
        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);

            $where['created_at >= '] = $tgl_awal . ' 00:00:00';
            $where['created_at <= '] = $tgl_akhir . ' 23:59:59';
        }

        $data_simpanan = $this->simpanan_model->get_data_simpanan($where);

        if ($this->input->post("cetak") == "cetakPdf") {
            $this->cetakPdf($data_simpanan, 'simpanan');
        } elseif ($this->input->post("cetak") == "cetakExcel") {
            $this->cetakExcel($data_simpanan, 'simpanan');
        }
    }

    function pinjaman()
    {
        $this->load->model('pinjaman_model');
        $post = $this->input->post();
        $where = array();

        if (!empty($post['status'])) {
            $where['a.status'] = $post['status'];
        }
        if (!empty($post['status_pengajuan'])) {
            $where['a.status_pengajuan'] = $post['status_pengajuan'];
        }
        if (!empty($post['id_anggota'])) {
            $where['a.anggota_id'] = $post['id_anggota'];
        }
        if (!empty($post['bulan'])) {
            $where['MONTH(tgl_entry)'] = $post['bulan'];
        }
        if (!empty($post['tahun'])) {
            $where['YEAR(tgl_entry)'] = $post['tahun'];
        }
        if (!empty($post['periode'])) {
            $periode = explode(' - ', $post['periode']);
            $tgl_awal = tgl_db($periode[0]);
            $tgl_akhir = tgl_db($periode[1]);

            $where['tgl_entry >= '] = $tgl_awal . ' 00:00:00';
            $where['tgl_entry <= '] = $tgl_akhir . ' 23:59:59';
        }

        $data_pinjaman = $this->pinjaman_model->get_data_pinjaman($where);

        $nama_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['pinjaman'] = $data_pinjaman;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $html = $this->load->view('laporan/pinjaman', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function kas()
    {
        $post = $this->input->post();
        if (!$post['periode']) {
            echo 'Tanggal tidak boleh kosong';
            die;
        }
        
        $this->load->model('pinjaman_model');

        $data_kas_sebelum = $this->pinjaman_model->get_data_saldo();
        $data_kas = $this->pinjaman_model->get_data_kas();

        $nama_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->pinjaman_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $periode = explode(' - ', $post['periode']);
        $tgl_akhir = tgl_db($periode[1]);

        $data['nama_koperasi']      = $nama_koperasi;
        $data['alamat_koperasi']    = $alamat_koperasi;
        $data['kas'] = $data_kas;
        $data['kas_sebelumnya'] = $data_kas_sebelum->saldo;
        $data['tgl_akhir']  = $tgl_akhir;

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $html = $this->load->view('laporan/kas', $data, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    private function cetakPdf($data, $type)
    {
        $this->load->model('anggota_model');

        $nama_koperasi = $this->anggota_model->get_data('t_setting', array('name' => 'koperasi'), true);
        $alamat_koperasi = $this->anggota_model->get_data('t_setting', array('name' => 'alamat'), true);
        $nama_koperasi    = $nama_koperasi[0]->value;
        $alamat_koperasi  = $alamat_koperasi[0]->value;

        $dataPdf['nama_koperasi']      = $nama_koperasi;
        $dataPdf['alamat_koperasi']    = $alamat_koperasi;
        $dataPdf[$type] = $data;

        $mpdf = new \Mpdf\Mpdf();
        $html = $this->load->view('laporan/' . $type, $dataPdf, true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    private function cetakExcel($data, $type)
    {
        $spreadsheet = new Spreadsheet;

        if ($type == 'anggota') {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Nomor')
                ->setCellValue('B1', 'Nama')
                ->setCellValue('C1', 'Alamat')
                ->setCellValue('D1', 'Status')
                ->setCellValue('E1', 'Pokok')
                ->setCellValue('F1', 'Wajib')
                ->setCellValue('G1', 'Sukarela')
                ->setCellValue('H1', 'Total Tabungan')
                ->setCellValue('I1', 'Jasa')
                ->setCellValue('J1', 'Sisa Pinjaman');
            $kolom = 2;
            foreach ($data as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $kolom, $row->id)
                    ->setCellValue('B' . $kolom, $row->nama_anggota)
                    ->setCellValue('C' . $kolom, $row->alamat_anggota)
                    ->setCellValue('D' . $kolom, $row->status)
                    ->setCellValue('E' . $kolom, $row->pokok)
                    ->setCellValue('F' . $kolom, $row->wajib)
                    ->setCellValue('G' . $kolom, $row->sukarela)
                    ->setCellValue('H' . $kolom, $row->total_tabungan)
                    ->setCellValue('I' . $kolom, $row->jasa)
                    ->setCellValue('J' . $kolom, $row->total_pinjam - $row->jumlah_angsuran);
                $kolom++;
            }
        } elseif ($type == 'simpanan') {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nomor')
                ->setCellValue('C1', 'Nama')
                ->setCellValue('D1', 'Pokok')
                ->setCellValue('E1', 'Wajib')
                ->setCellValue('F1', 'Sukarela')
                ->setCellValue('G1', 'Angsuran')
                ->setCellValue('H1', 'Jasa')
                ->setCellValue('I1', 'Setor')
                ->setCellValue('J1', 'Sisa Pinjaman');
            $kolom = 2;
            foreach ($data as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $kolom, $row->created_at)
                    ->setCellValue('B' . $kolom, $row->anggota_id)
                    ->setCellValue('C' . $kolom, $row->nama_anggota)
                    ->setCellValue('D' . $kolom, $row->pokok)
                    ->setCellValue('E' . $kolom, $row->wajib)
                    ->setCellValue('F' . $kolom, $row->sukarela)
                    ->setCellValue('G' . $kolom, $row->jumlah_angsuran)
                    ->setCellValue('H' . $kolom, $row->jasa)
                    ->setCellValue('I' . $kolom, $row->jumlah_setor)
                    ->setCellValue('J' . $kolom, $row->sisa_pinjaman);
                $kolom++;
            }
        } elseif ($type == 'transaksi') {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nomor')
                ->setCellValue('C1', 'Nama')
                ->setCellValue('D1', 'Transaksi')
                ->setCellValue('E1', 'Pemasukan')
                ->setCellValue('F1', 'Pengeluaran');

            if ($data['idAnggota'] == true) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('G1', 'Angsuran')
                    ->setCellValue('H1', 'Jasa')
                    ->setCellValue('I1', 'Total Tabungan');
            }

            if ($data['idAnggota'] == true) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A2', 'Total')
                    ->setCellValue('I2', $data['saldo_akhir']);
            }

            $kolom = 2;
            $total = 0;
            if ($data['idAnggota'] == true) {
                $kolom = 3;
                $total = $data['saldo_akhir'];
            }

            foreach ($data['transaksi'] as $row) {
                if ($row->type == 'debet') {
                    $total += $row->amount;
                } else {
                    $total -= $row->amount;
                }
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $kolom, $row->tgl_transaksi)
                    ->setCellValue('B' . $kolom, $row->nomor_anggota)
                    ->setCellValue('C' . $kolom, $row->nama_anggota)
                    ->setCellValue('D' . $kolom, $row->description)
                    ->setCellValue('E' . $kolom, ($row->type == 'debet') ? $row->amount : '0')
                    ->setCellValue('F' . $kolom, ($row->type == 'kredit') ? $row->amount : '0');

                if ($data['idAnggota'] == true) {
                    $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('G' . $kolom, $row->angsuran)
                        ->setCellValue('H' . $kolom, $row->jasa)
                        ->setCellValue('I' . $kolom, $total);
                }
                $kolom++;
            }
        }

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $type . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
