<?php 
$uri3 = $this->uri->segment(3);
$uri4 = $this->uri->segment(4);
$uri5 = $this->uri->segment(5);
$uri6 = $this->uri->segment(6);
?>

<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>

<style>
body {
  margin: 0;
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
  margin: 0;
}

@media print {
  body, page[size="A4"] {
    margin: 0;
    box-shadow: 0;
  }
}


</style>


<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
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


?>

<link href='<?php echo base_url(); ?>___/css/style_print.css' rel='stylesheet' media='' type='text/css'/>
<div class="row col-md-12">
  <div class="panel panel-info">
 
	<div class="panel-body">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		
		<?php 
					if (empty($datarekapmasuk) && empty($datarekapkeluar)) {
						echo "<table><tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Laporan Kosong--</td></tr></table>";
					} else {
					?>	
						<div class="page">
							<?php echo 'Rekap Pemasukan dan Pengeluaran Barang ATK/ART mulai tanggal '.tgl_jam_sql($uri3).' sampai dengan '.tgl_jam_sql($uri4).'';
							?>
							<br>
							<table class="table table-bordered table-hover">
								<tr>
								<th align="center" width="5%">No.</th>
								<th align="center" width="10%">Kode_Barang</th>
								<th align="center" width="30%">Nama Barang</th>
								<th align="center" width="10%">Masuk</th>
								
								</tr>
							<?php
							$no=1;
							foreach ($datarekapmasuk as $b) {
							?>
								<tr>
								<td  align="center"><?php echo $no;?></td>
								<td  align="left"><?php echo $b->kode_jenisbarang.'-'.$b->kode_subjenisbarang;?></td>
								<td  align="left"><?php echo $b->nama_barang;?></td>
								<td  align="left"><?php echo $b->jmlh_masuk;?></td>
							
								</tr>
								<?php
								$no++;
							}
							?>
							</table>
							
							<table class="table table-bordered table-hover">
								<tr>
								<th align="center" width="5%">No.</th>
								<th align="center" width="10%">Kode_Barang</th>
								<th align="center" width="30%">Nama Barang</th>
								<th align="center" width="10%">Keluar</th>
								</tr>
							<?php
							$no=1;
							foreach ($datarekapkeluar as $b) {
							?>
								<tr>
								<td  align="center"><?php echo $no;?></td>
								<td  align="left"><?php echo $b->kode_jenisbarang.'-'.$b->kode_subjenisbarang;?></td>
								<td  align="left"><?php echo $b->nama_barang;?></td>
								<td  align="right"><?php echo $b->jmlh_keluar;?></td>
								</tr>
								<?php
								$no++;
							}
							?>
							</table>
						</div>
					<?php
					}
					?>
		 </div>
    </div>

    </div>
  </div>
