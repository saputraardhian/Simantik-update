<?php

	/*id permintaan
	$today=date("Y-m-d");
	//$hariini=date_format($today,"Y-m-d");
	$query = mysql_query("select max(substring(id_permintaan,12,(LENGTH (id_permintaan)-11))) as maxID from t_permintaan_barang where substring(tgl_permintaan,1,10)='$today' ORDER BY LENGTH(id_permintaan) DESC, id_permintaan DESC  ");
	$data = mysql_fetch_array($query);
	$idMax = $data['maxID'];
	$noUrut = (int) $idMax;
	$noUrut++;
	$newID = $today."-".sprintf($noUrut);*/
	//isi default
	$id_permintaan = '';
	$nama = array();
	$jumlah = array();
	
	?>

<html>
    <body>
	<div class="row col-md-12">
	<div class="panel panel-info">
    <div class="panel-heading"><h4>Form Permintaan Barang ATK/ART Kantor</h4>
	</div>

		    <div class="panel-body">
			<?php echo $this->session->flashdata("k");?>
			  <table class="table table-bordered">
				<thead>
				  <tr>
					<th width="5%">No</th>
					<th width="25%">Kode Permintaan</th>
					<th width="35%">Aksi</th>
				  </tr>
				</thead>
				<tbody>
				  <?php 
					if (!empty($databarang)) {
					  $no = 1;
					  foreach ($databarang as $d) {
						 if($d->nip_pegawai_menyerahkan == '')
						 {
							echo '<tr>
								  <td class="ctr">'.$no.'</td>
								  <td class="ctr">'.$d->id_permintaan.'</td>
								  <td class="ctr">
									<div class="btn-group">
									  <a href="#" onclick="return m_permintaan_e(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-pencil" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Ubah</a>
									  <a href="#" onclick="return m_permintaan_h(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
									  <a href="cetak_formpermintaan/'.$d->id_permintaan.'" class="btn btn-warning btn-xs" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
									  ';
							echo '</div>
								  </td>
								  </tr>
								  ';
						 }
						 else
						 {
							echo '<tr>
								  <td class="ctr">'.$no.'</td>
								  <td class="ctr">'.$d->id_permintaan.'</td>
								  <td class="ctr">
									<div class="btn-group">
									  <a href="#" onclick="return m_permintaan_v(\''.$d->id_permintaan.'\');" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-search" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;View</a>
									  <a href="#" onclick="return m_permintaan_h(\''.$d->id_permintaan.'\');" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove" style="margin-left: 0px; color: #fff"></i> &nbsp;&nbsp;Hapus</a>
									  <a href="cetak_formpermintaan/'.$d->id_permintaan.'" class="btn btn-warning btn-xs" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>
									  ';
							echo '</div>
								  </td>
								  </tr>
								  '; 
							 
						 }
					  $no++;
					  }
					}
				  ?>
				</tbody>
			  </table>
		    </div>

        <div class="row-fluid">
            <div class="span6">
                <form action="<?php echo base_url();?>adm/permintaan_barang/simpan/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <label>&nbsp;&nbsp;Tambah Jenis Barang : </label>&nbsp;&nbsp;
                    <!--<input type="text" name="id_permintaan" id="id_permintaan" value="<?php echo $newID; ?>" readonly/><br><br>-->
					<input type="hidden" name="id" id="id" value="0">
                   
					&nbsp;&nbsp;<label><a class="btn btn-success btn-sm " onclick="additem(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Jenis Barang</a></label>
					<!--<a class="btn btn-success btn-sm " onclick="additem(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a>-->
                    <br>
					&nbsp;&nbsp;
					<table class="table table-condensed">
						<tr>
							 <th width="40%"> Nama Barang</th>
							 <th width="40%"> Jumlah Barang</th>
							 <th width="20%"> &nbsp;&nbsp; </th>
						</tr>
                        <!--elemet sebagai target append-->
                        <tbody id="itemlist">
							
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
									<td width="40%"><input name="jumlah_input[<?php echo $key ?>]" class="input-block-level" value="<?php echo $j ?>" /></td>
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
        </div>
		<?php
			$nipku = $this->session->userdata('admin_nip');
			$username = $this->session->userdata('admin_user');
			if (strlen($nipku) == 5 || $username == 'sunarto4' || $username == 'hyas')
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
			function fncCreateSelectOptionAjukan(ele)
			{
				var objSelect = ele;
				var Item = new Option("", ""); 
				objSelect.options[objSelect.length] = Item;
				<?php
				while($objResult = mysql_fetch_array($objQuery))
				{
				?>
				var Item = new Option("<?php echo $objResult['nama_barang'].' ('.$objResult['satuan'].')  ';?>","<?php echo $objResult['kode_jenisbarang'].'-'.$objResult['kode_subjenisbarang'];?>"); 
				objSelect.options[objSelect.length] = Item;
				<?php
				}
				?>
			}
			
	        var i = "<?php echo $i + 1; ?>";
            function additem() {
//                menentukan target append
                var itemlist = document.getElementById('itemlist');

//                membuat element
                var row = document.createElement('tr');
                var nama = document.createElement('td');
				var jumlah = document.createElement('td');
				//var kodejenis = document.createElement('td');
				//var kodesubjenis = document.createElement('td');
                var aksi = document.createElement('td');
                aksi.setAttribute('width', '50px');

//                meng append element
                itemlist.appendChild(row);
                row.appendChild(nama);
				row.appendChild(jumlah);
				//row.appendChild(kodejenis);
				//row.appendChild(kodesubjenis);
                row.appendChild(aksi);

//                membuat element select nama barang
                var nama_input = document.createElement('select');
                nama_input.setAttribute('name', 'nama_input[' + i + ']');
                nama_input.setAttribute('class', 'input-block-level');
				fncCreateSelectOptionAjukan(nama_input);

				
//                membuat element input jumlah barang
                var jumlah_input = document.createElement('input');
                jumlah_input.setAttribute('name', 'jumlah_input[' + i + ']');
                jumlah_input.setAttribute('class', 'input-block-level');
				
               
				var hapus = document.createElement('span');

//                meng append element input
                nama.appendChild(nama_input);
				jumlah.appendChild(jumlah_input);
				//kodejenis.appendChild(kodejenis_input);
				//kodesubjenis.appendChild(kodesubjenis_input);
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
    </body>
</html>

