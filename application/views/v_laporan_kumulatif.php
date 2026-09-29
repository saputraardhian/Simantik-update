<?php 
$uri3 = $this->uri->segment(3);
$uri4 = $this->uri->segment(4);
$uri5 = $this->uri->segment(5);
$uri6 = $this->uri->segment(6);

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

<script type="text/javascript">

function OnSelectionChange()
 {
	  var pilih_tgl_mulai_laporan  = document.getElementById('tgl_mulai_laporan');
	  var mulai = pilih_tgl_mulai_laporan.value;
	  var pilih_tgl_selesai_laporan  = document.getElementById('tgl_selesai_laporan');
	  var selesai = pilih_tgl_selesai_laporan.value;
	  var pilih_jenis_laporan  = document.getElementById('pilih_laporan');
	  var laporan = pilih_jenis_laporan.value;
	  var pilih_barang  = document.getElementById('barang');
	  var barang = pilih_barang.value;
	  
	  if(mulai == '' || selesai ==  '')
	  {
		 window.alert("Isikan range tanggal terlebih dahulu"); 
	  }
	  else
	  {
	  var base_url='<?php echo base_url();?>';
	  var loc = base_url+"adm/laporan_kumulatif/"+mulai+"/"+selesai+"/"+laporan +"/"+barang;
	  window.location.assign(loc); 
	  }
 }
 
</script>

 <?php 
	$options_laporan = array(
		'01'         => 'Persediaan Alat Tulis Kantor',
		'02'         => 'Persediaan Alat Rumah Tangga',
		);
?>


<div class="row">
  <div class="col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Rekap Permintaan Alat Tulis/Alat Rumah Tangga Kantor</div>
	
	
	<div class="panel-body">
        
        <!-- accordion -->
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <table>
		<tr>
			<td>Range Waktu Laporan	</td>
			<td>
			&nbsp;&nbsp;&nbsp;
			</td>
			<td>
				<input type="text" name="tgl_mulai_laporan" tabindex="5" id="tgl_mulai_laporan" style="width: 200px"  class="form-control" value="<?php echo $uri3; ?>">
			</td>
			<td>
			&nbsp;&nbsp;&nbsp;
			</td>
			<td>
				<input type="text" name="tgl_selesai_laporan" tabindex="5" id="tgl_selesai_laporan" style="width: 200px" class="form-control" value="<?php echo $uri4; ?>">
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td>
			Jenis Laporan
			</td>
			<td>
				&nbsp;&nbsp;&nbsp;
			</td>
			<td colspan="3">
			<?php
			echo form_dropdown("pilih_laporan", $options_laporan, $uri5, "id='pilih_laporan' class='form-control'")."";
			?>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td>
			Pilih Barang
			</td>
			<td>
				&nbsp;&nbsp;&nbsp;
			</td>
			<td>
			<select name="barang" id="barang"  class="form-control" tabindex="5" style="width: 200px">
						<option value="semua">- Semua Barang -</option>
                        <?php
						$query_barang = mysql_query("select * from m_barang");
						if($uri6 !='semua')
						{
							$kode_jenisbarang_terpilih = substr($uri6,0,10);
							$kode_subjenisbarang_terpilih = substr($uri6,11,6);
							$query_barang_terpilih =$this->db->query("select nama_barang from m_barang where kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->row();
							$nama_barang_terpilih = $query_barang_terpilih->nama_barang;
							$selected_value = $kode_jenisbarang_terpilih.'-'.$kode_subjenisbarang_terpilih ;
						}
						else
						{
							$selected_value = 'semua';
							$nama_barang_terpilih ='Semua Barang';
						}
		                while($p=mysql_fetch_array($query_barang)){
						if($p['kode_jenisbarang'] == $kode_jenisbarang_terpilih && $p['kode_subjenisbarang']== $kode_subjenisbarang_terpilih)
						{
							echo "<option selected value='".$selected_value."'>".$nama_barang_terpilih."</option>\n";
						}
						else
						{
							echo "<option value='".$p['kode_jenisbarang']."-".$p['kode_subjenisbarang']."'>".$p['nama_barang']."</option>\n";
						}
						}
                        ?>
            </select>  
			
			</td>
		</tr>
		<tr>
			<td colspan="5">
				&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="5">
			<button class="btn btn-primary btn-sm" tabindex="24" onclick="OnSelectionChange()" > Tampilkan Laporan</button>
			<button type="button" class="btn btn-danger btn-sm" onclick="return preview_url('<?php echo base_url();?>adm/cetaklaporankumulatif/<?php echo $uri3;?>/<?php echo $uri4;?>/<?php echo $uri5;?>/<?php echo $uri6;?>', 'Pratinjau Rekap Laporan Kumulatif');"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button>
			</td>
		</tr>
		
		</table>

		<br>
		
		<?php 
					if (empty($datarekapmasuk) && empty($datarekapkeluar)) {
						echo "<table><tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Laporan Kosong--</td></tr></table>";
					} else {
						echo 'Rekap Pemasukan dan Pengeluaran Barang ATK/ART mulai tanggal '.tgl_jam_sql($uri3).' sampai dengan '.tgl_jam_sql($uri4).'';
				
					?>
					<br>
					
					<div class="book">
					<div class="page">
						<div class="subpage">
												
							<div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 24px;">
							<table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 600px; max-width: none; white-space: nowrap;">
								<thead>
								<tr>
								<th style="width: 60px; min-width: 60px;" class="ctr">No.</th>
								<th style="width: 170px; min-width: 170px;">Kode Barang</th>
								<th style="min-width: 250px;">Nama Barang</th>
								<th style="width: 120px; min-width: 120px;" class="ctr">Masuk</th>
								</tr>
								</thead>
								<tbody>
							<?php
							$no=1;
							foreach ($datarekapmasuk as $b) {
							?>
								<tr>
								<td class="ctr"><?php echo $no;?></td>
								<td><?php echo $b->kode_jenisbarang.'-'.$b->kode_subjenisbarang;?></td>
								<td><?php echo $b->nama_barang;?></td>
								<td class="ctr" style="font-weight: 700; color: #16a34a;"><?php echo $b->jmlh_masuk;?></td>
								</tr>
								<?php
								$no++;
							}
							?>
								</tbody>
							</table>
							</div>
							
							<div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 10px;">
							<table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 600px; max-width: none; white-space: nowrap;">
								<thead>
								<tr>
								<th style="width: 60px; min-width: 60px;" class="ctr">No.</th>
								<th style="width: 170px; min-width: 170px;">Kode Barang</th>
								<th style="min-width: 250px;">Nama Barang</th>
								<th style="width: 120px; min-width: 120px;" class="ctr">Keluar</th>
								</tr>
								</thead>
								<tbody>
							<?php
							$no=1;
							foreach ($datarekapkeluar as $d) {
							?>
								<tr>
								<td class="ctr"><?php echo $no;?></td>
								<td><?php echo $d->kode_jenisbarang.'-'.$d->kode_subjenisbarang;?></td>
								<td><?php echo $d->nama_barang;?></td>
								<td class="ctr" style="font-weight: 700; color: #dc2626;"><?php echo $d->jmlh_keluar;?></td>
								</tr>
								<?php
								$no++;
							}
							?>
								</tbody>
							</table>
							</div>
						</div>
					</div>
					</div>
					
					<?php
					}

					?>
		 </div>
    </div>
	
	
	<br>
    </div>
  </div>
</div>
</div>
