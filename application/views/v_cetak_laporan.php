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
					if (empty($datalistatk)) {
						echo "<table><tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Laporan Kosong--</td></tr></table>";
					} else {
						$no=1;
					foreach($datalistatk as $atk)
					{
					$kode_jenisbarang = $atk->kode_jenisbarang;
					$kode_subjenisbarang = $atk->kode_subjenisbarang;
					if($uri6 == 'semua')
					{
					$datalaporan=$this->db->query("select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> ''
							union all
							select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where t.kode_jenisbarang='$kode_jenisbarang' and t.kode_subjenisbarang='$kode_subjenisbarang' and substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' 
							order by nama_barang, tgl asc")->result();	
					}
					else
					{
					$kode_jenisbarang_terpilih = substr($uri6,0,10);
					$kode_subjenisbarang_terpilih = substr($uri6,11,6);
					$datalaporan=$this->db->query("select t.tgl_diserahkan as tgl, p.nama as uraian, '' as harga, b.nama_barang as nama_barang,t.jumlah_permintaan as jumlah, s.nilai_stok as stok, 1 as flag  from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip left join t_stok_permintaan s on t.id_permintaan= s.id_permintaan and t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diserahkan,1,10) >= '$uri3' and substring(t.tgl_diserahkan,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih' and t.nip_pegawai_menyerahkan <> ''
							union all
							select t.tgl_diterima as tgl, sumber_penerimaan as uraian, nilai_penerimaan as harga, b.nama_barang as nama_barang, jumlah_penerimaan as jumlah, s.nilai_stok as stok, 2 as  flag from t_penerimaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang left join t_stok_penerimaan s on t.id_penerimaan=s.id_penerimaan AND t.kode_jenisbarang=s.kode_jenisbarang AND t.kode_subjenisbarang=s.kode_subjenisbarang where substring(t.tgl_diterima,1,10) >= '$uri3' and substring(t.tgl_diterima,1,10) <= '$uri4' and t.kode_jenisbarang='$kode_jenisbarang_terpilih' and t.kode_subjenisbarang='$kode_subjenisbarang_terpilih'
							order by nama_barang, tgl asc")->result();
					}
					?>
					<div class="book">
					<div class="page">
							<p><?php echo 'Nama Barang : '. $atk->nama_barang;?></p>
							
							<table class="table table-bordered table-hover">
								<tr>
								<th width="5%">No.</th>
								<th width="10%">Tanggal</th>
								<th width="30%">Uraian Pengeluaran/Penerimaan</th>
								<th width="15%">Harga</th>
								<th width="10%">Masuk</th>
								<th width="10%">Keluar</th>
								<th width="10%">Stok Barang</th>
								</tr>
							<?php
							foreach ($datalaporan as $b) {
							?>
								<tr>
								<td  align="center"><?php echo $no;?></td>
								<td  align="left"><?php echo tgl_jam_sql ($b->tgl);?></td>
								<td  align="left"><?php echo $b->uraian;?></td>
								<td  align="right"><?php echo $b->harga;?></td>
								<?php
								if ($b->flag == '2')
								{?>
									<td  align="center"><?php echo $b->jumlah;?></td>							
								<?php
								}
								else
								{?>
								<td  align="center">&nbsp;</td>
								<?php
								}
								if ($b->flag == '1')
								{?>
									<td  align="center"><?php echo $b->jumlah;?></td>							
								<?php
								}
								else
								{?>
								<td  align="center">&nbsp;</td>
								<?php
								}
								?>
								<td  align="center"><?php echo $b->stok;?></td>
								<?php
								$no++;
							}
							?>
							</table>
						
					</div>
					</div>
					
					<?php
					}
					}
					?>
		 </div>
    </div>

    </div>
  </div>
