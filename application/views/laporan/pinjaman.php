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
<h6 style="text-align:right">Dicetak : <?php echo tgl_indo(date('Y-m-d H:i:s'), 'time'); ?></h6>
<h2 style="text-align:center">Laporan Pinjaman</h2>
<?php if (empty($pinjaman)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <th width="180px">Tanggal Pengajuan</th>
            <th width="130px">Nomor Anggota</th>
            <th>Nama Anggota</th>
            <th>Besar Pinjaman</th>
            <th>Status Pengajuan</th>
            <th>Status Lunas</th>
            <th>Bunga</th>
            <th>Lama Angsuran</th>
        </tr>
        <?php
        $total_pinjam = 0;
        $i = 1;
        foreach ($pinjaman as $row) {
        ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $i; ?></td>
                <td style="border: 1px solid black"><?php echo tgl_indo($row->tgl_entry, 'time'); ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo $row->anggota_id; ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->total_pinjam); ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo strtoupper($row->status_pengajuan); ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo strtoupper($row->status); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo $row->bunga . '%'; ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo $row->lama_angsuran . ' bulan'; ?></td>
            </tr>
        <?php $i++;
            $total_pinjam +=  $row->total_pinjam;
        } ?>
        <tr>
            <th colspan="4">Total</th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($total_pinjam); ?></th>
        </tr>
    </table>
<?php } ?>