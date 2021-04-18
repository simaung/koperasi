<style>
    table {
        border-collapse: collapse;
    }

    /* table,
    td,
    th {
        border: 1px solid black;
    } */
</style>
<table align="center">
    <tr>
        <td>
            <img src="<?= base_url('assets'); ?>/img/logo_kop.gif" style="opacity: .8" width="80px">
        </td>
        <td width="20px"></td>
        <td style="text-align:center;padding:10px;line-height: 1.8;">
            <b><?php echo $nama_koperasi; ?></b>
            <br>
            <span style="font-size:10px;color:#696969"><?php echo $alamat_koperasi; ?></span>
        </td>
    </tr>
</table>
<hr>
<br>
<h6 style="text-align:right">Dicetak : <?php echo tgl_indo(date('Y-m-d H:i:s'), 'time'); ?></h6>
<h2 style="text-align:center">Laporan Simpanan</h2>
<?php if (empty($simpanan)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <th width="150px">Tanggal Transaksi</th>
            <th width="130px">Nomor Anggota</th>
            <th>Nama Anggota</th>
            <th>Pokok</th>
            <th>Wajib</th>
            <th>Sukarela</th>
            <th>Angsuran</th>
            <th>Jasa</th>
            <th>Jumlah Setor</th>
            <th>Sisa Pinjaman</th>
        </tr>
        <?php
        $pokok = 0;
        $wajib = 0;
        $sukarela = 0;
        $jumlah_angsuran = 0;
        $jasa = 0;
        $jumlah_setor = 0;
        $i = 1;
        foreach ($simpanan as $row) {
        ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $i; ?></td>
                <!-- <td style="border: 1px solid black"><?php echo tgl_indo($row->created_at, 'time'); ?></td> -->
                <td style="border: 1px solid black"><?php echo tgl_indo(substr($row->created_at, 0, 10)); ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo $row->anggota_id; ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->pokok); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->wajib); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->sukarela); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jumlah_angsuran); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jasa); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jumlah_setor); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->sisa_pinjaman); ?></td>
            </tr>
        <?php $i++;
            $pokok +=  $row->pokok;
            $wajib += $row->wajib;
            $sukarela += $row->sukarela;
            $jumlah_angsuran += $row->jumlah_angsuran;
            $jasa += $row->jasa;
            $jumlah_setor += $row->jumlah_setor;
        } ?>
        <tr>
            <th colspan="4">Total</th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($pokok); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($wajib); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($sukarela); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jumlah_angsuran); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jasa); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jumlah_setor); ?></th>
        </tr>
    </table>
<?php } ?>