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
<h2 style="text-align:center">Laporan Anggota</h2>
<?php if (empty($anggota)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <th width="130px">Nomor Anggota</th>
            <th>Nama Anggota</th>
            <th>Alamat Anggota</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
        </tr>
        <?php $i = 1;
        foreach ($anggota as $row) { ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $i; ?></td>
                <td style="border: 1px solid black;text-align:center"><?php echo $row->id; ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo ucfirst($row->alamat_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo tgl_indo($row->tgl_masuk); ?></td>
                <td style="border: 1px solid black"><?php echo $row->status; ?></td>
            </tr>
        <?php $i++;
        } ?>
    </table>
<?php } ?>