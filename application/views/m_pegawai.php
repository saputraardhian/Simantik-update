<div class="row">
  <div class="col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Master Pegawai
      <div class="tombol-kanan">
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_pegawai_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah Pegawai</a>
      </div>
    </div>
    <div class="panel-body" style="padding: 0;">
      <div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 0;">
        <table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 680px; max-width: none; white-space: nowrap;">
        <thead>
          <tr>
            <th style="width: 50px; min-width: 50px;" class="ctr">No.</th>
            <th style="width: 170px; min-width: 170px;">NIP</th>
            <th style="min-width: 220px;">Nama</th>
            <th style="width: 150px; min-width: 150px;">Username</th>
            <th style="width: 140px; min-width: 140px;" class="ctr">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
					  <td>'.$d->nip.'</td>
                      <td>'.$d->nama.'</td>
                      <td>'.$d->username.'</td>
                      <td class="ctr">
                        <div class="btn-group">
                          <a href="#" role="button" onclick="return m_pegawai_e('.$d->id.');" class="btn btn-info btn-xs" title="Edit Pegawai"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" role="button" onclick="return m_pegawai_h('.$d->id.');" class="btn btn-danger btn-xs" title="Hapus Pegawai"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                        </div>
                      </td>
                      </tr>';
                $no++;
              }
            } else {
            ?>
              <tr>
                <td colspan="5" class="ctr" style="padding: 32px; color: #475569;">
                  <i class="fa-solid fa-users" style="font-size: 32px; margin-bottom: 8px; display: block; color: #94a3b8;"></i>
                  <span style="font-size: 13.5px; font-weight: 500;">Belum ada data master pegawai.</span>
                </td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
      </div>
      </div>
    </div>
  </div>
</div>
                    




<div class="modal fade" id="m_pegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data Pegawai</h4>
      </div>
      <div class="modal-body">
          <form name="f_pegawai" id="f_pegawai" onsubmit="return m_pegawai_s();">
            <input type="hidden" name="id" id="id" value="0">
              <table class="table table-form">
				<tr><td style="width: 25%">NIP</td><td style="width: 75%"><input type="text" class="form-control" name="nip" id="nip" required></td></tr>
                <tr><td style="width: 25%">Nama</td><td style="width: 75%"><input type="text" class="form-control" name="nama" id="nama" required></td></tr>
			    <tr><td style="width: 25%">Username</td><td style="width: 75%"><input type="text" class="form-control" name="username" id="username" required></td></tr>
                <tr><td style="width: 25%">Password</td><td style="width: 75%"><input type="password" class="form-control" name="password" id="password" required></td></tr>
				<tr><td width="20%">Level</td><td><b>
					<select name="level" id="level" class="form-control" style="width: 200px" required tabindex="6" ><option value=""> - Level - </option>
					<?php
						$l_level	= array('admin','admin_tu','user');
						$l_level_nama	= array('Admin','Admin Tata Usaha','User');
						for ($i = 0; $i < sizeof($l_level); $i++) {
								echo "<option value='".$l_level[$i]."'>".$l_level_nama[$i]."</option>";
						}			
					?>			
					</select>
					</b></td></tr>
					<tr>
					<td width="20%">Unit Kerja</td>
					<td>
						<select name="id_unitkerja" id="id_unitkerja"  class="form-control" tabindex="6" style="width: 200px">
							<option value="Kosong">- Pilih Unit Kerja -</option>
								<?php
								//mengambil nama-nama unitkerja yang ada di database
								$unitkerjaque = mysql_query("select * from m_unitkerja ");
								while($p=mysql_fetch_array($unitkerjaque)){
									echo "<option value='".$p[id_unitkerja]."'>".$p[unitkerja]."</option>\n";
								}
						?>
						</select>  
					</td>
					</tr>
					<tr><td width="20%">Eselon</td>
					<td><b>
					<select name="id_eselon" id="id_eselon" class="form-control" tabindex="3" style="width: 200px" >
					<option value="Kosong">- Pilih Eselon -</option>
					<?php
						$l_eselon	= array('0','2','3','4');
						$l_nama_eselon	= array('None','Eselon 2','Eselon 3','Eselon 4');
						
						for ($i = 0; $i < sizeof($l_eselon); $i++) {
							echo "<option value='".$l_eselon[$i]."'>".$l_nama_eselon[$i]."</option>";
						}		
					?>			
					</select>
					</b></td>
				</tr>
              </table>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
      </div>
        </form>
    </div>
  </div>
</div>