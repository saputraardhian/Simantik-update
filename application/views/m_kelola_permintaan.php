<?php
$tab=1;
?>

<div class="row">
  <div class="col-md-12">
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
		
	<div class="scroll tab-pane active" id="all" style="padding-top: 10px;">	
    <div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 0;">
      <table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 820px; max-width: none; white-space: nowrap;">
        <thead>
          <tr>
            <th style="width: 50px; min-width: 50px;" class="ctr">No</th>
		    <th style="width: 170px; min-width: 170px;" class="ctr">Kode Permintaan</th>
            <th style="min-width: 250px;">NIP-Nama Yang Mengajukan</th>
            <th style="width: 350px; min-width: 350px;" class="ctr">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td class="ctr" style="font-weight: 700; color: #0f172a;">'.$d->id_permintaan.'</td>
                      <td>'.$d->nip_pegawai.' - '.$d->nama.'</td>
                      <td class="ctr">
                        <div class="btn-group" style="display: inline-flex; gap: 4px;">
							   <a href="#" onclick="return m_permintaan_setujui(\''.$d->id_permintaan.'\');" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> Serahkan Barang</a>
                          <a href="#" onclick="return m_permintaan_e_admin(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> Konfirmasi</a>
                          <a href="#" onclick="return m_permintaan_h_admin(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> Hapus</a>
                          <a href="javascript:void(0)" onclick="return preview_cetak(\''.$d->id_permintaan.'\');" class="btn btn-warning btn-xs" title="Pratinjau & Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
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
	
	
	<div class="scroll tab-pane" id="not" style="padding-top: 10px;">	
    <div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 0;">
      <table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 820px; max-width: none; white-space: nowrap;">
        <thead>
          <tr>
            <th style="width: 50px; min-width: 50px;" class="ctr">No</th>
		    <th style="width: 170px; min-width: 170px;" class="ctr">Kode Permintaan</th>
            <th style="min-width: 250px;">NIP-Nama Yang Mengajukan</th>
            <th style="width: 350px; min-width: 350px;" class="ctr">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($databelumdiserahkan)) {
              $no = 1;
              foreach ($databelumdiserahkan as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
                      <td class="ctr" style="font-weight: 700; color: #0f172a;">'.$d->id_permintaan.'</td>
                      <td>'.$d->nip_pegawai.' - '.$d->nama.'</td>
                      <td class="ctr">
                        <div class="btn-group" style="display: inline-flex; gap: 4px;">
							   <a href="#" onclick="return m_permintaan_setujui(\''.$d->id_permintaan.'\');" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> Serahkan Barang</a>
                          <a href="#" onclick="return m_permintaan_e_admin(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> Konfirmasi</a>
                          <a href="#" onclick="return m_permintaan_h_admin(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> Hapus</a>
                          <a href="javascript:void(0)" onclick="return preview_cetak(\''.$d->id_permintaan.'\');" class="btn btn-warning btn-xs" title="Pratinjau & Cetak"><i class="glyphicon glyphicon-print"></i> Cetak</a>
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
</div>
                    
