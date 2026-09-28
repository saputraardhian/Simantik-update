<div class="row">
  <div class="col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Master Barang
      <div class="tombol-kanan">
	  
        <a class="btn btn-success btn-sm tombol-kanan" href="#" onclick="return m_barang_e(0);"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah Barang</a>
      </div>
    </div>
    <div class="panel-body" style="padding: 0;">
      <div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 0;">
        <table class="table table-bordered table-hover" style="margin-bottom: 0; width: 100%; min-width: 680px; max-width: none; white-space: nowrap;">
        <thead>
          <tr>
            <th style="width: 50px; min-width: 50px;" class="ctr">No</th>
            <th style="width: 150px; min-width: 150px;">Kode Barang</th>
            <th style="min-width: 220px;">Nama Barang</th>
            <th style="width: 140px; min-width: 140px;">Stok Barang</th>
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
					  <td>'.$d->kode_jenisbarang.' '.$d->kode_subjenisbarang.'</td>
                      <td>'.$d->nama_barang.'</td>
                      <td>'.$d->stok_barang.' '.$d->satuan.'</td>
                      <td class="ctr">
                        <div class="btn-group">
                          <a href="#" onclick="return m_barang_e('.$d->id.');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" onclick="return m_barang_h('.$d->id.');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                  
                          ';
              //  <a href="#" onclick="return m_siswa_matkul('.$d->id.');" class="btn btn-success btn-xs"><i class="glyphicon glyphicon-th-list" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Mata Kuliah</a>

			//  if ($d->ada == "0") {
                //  echo '        <a href="#" onclick="return m_siswa_u('.$d->id.');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-user" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Aktifkan User</a>';
               // } 
                  
                
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
                    
<div class="modal fade" id="m_barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data Barang</h4>
      </div>
      <div class="modal-body">
          <form name="f_barang" id="f_barang" onsubmit="return m_barang_s();">
            <input type="hidden" name="id" id="id" value="0">
              <table class="table table-form">
				<tr><td style="width: 25%">Kode Jenis Barang</td><td style="width: 75%"><input type="text" class="form-control" name="kode_jenisbarang" id="kode_jenisbarang" required></td></tr>
                <tr><td style="width: 25%">Kode Subjenis Barang</td><td style="width: 75%"><input type="text" class="form-control" name="kode_subjenisbarang" id="kode_subjenisbarang" required></td></tr>
			    <tr><td style="width: 25%">Nama</td><td style="width: 75%"><input type="text" class="form-control" name="nama_barang" id="nama_barang" required></td></tr>
                <tr><td style="width: 25%">Stok Barang</td><td style="width: 75%"><input type="text" class="form-control" name="stok_barang" id="stok_barang" required></td></tr>
				<tr><td style="width: 25%">Satuan</td><td style="width: 75%"><input type="text" class="form-control" name="satuan" id="satuan" required></td></tr>
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

<?php
	//id permintaan
	$today=date("Y-m-d");
	//$hariini=date_format($today,"Y-m-d");
	$query = mysql_query("select max(substring(id_penerimaan,12,(LENGTH (id_penerimaan)-11))) as maxID from t_penerimaan_barang where substring(tgl_diterima,1,10)='$today' ORDER BY LENGTH(id_penerimaan) DESC, id_penerimaan DESC  ");
	$data = mysql_fetch_array($query);
	$idMax = $data['maxID'];
	$noUrut = (int) $idMax;
	$noUrut++;
	$newID = $today."-".sprintf($noUrut);
	//isi default
	$id_permintaan = '';
	$nama = array();
	$jumlah = array()
	
	?>

