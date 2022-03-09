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
<h2 style="text-align:center">Laporan Transaksi Anggota</h2>
<?php if (empty($transaksi)) { ?>
    <p>Data kosong...</p>
<?php } else { ?>
    <table border="1" align="center" width="100%" style="border: 1px solid black">
        <tr style="border: 1px solid black">
            <th>No</th>
            <th width="140px">Tanggal</th>
            <th>Nomor</th>
            <th>Nama</th>
            <th>Transaksi</th>
            <th colspan="5">Pemasukan</th>
            <th>Pengeluaran</th>
            <?php if ($transaksi['idAnggota'] == true) { ?>
                <th>Total Tabungan</th>
            <?php } ?>
        </tr>
        <tr>
            <th colspan="5"></th>
            <th>Pokok</th>
            <th>Wajib</th>
            <th>Sukarela</th>
            <th>Angsuran</th>
            <th>Jasa</th>
            <th colspan="4"></th>
        </tr>
        <?php if ($transaksi['idAnggota'] == true) { ?>
            <tr>
                <td colspan="11"><b>Saldo Awal</b></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($transaksi['saldo_akhir']); ?></td>
            </tr>
        <?php } ?>
        <?php
        $kredit = 0;
        $debet = 0;
        $angsuran = 0;
        $jasa = 0;
        $pokok = 0;
        $wajib = 0;
        $sukarela = 0;
        $i = 1;
        $total = $transaksi['saldo_akhir'];
        foreach ($transaksi['transaksi'] as $row) {
            if ($row->type == 'debet') {
                $total += $row->amount;
                $pokok += $row->pokok;
                $wajib += $row->wajib;
                $sukarela += $row->sukarela;
            } else {
                $total -= $row->amount;
            }
        ?>
            <tr>
                <td style="border: 1px solid black;text-align:center"><?php echo $i; ?></td>
                <td style="border: 1px solid black"><?php echo tgl_indo($row->tgl_transaksi); ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nomor_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->nama_anggota); ?></td>
                <td style="border: 1px solid black"><?php echo ucwords($row->description); ?></td>
                <!-- <td style="border: 1px solid black;text-align:right"><?php echo ($row->type == 'debet') ? rp($row->amount) : '0'; ?></td> -->
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->pokok) ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->wajib) ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->sukarela) ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->angsuran) ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo rp($row->jasa) ?></td>
                <td style="border: 1px solid black;text-align:right"><?php echo ($row->type == 'kredit') ? rp($row->amount) : '0'; ?></td>
                <?php if ($transaksi['idAnggota'] == true) { ?>
                    <td style="border: 1px solid black;text-align:right"><?php echo rp($total) ?></td>
                <?php } ?>
            </tr>
        <?php $i++;
            if ($row->type == 'kredit') {
                $kredit += $row->amount;
            } elseif ($row->type == 'debet') {
                $debet += $row->amount;
            }
            $angsuran += $row->angsuran;
            $jasa += $row->jasa;
        } ?>
        <tr style="font-size:20px">
            <th colspan="5">Total</th>
            <!-- <th style="border: 1px solid black;text-align:right"><?php echo rp($debet); ?></th> -->
            <th style="border: 1px solid black;text-align:right"><?php echo rp($pokok); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($wajib); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($sukarela); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($angsuran); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($jasa); ?></th>
            <th style="border: 1px solid black;text-align:right"><?php echo rp($kredit); ?></th>
            <?php if ($transaksi['idAnggota'] == true) { ?>
                <th style="border: 1px solid black;text-align:right"><?php echo rp($total); ?></th>
            <?php } ?>
        </tr>
    </table>
<?php } ?>