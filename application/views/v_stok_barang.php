<div class="row col-md-12">
  <div class="panel panel-info">
    <div class="panel-heading">Transaksi Update Stok Barang
      <div class="tombol-kanan">
	    <a class="btn btn-warning btn-sm tombol-kanan" href="#" onclick="return m_barang_stok_new();"><i class="glyphicon glyphicon-plus"></i> &nbsp;&nbsp;Tambah Stok Barang</a>
       </div>
    </div>
    <div class="panel-body">


      <table class="table table-bordered">
        <thead>
          <tr>
            <th width="5%">No</th>
			<th width="10%">Kode Penerimaan</th>
			<th width="15%">Kode Barang</th>
            <th width="30%">Nama Barang</th>
            <th width="10%">Jumlah Penerimaan</th>
			<th width="15%">Sumber Penerimaan</th>
            <th width="25%">Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php 
            if (!empty($data)) {
              $no = 1;
              foreach ($data as $d) {
                echo '<tr>
                      <td class="ctr">'.$no.'</td>
					  <td class="ctr">'.$d->id_penerimaan.'</td>
					  <td>'.$d->kode_jenisbarang.' '.$d->kode_subjenisbarang.'</td>
                      <td>'.$d->nama_barang.'</td>
                      <td class="ctr">'.$d->jumlah_penerimaan.'</td>
					  <td class="ctr">'.$d->sumber_penerimaan.'</td>
                      <td class="">
                        <div class="btn-group">
                          <a href="#" onclick="return m_stokbarang_e('.$d->id.');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Edit</a>
                          <a href="#" onclick="return m_stokbarang_h('.$d->id.');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
                  
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

<div class="modal fade" id="m_editstok_barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Edit Penambahan Barang</h4>
      </div>
      <div class="modal-body">
          <form name="f_barang_stok" id="f_barang_stok" onsubmit="return m_barang_stok_s();">
            <input type="hidden" name="id" id="id" value="0">
              <table class="table table-form">
				<tr><td style="width: 25%">Kode Penerimaan</td><td style="width: 75%"><input type="text" class="form-control" name="id_penerimaan" id="id_penerimaan" readonly></td></tr>
				<tr><td style="width: 25%">Kode Jenis Barang</td><td style="width: 75%"><input type="text" class="form-control" name="kode_jenisbarang" id="kode_jenisbarang" readonly></td></tr>
                <tr><td style="width: 25%">Kode Subjenis Barang</td><td style="width: 75%"><input type="text" class="form-control" name="kode_subjenisbarang" id="kode_subjenisbarang" readonly></td></tr>
			    <tr><td style="width: 25%">Nama</td><td style="width: 75%"><input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly></td></tr>
                <tr><td style="width: 25%">Tanggal Dokumen</td><td style="width: 75%"><input type="date" class="form-control" name="tgl_dokumen" id="tgl_dokumen" required></td></tr>
				<tr><td style="width: 25%">Jumlah Penerimaan</td><td style="width: 75%"><input type="text" class="form-control" name="jumlah_penerimaan" id="jumlah_penerimaan" required></td></tr>
				<tr><td style="width: 25%">Sumber Penerimaan</td><td style="width: 75%"><input type="text" class="form-control" name="sumber_penerimaan" id="sumber_penerimaan" required></td></tr>
				<tr><td style="width: 25%">Nilai Penerimaan</td><td style="width: 75%"><input type="text" class="form-control" name="nilai_penerimaan" id="nilai_penerimaan" required></td></tr>
              
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

<div class="modal fade" id="m_barang_stok_new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div style="width:1200px"  class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 id="myModalLabel">Data Barang Yang Diterima</h4>
      </div>
     <form action="<?php echo base_url();?>adm/stok_barang/tambah_stok/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <label>&nbsp;&nbsp;Kode Penerimaan Barang</label>&nbsp;&nbsp;
                    <input type="text" name="id_penerimaan" id="id_penerimaan" value="<?php echo $newID; ?>" readonly/><br><br>
					<input type="hidden" name="id" id="id" value="0">
                   
					&nbsp;&nbsp;<a class="btn btn-success btn-sm " onclick="additem_stock(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a></label>
					<!--<a class="btn btn-success btn-sm " onclick="additem(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a>-->
                    <br>
					&nbsp;&nbsp;
					<table class="table table-condensed">
						<tr>
							 <th width="20%"> Nama Barang</th>
							 <th width="15%"> Jumlah Barang Diterima</th>
							 <th width="20%"> Sumber Penerimaan Barang</th>
							 <th width="15%"> Nilai Penerimaan</th>
							 <th width="20%"> Tanggal Dokumen</th>
							 <th width="10%"> Action </th>
						</tr>
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
                                    <td width="30%"><select name="nama_input[<?php echo $key ?>]" id="nama_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></select></td>
									<td width="15%"><input name="jumlah_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
                                    <td width="20%"><input name="sumber_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
									<td width="15%"><input name="nilai_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
									<td width="20%"><input name="tgl_diterima[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
									<td width="20%"><a class="btn btn-success btn-sm " onclick="busek(' . <?php echo $key ; ?>. '); return false;" id="' . <?php echo $key ; ?> . '"><i class="glyphicon glyphicon-trash"></i>hapus</a></td>
                                </tr>
                                <?php
                                $i = $key;
                            }
                            ?>
                        </tbody>
                    </table>
                    &nbsp;&nbsp;<button type="submit" name="submit" class="btn btn-small btn-primary">Simpan</button>
					<br><br>
                </form>        
    </div>
  </div>
</div>

<?php
			$strSQL = "SELECT * FROM m_barang";
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
				var tgl = document.createElement('td');
                var aksi = document.createElement('td');
                aksi.setAttribute('width', '10px');

//                meng append element
                itemlist_stock.appendChild(row);
                row.appendChild(nama);
				row.appendChild(jumlah);
				row.appendChild(sumber);
				row.appendChild(nilai);
				row.appendChild(tgl);
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
				
//                membuat element input tanggal penerimaan barang
                var tgl_diterima = document.createElement('input');
                tgl_diterima.setAttribute('name', 'tgl_diterima[' + i + ']');
                tgl_diterima.setAttribute('class', 'input-block-level');
				tgl_diterima.setAttribute('type', 'date');
				
				var hapus = document.createElement('span');

//                meng append element input
                nama.appendChild(nama_input);
				jumlah.appendChild(jumlah_input);
				sumber.appendChild(sumber_input);
				nilai.appendChild(nilai_input);
				tgl.appendChild(tgl_diterima);
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