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
<h2 style="text-align:center">Laporan Kas Keuangan</h2>
<?php if (empty($kas)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <th width="200px">Tanggal Transaksi</th>
            <th>Transaksi</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
        </tr>
        <?php
        $kredit = 0;
        $debet = 0;
        $i = 1;
        foreach ($kas as $row) {
        ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $i; ?></td>
                <td style="border: 1px solid black"><?php echo tgl_indo($row->tgl_transaksi, 'time'); ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->description); ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo ($row->type == 'debet') ? rp($row->amount) : '-'; ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo ($row->type == 'kredit') ? rp($row->amount) : '-'; ?></td>
            </tr>
        <?php $i++;
            if ($row->type == 'kredit') {
                $kredit += $row->amount;
            } elseif ($row->type == 'debet') {
                $debet += $row->amount;
            }
        } ?>
        <tr style="font-size:20px">
            <th colspan="3">Total</th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($debet); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($kredit); ?></th>
        </tr>

        <?php
        $kredit_sebelum = 0;
        $debet_sebelum = 0;
        foreach ($kas_sebelumnya as $row_sebelum) {
            if ($row_sebelum->type == 'kredit') {
                $kredit_sebelum += $row_sebelum->amount;
            } elseif ($row_sebelum->type == 'debet') {
                $debet_sebelum += $row_sebelum->amount;
            }
        }
        ?>

    </table>
    <br>
    <br>
    <table style="border: 1px solid black">
        <tr>
            <td>Saldo Sebelumnya</td>
            <td>:</td>
            <td style="text-align:right"><?php echo rp($debet_sebelum - $kredit_sebelum); ?></td>
        </tr>
        <tr>
            <td>Saldo transaksi <?php echo tgl_indo($tgl_akhir); ?></td>
            <td>:</td>
            <td style="text-align:right"><?php echo rp($debet - $kredit); ?></td>
        </tr>
        <tr>
            <td>Total Saldo per <?php echo tgl_indo($tgl_akhir); ?></td>
            <td>:</td>
            <td style="text-align:right"><?php echo rp(($debet_sebelum - $kredit_sebelum) + ($debet - $kredit)); ?></td>
        </tr>
    </table>
<?php } ?>