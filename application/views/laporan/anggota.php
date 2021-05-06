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
<h2 style="text-align:center">Laporan Anggota</h2>
<?php if (empty($anggota)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th width="130px">Nomor Anggota</th>
            <th width="130px">Nama Anggota</th>
            <th>Alamat Anggota</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
        <?php
        foreach ($anggota as $row) { ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $row->id; ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo ucfirst($row->alamat_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo tgl_indo($row->tgl_masuk); ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo strtoupper($row->status); ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>