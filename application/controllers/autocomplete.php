<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function search()
	{
		// tangkap variabel keyword dari URL
		$keyword = $this->input->get('keyword');;
		// cari di database
		$data = $this->db->from('m_barang')->like('nama_barang',$keyword)->get();	

		// format keluaran di dalam array
		foreach($data->result() as $row)
		{
			$arr['query'] = $keyword;
			$arr['suggestions'][] = array(
				'nama_barang'	=>$row->nama_barang,
				'kode_jenisbarang'	=>$row->kode_jenisbarang,
				'kode_subjenisbarang'	=>$row->kode_subjenisbarang,
				'stok_barang'	=>$row->stok_barang

			);
		}
		// minimal PHP 5.2
		echo json_encode($arr);
	}
}
?>