<div class="modal fade" id="m_barang_stok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div style="width:1000px"  class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data Barang Yang Diterima</h4>
      </div>
     <form action="<?php echo base_url();?>adm/m_barang/update_stok/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <label>&nbsp;&nbsp;Kode Penerimaan Barang</label>&nbsp;&nbsp;
                    <input type="text" name="id_penerimaan" id="id_penerimaan" value="<?php echo $newID; ?>" readonly/><br><br>
					<input type="hidden" name="id" id="id" value="0">
                   
					&nbsp;&nbsp;<a class="btn btn-success btn-sm " onclick="additem_stock(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a></label>
					<!--<a class="btn btn-success btn-sm " onclick="additem(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a>-->
                    <br>
					&nbsp;&nbsp;
					<div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px; padding: 0 10px;">
					<table class="table table-condensed" style="margin-bottom: 0; min-width: 620px;">
						<thead>
						<tr>
							 <th width="30%"> Nama Barang</th>
							 <th width="20%"> Jumlah Barang Diterima</th>
							 <th width="20%"> Sumber Penerimaan Barang</th>
							 <th width="20%"> Nilai Penerimaan</th>
							 <th width="10%"> Action </th>
						</tr>
						</thead>
                        <!--elemet sebagai target append-->
                        <tbody id="itemlist_stock">
							
                            <?php
                            /* DISINI SEDIKIT TRICKY
                             * ini untuk menampilkan isian yang telah diinputkan sebelumnya
                            tanpa ini inputan yang udah diinput akan hilang karena DOM hanya dimodifikasi
                            sebelum form disubmit, saat disubmit DOM akan kembali ke awal, oleh karena itu
                            kita perlu 'menangkap' inputan pada nama dan membuat baris tabel berdasarkan
                            inputan yang tadi disubmit */
                            $i = 0;
                            foreach ($nama as $key => $j) {
                                ?>
                                <tr id="<?php echo $key . 'tr' ;?>"> 
                                    <td width="40%"><select name="nama_input[<?php echo $key ?>]" id="nama_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></select></td>
									<td width="20%"><input name="jumlah_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
                                    <td width="20%"><input name="sumber_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
									<td width="20%"><input name="nilai_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
									<td width="20%"><a class="btn btn-success btn-sm " onclick="busek(' . <?php echo $key ; ?>. '); return false;" id="' . <?php echo $key ; ?> . '"><i class="glyphicon glyphicon-trash"></i>hapus</a></td>
                                </tr>
                                <?php
                                $i = $key;
                            }
                            ?>
                        </tbody>
                    </table>
					</div>
                    &nbsp;&nbsp;<button type="submit" name="submit" class="btn btn-small btn-primary">Simpan</button>
					<br><br>
                </form>        
    </div>
  </div>
</div>

<?php
			$nipku = $this->session->userdata('admin_nip');
			if (strlen($nipku) == 5)
			{
				$strSQL = "SELECT * FROM m_barang order by nama_barang";
			}
			else
			{
				$strSQL = "SELECT * FROM m_barang where substring(kode_jenisbarang,6,2) <> '05' order by nama_barang ";
			}
			$objQuery = mysql_query($strSQL);
?>
        <script language="javascript">
			function fncCreateSelectOption(ele)
			{
				var objSelect = ele;
				var Item = new Option("", ""); 
				objSelect.options[objSelect.length] = Item;
				<?php
				while($objResult = mysql_fetch_array($objQuery))
				{
				?>
				var Item = new Option("<?php echo $objResult['nama_barang'];?>","<?php echo $objResult['kode_jenisbarang'].'-'.$objResult['kode_subjenisbarang'];?>"); 
				objSelect.options[objSelect.length] = Item;
				<?php
				}
				?>
			}
			
	        var i = "<?php echo $i + 1; ?>";
            function additem_stock() {
//                menentukan target append
                var itemlist_stock = document.getElementById('itemlist_stock');

//                membuat element
                var row = document.createElement('tr');
                var nama = document.createElement('td');
				var jumlah = document.createElement('td');
				var sumber = document.createElement('td');
				var nilai = document.createElement('td');
                var aksi = document.createElement('td');
                aksi.setAttribute('width', '10px');

//                meng append element
                itemlist_stock.appendChild(row);
                row.appendChild(nama);
				row.appendChild(jumlah);
				row.appendChild(sumber);
				row.appendChild(nilai);
                row.appendChild(aksi);

//                membuat element select nama barang
                var nama_input = document.createElement('select');
                nama_input.setAttribute('name', 'nama_input[' + i + ']');
                nama_input.setAttribute('class', 'input-block-level');
				fncCreateSelectOption(nama_input);

				
//                membuat element input jumlah barang
                var jumlah_input = document.createElement('input');
                jumlah_input.setAttribute('name', 'jumlah_input[' + i + ']');
                jumlah_input.setAttribute('class', 'input-block-level');
				
 //                membuat element input sumber penerimaan barang
                var sumber_input = document.createElement('input');
                sumber_input.setAttribute('name', 'sumber_input[' + i + ']');
                sumber_input.setAttribute('class', 'input-block-level');
		
//                membuat element input nilai penerimaan barang
                var nilai_input = document.createElement('input');
                nilai_input.setAttribute('name', 'nilai_input[' + i + ']');
                nilai_input.setAttribute('class', 'input-block-level');
		
				var hapus = document.createElement('span');

//                meng append element input
                nama.appendChild(nama_input);
				jumlah.appendChild(jumlah_input);
				sumber.appendChild(sumber_input);
				nilai.appendChild(nilai_input);
                aksi.appendChild(hapus);

                hapus.innerHTML = '<a>hapus</a>';
//                membuat aksi delete element
                hapus.onclick = function () {
                    row.parentNode.removeChild(row);
                };

                i++;
            }

            function busek(id) {
                var ele = id + 'tr';
                var elem = document.getElementById(ele);
                return elem.parentNode.removeChild(elem);
            }
            ;
        </script>