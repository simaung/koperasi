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
<table>
    <tr>
        <td rowspan="2">
            <img src="<?= base_url('assets'); ?>/img/logo_kop.gif" style="opacity: .8" width="80px">
        </td>
        <td width="20px"></td>
        <td><b><?php echo $nama_koperasi; ?></b></td>
    </tr>
    <tr>
        <td></td>
        <td><b><?php echo $alamat_koperasi; ?></b></td>
    </tr>
</table>
<hr>
<br>
<h6 style="text-align:right">Dicetak : <?php echo tgl_indo(date('Y-m-d')); ?></h6>
<h2 style="text-align:center">Laporan Simpanan</h2>
<?php if (empty($simpanan)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <!-- <th width="150px">Tanggal Transaksi</th> -->
            <th width="130px">Nomor Anggota</th>
            <th>Nama Anggota</th>
            <th>Pokok</th>
            <th>Wajib</th>
            <th>Sukarela</th>
            <th>Angsuran</th>
            <th>Jasa</th>
            <th>Jumlah Setor</th>
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
                <td style="border: 1px solid black;text-align:center"><?php echo $row->anggota_id; ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->pokok); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->wajib); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->sukarela); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jumlah_angsuran); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jasa); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jumlah_setor); ?></td>
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
            <th colspan="3">Total</th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($pokok); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($wajib); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($sukarela); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jumlah_angsuran); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jasa); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jumlah_setor); ?></th>
        </tr>
    </table>
<?php } ?>