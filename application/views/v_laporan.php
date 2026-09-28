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
	  var loc = base_url+"adm/laporan/"+mulai+"/"+selesai+"/"+laporan +"/"+barang;
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


<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Laporan Permintaan Alat Tulis/Alat Rumah Tangga Kantor
     <!-- <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_siswa_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
      </div>-->
    </div>
	
	
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
						if($p[kode_jenisbarang] == $kode_jenisbarang_terpilih && $p[kode_subjenisbarang]== $kode_subjenisbarang_terpilih)
						{
							echo "<option selected value='".$selected_value."'>".$nama_barang_terpilih."</option>\n";
						}
						else
						{
							echo "<option value='".$p[kode_jenisbarang]."-".$p[kode_subjenisbarang]."'>".$p[nama_barang]."</option>\n";
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
			<button type="button" class="btn btn-danger btn-sm" onclick="return preview_url('<?php echo base_url();?>adm/cetaklaporan/<?php echo $uri3;?>/<?php echo $uri4;?>/<?php echo $uri5;?>/<?php echo $uri6;?>', 'Pratinjau Laporan Penerimaan/Pengeluaran');"><i class="glyphicon glyphicon-print"></i> Cetak Laporan</button>
			</td>
		</tr>
		
		</table>

		<br>
		
		<?php 
					if (empty($datalistatk)) {
						echo "<table><tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Laporan Kosong--</td></tr></table>";
					} else {
						
					foreach($datalistatk as $atk)
					{
					
					if($uri6 == 'semua')
					{
						$kode_jenisbarang = $atk->kode_jenisbarang;
						$kode_subjenisbarang = $atk->kode_subjenisbarang;
						$total_row		= $this->db->query("select * from t_permintaan_barang where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'")->num_rows();
						if($total_row > 0)
						{
						$datalaporan=$this->db->query("select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> ''
								union all
								select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' 
								order by nama_barang, tgl asc")->result();		
						}
						else
						{
						$datalaporan=$this->db->query("SELECT '2019-06-10' as tgl, 'Stok Awal' as uraian, '' as harga, b.nama_barang as nama_barang, '' as jumlah, a.stok_awal as stok, 0 as flag FROM `m_stokawal`a left join m_barang b on a.kode_jenisbarang=b.kode_jenisbarang and a.kode_subjenisbarang=b.kode_subjenisbarang where a.kode_jenisbarang='$kode_jenisbarang' and a.kode_subjenisbarang='$kode_subjenisbarang'
								union all			
								select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> ''
								union all
								select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' 
								order by nama_barang, tgl asc")->result();	
						}	
					}
					else
					{
					$kode_jenisbarang_terpilih = substr($uri6,0,10);
					$kode_subjenisbarang_terpilih = substr($uri6,11,6);
					$total_row		= $this->db->query("select * from t_permintaan_barang where kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->num_rows();	
						if($total_row == 0)
						{
						$datalaporan=$this->db->query("SELECT '2019-06-10' as tgl, 'Stok Awal' as uraian, '' as harga, b.nama_barang as nama_barang, '' as jumlah, a.stok_awal as stok, 0 as flag FROM `m_stokawal`a left join m_barang b on a.kode_jenisbarang=b.kode_jenisbarang and a.kode_subjenisbarang=b.kode_subjenisbarang where a.kode_jenisbarang='$kode_jenisbarang_terpilih' and a.kode_subjenisbarang='$kode_subjenisbarang_terpilih'
							union all
							select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih' and t.nip_pegawai_menyerahkan <> ''
							union all
							select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih'
							order by nama_barang, tgl asc")->result();	

						}
						else
						{
													
						$datalaporan=$this->db->query("select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih' and t.nip_pegawai_menyerahkan <> ''
							union all
							select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih'
							order by nama_barang, tgl asc")->result();
						}
					}
					?>
					<div class="book">
					<div class="page">
						<div class="subpage">
						<p><?php echo 'Nama Barang : '. $atk->nama_barang;?></p>
						
							<div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 10px;">
							<table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 680px; max-width: none; white-space: nowrap;">
								<thead>
								<tr>
								<th style="width: 50px; min-width: 50px;" class="ctr">No.</th>
								<th style="width: 120px; min-width: 120px;" class="ctr">Tanggal</th>
								<th style="min-width: 250px;">Uraian Pengeluaran/Penerimaan</th>
								<th style="width: 130px; min-width: 130px;" class="ctr">Harga</th>
								<th style="width: 90px; min-width: 90px;" class="ctr">Masuk</th>
								<th style="width: 90px; min-width: 90px;" class="ctr">Keluar</th>
								<th style="width: 110px; min-width: 110px;" class="ctr">Stok Barang</th>
								</tr>
								</thead>
								<tbody>
							<?php
							$no=1;
							foreach ($datalaporan as $b) {
							?>
								<tr>
								<td class="ctr"><?php echo $no;?></td>
								<td class="ctr"><?php echo tgl_jam_sql (substr($b->tgl,0,10));?></td>
								<td><?php echo $b->uraian;?></td>
								<td style="text-align: right;"><?php echo $b->harga;?></td>
								<?php
								if ($b->flag == '2')
								{?>
									<td class="ctr" style="font-weight: 700; color: #16a34a;"><?php echo $b->jumlah;?></td>							
								<?php
								}
								else
								{?>
								<td class="ctr">-</td>
								<?php
								}
								if ($b->flag == '1')
								{?>
									<td class="ctr" style="font-weight: 700; color: #dc2626;"><?php echo $b->jumlah;?></td>							
								<?php
								}
								else
								{?>
								<td class="ctr">-</td>
								<?php
								}
								?>
								<td class="ctr" style="font-weight: 700; color: #0284c7;"><?php echo $b->stok;?></td>
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
					}
					?>
		 </div>
    </div>
	
	
	<br>
    </div>
  </div>

                   
