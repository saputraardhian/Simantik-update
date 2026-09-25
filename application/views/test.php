<div class="modal fade" id="m_permintaan_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div style="width:1000px" margin"30px" class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button><h4 id="myModalLabel">Setujui Permintaan Barang</h4>
			</div>
			<div class="modal-body">
			
			<form width="90%" name="f_permintaan_edit" id="f_permintaan_edit" method="post" action="/simantik/adm/kelola_permintaan_barang/edit_permintaan/">
			<label>&nbsp;&nbsp;Kode Permintaan Barang</label>&nbsp;&nbsp;
			<input type="text" name="id_permintaan" id="id_permintaan" value="2019-01-16-2" readonly /><br>
			<div id="konfirmasi"></div>
			<table class="table table-condensed">
			<tr>
				<th width="40%"> Nama Barang</th> 
				<th width="40%"> Jumlah Barang</th> 
				<th width="20%"> &nbsp;&nbsp; </th>
			</tr>
			<tbody id="itemlist">
			<tr id="12tr"> 
				<td width="40%"><select name="nama_input[12]" id="12" class="input-block-level" ><option class="input-block-level" value="1010301011000001" >Hechmachine No. 10</option></select></td>
				<td width="40%"><input name="jumlah_input[12]" class="input-block-level" value="4" /></td>
				<td width="200px"><a onclick="busek(12); return false;" id="12">hapus</a></td>
			</tr>
			<tr id="10tr"> 
				<td width="40%"><select name="nama_input[10]" id="10" class="input-block-level" ><option class="input-block-level" value="1010305012000001" >Kreolin Wangi Cemara</option></select></td>
				<td width="40%"><input name="jumlah_input[10]" class="input-block-level" value="2" /></td>
				<td width="200px"><a onclick="busek(10); return false;" id="10">hapus</a></td>
			</tr>
				<tr id="11tr"> <td width="40%"><select name="nama_input["11"]" id="11" class="input-block-level" ><option class="input-block-level" value="1010304004000005" >Pita Rol Facsimile</option></select></td>
				<td width="40%"><input name="jumlah_input[11]" class="input-block-level" value="3" /></td>
				<td width="200px"><a onclick="busek(11); return false;" id="11">hapus</a></td>
			</tr>
			<a class="btn btn-success btn-sm " onclick="additem(); return false"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;Tambah Barang</a><br>
		</tbody>
		</table>
		
		<div class="modal-footer"><button class="btn btn-primary" type="submit">Update</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div>
		</form>
		</div>
		</div>
		</div>
		</div>