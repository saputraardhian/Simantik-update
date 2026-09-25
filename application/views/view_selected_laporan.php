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



<div class="container">
	<div class="row">
    <div class="col-sm-10 blog-main">

<?php
if ($this->input->post('bulan') != null)
{
	$bulan = $this->input->post('bulan');
	$unitkerja=$this->input->post('unitkerja');
	$nippegawai=$this->session->userdata('admin_nip');
	
//	untuk staf
	
	$data   = $this->db->query("SELECT t.*,b.nama_barang, p.nama FROM t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang left join m_pegawai p on t.nip_pegawai=p.nip where substring(t.tgl_permintaan,6,2)='$bulan' order by kode_jenisbarang asc, kode_subjenisbarang asc, tgl_permintaan desc")->result();
	
	?>
	<table class="table table-bordered">
	<thead>
		<tr>
						<th width="5%"> No</th>
						<th width="20%">Nama Barang</th>
						<th width="15%">Tanggal</th>
						<th width="35%">Nama Pegawai</th>
						<th width="15%">Jumlah Barang</th>
    	</tr>
	</thead>
	
	<tbody>
	<?php 
		if (empty($data)) {
			echo "<tr><td colspan='5'  style='text-align: center; font-weight: bold'>--Tidak Ada Data Keluar Kantor--</td></tr>";
		} else {
			$no=1;
		foreach ($data as $b) {
		?>
		<tr>
		<td  align="center"><?php echo $no;?></td>
		<td  align="left"><?php echo $b->nama_barang;?></a></td>
		<td  align="center"><?php echo tgl_jam_sql($b->tgl_permintaan);?></a></td>
		<td  align="left"><?php echo $b->nama;?></a></td>
		<td  align="center"><?php echo $b->jumlah_permintaan;?></a></td>
		</tr>
	</tbody>
	<?php 
			$no++;
			}
		}
		?>
	</tbody>
	</table>
	<?php
	
}
?>
</div>
</div>
</div>
