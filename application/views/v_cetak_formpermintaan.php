<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
<style>
body {
  margin: 10mm 10mm 10mm 10mm;
  padding: 0;
  background-color: #FAFAFA;
  font: 12pt "Tahoma";
}

* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.page {
  width: 21cm;
  min-height: 29.7cm;
  padding: 2cm;
  margin: 1cm auto;
  border: 1px #D3D3D3 solid;
  border-radius: 5px;
  background: white;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

@page {
  size: A4 portrait;
  margin: 10mm 10mm 10mm 10mm; 
}

@media print {
  body, page[size="A4"] {
    margin: 0;
    box-shadow: 0;
  }
}


</style>

<?php
function tgl_jam_sql ($tgl) {
	$pc_satu	= explode(" ", $tgl);
	if (count($pc_satu) < 2) {	
		$tgl1		= $pc_satu[0];
		$jam1		= "";
	} else {
		$jam1		= $pc_satu[1];
		$tgl1		= $pc_satu[0];
	}
	
	$pc_dua		= explode("-", $tgl1);
	$tgl		= $pc_dua[2];
	$bln		= $pc_dua[1];
	$thn		= $pc_dua[0];
	
	
	if ($bln == "01") { $bln_txt = "Jan"; }  
	else if ($bln == "02") { $bln_txt = "Feb"; }  
	else if ($bln == "03") { $bln_txt = "Mar"; }  
	else if ($bln == "04") { $bln_txt = "Apr"; }  
	else if ($bln == "05") { $bln_txt = "Mei"; }  
	else if ($bln == "06") { $bln_txt = "Jun"; }  
	else if ($bln == "07") { $bln_txt = "Jul"; }  
	else if ($bln == "08") { $bln_txt = "Ags"; }  
	else if ($bln == "09") { $bln_txt = "Sep"; }  
	else if ($bln == "10") { $bln_txt = "Okt"; }  
	else if ($bln == "11") { $bln_txt = "Nov"; }  
	else if ($bln == "12") { $bln_txt = "Des"; }  	
	else { $bln_txt = ""; }
	
	return $tgl." ".$bln_txt." ".$thn."  ".$jam1;
}

$today=date("Y-m-d");
$tanggal=tgl_jam_sql($today);
$nip_pengajuan = $datayangmengajukan->nip_pegawai;
$querynama = mysql_query("select * from m_pegawai where nip='$nip_pengajuan'");
$data = mysql_fetch_array($querynama);
$nama_pegawai=$data['nama'];
$unitkerja=$data['id_unitkerja']; 
//$unitkerjakabid = substr($unitkerja,0,4).'0';
$querynamakabid = mysql_query("select * from m_pegawai where id_unitkerja='$unitkerja' and id_eselon='4'");
$datakabid=mysql_fetch_array($querynamakabid);
$namakabid=$datakabid['nama'];
$nipkabid=$datakabid['nip'];
?>

<link href='<?php echo base_url(); ?>___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>
<table>
<tr>
	<td rowspan="3" width="15%">
	<img width = "75px" height = "65px" src="<?php echo base_URL()?>/upload/logo.png">
	</td>
	<td style="align:left">
	BADAN PUSAT STATISTIK
	</td>
</tr>
<tr>
	<td>
	PROVINSI JAWA TENGAH
	</td>
</tr>
<tr>
	<td>
	Jln. Pahlawan No. 6 Semarang
	</td>
</tr>
<tr colspan="2">
</tr>

</table>
<br>
<h4 ALIGN="CENTER">PERMINTAAN BARANG PERSEDIAAN</h4><BR>

<table class="table-bordered" style="width:1100px">
  <thead>
    <tr>
      <th width="5%">No</th>
	  <th width="10%">Kode Permintaan</th>
	  <th width="25%">Kode Barang</th>
	  <th width="40%">Nama Barang</th>
	  <th width="10%">Satuan</th>
      <th width="10%">Banyaknya</th>
	  
    </tr>
  </thead>

  <tbody>
	<tr style="align:center">
		<td class="ctr">(1)</td>
		<td class="ctr">(2)</td>
		<td class="ctr">(3)</td>
		<td class="ctr">(4)</td>
		<td class="ctr">(5)</td>
		<td class="ctr">(6)</td>
	</tr>
    <?php 
      if (!empty($permintaan_barang)) {
        $no = 1;
        foreach ($permintaan_barang as $d) {
          echo '<tr>
                <td class="ctr">'.$no.'</td>
				<td class="ctr">'.$d->id_permintaan.'</td>
				<td class="ctr">'.$d->kode_jenisbarang.'-'.$d->kode_subjenisbarang.'</td>
				<td>'.$d->nama_barang.'</td>
				<td>'.$d->satuan.'</td>
                <td class="ctr">'.$d->jumlah_permintaan.'</td>
				
                </tr>
                ';
        $no++;
        }
      } else {
        echo '<tr><td colspan="5">Belum ada data</td></tr>';
      }
    ?>
  </tbody>
</table>

<table style="width:1100px">
<tr>
	<td>&nbsp;</td>
	<td class="ctr">Semarang,<?php echo tgl_jam_sql($qtgl_permintaan->tgl_permintaan);?>	</td>
</tr>
<tr>
	<td class="ctr"> Mengetahui</td>
	<td class="ctr"> Yang Mengajukan</td>
</tr>
<tr>
	<td class="ctr">Kabag/Kabid/Kasubbag/Kasi,</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">(..........................................)</td>
	<td class="ctr"><?php echo $nama_pegawai;?></td>
</tr>
<tr>
	<td class="ctr" colspan="2">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">Yang Menyerahkan,</td>
	<td class="ctr">Yang Menerima,</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>
<tr>
	<td class="ctr">&nbsp;</td>
	<td class="ctr">&nbsp;</td>
</tr>

<tr>
	<td class="ctr">(..........................................)</td>
	<td class="ctr">(..........................................)</td>
</tr>


</table>