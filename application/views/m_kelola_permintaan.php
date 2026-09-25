<?php
$tab=1;
?>

<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Daftar Permintaan Alat Tulis/Alat Rumah Tangga Kantor
     <!-- <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_siswa_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah</a>
      </div>-->
    </div>
    <div class="panel-body">
	<div class="tabs">
		<ul class="nav nav-tabs" id="prodTabs">
			<li class="active"><a class="nav-link active" href="#all" data-toggle="tab">Semua</a></li>
			<li><a href="#not" data-toggle="tab">Belum Diserahkan</a></li>
		</ul>
	<div class="tab-content">	
		
	<div class="scroll tab-pane active" id="all"><br>	
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
		    <th width="25%">Kode Permintaan</th>
            <th width="35%">NIP-Nama Yang Mengajukan</th>
            <th width="35%">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td class="ctr">'.$d->id_permintaan.'</td>
                      <td>'.$d->nip_pegawai.'-'.$d->nama.'</td>
                      <td class="ctr">
                        <div class="btn-group">
							   <a href="#" onclick="return m_permintaan_setujui(\''.$d->id_permintaan.'\');" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Serahkan Barang</a>
                          <a href="#" onclick="return m_permintaan_e_admin(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Konfirmasi</a>
                          <a href="#" onclick="return m_permintaan_h_admin(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                          <a href="cetak_formpermintaan/'.$d->id_permintaan.'" class="btn btn-warning btn-xs" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
						  ';
                echo '</div>
                      </td>
                      </tr>
                      ';
              $no++;
              }
            }
          ?>
        </tbody>
      </table>
	</div>
	
	
	<div class="scroll tab-pane" id="not"><br>	
      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
		    <th width="25%">Kode Permintaan</th>
            <th width="35%">NIP-Nama Yang Mengajukan</th>
            <th width="35%">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($databelumdiserahkan)) {
              $no = 1;
              foreach ($databelumdiserahkan as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td class="ctr">'.$d->id_permintaan.'</td>
                      <td>'.$d->nip_pegawai.'-'.$d->nama.'</td>
                      <td class="ctr">
                        <div class="btn-group">
							   <a href="#" onclick="return m_permintaan_setujui(\''.$d->id_permintaan.'\');" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Serahkan Barang</a>
                          <a href="#" onclick="return m_permintaan_e_admin(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Konfirmasi</a>
                          <a href="#" onclick="return m_permintaan_h_admin(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                          <a href="cetak_formpermintaan/'.$d->id_permintaan.'" class="btn btn-warning btn-xs" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
						  ';
                echo '</div>
                      </td>
                      </tr>
                      ';
              $no++;
              }
            }
          ?>
        </tbody>
      </table>
	</div>
	
	</div>	
	</div>  
	  
      </div>
    </div>
  </div>
</div>
                    
