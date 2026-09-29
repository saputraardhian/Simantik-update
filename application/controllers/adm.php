<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adm extends CI_Controller {

	public function __construct() {
    parent::__construct();
    // load base_url
		$this->load->helper('url');
		$this->load->model('user_model');
		$this->load->model('pegawai_model');
	}
	
	public function cek_aktif() {
		if ($this->session->userdata('admin_valid') == false && $this->session->userdata('admin_id') == "") {
			redirect('adm/logina');
		} 
	}
	
	public function index() {
		$this->cek_aktif();
		
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');
		$a['p']			= "v_main";
		
		$this->load->view('aaa', $a);
	}

	public function rubah_password() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_admin_id'] = $this->session->userdata('admin_id');
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');
		$nip=$this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));
		$ret = array();
		if ($uri3 == "simpan") {
			$p1_md5 = md5($p->p1);
			$p2_md5 = md5($p->p2);
			$p3_md5 = md5($p->p3);

			$cek_pass_lama = $this->db->query("SELECT password FROM m_pegawai WHERE nip = '$nip'")->row();

			if ($cek_pass_lama->password != $p1_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password lama tidak sama...";
			} else if ($p2_md5 != $p3_md5) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru konfirmasinya tidak sama...";
			} else if (strlen($p->p2) < 6) {
				$ret['status'] = "error";
				$ret['msg'] = "Password baru minimal terdiri dari 6 huruf..";
 			} else {
				$this->db->query("UPDATE m_pegawai SET password = '".$p3_md5."' WHERE nip = '$nip'");
				$ret['status'] = "ok";
				$ret['msg'] = "Password berhasil diubah...";
			}
			$this->j($ret);
			exit;
		} else {
			$data = $this->db->query("SELECT id, nip, level, username FROM m_pegawai WHERE nip = '$nip'")->row();
			$this->j($data);
			exit;
		}
	}

	
	/* Login Logout */

	public function login() {
		$this->load->view('aaa_login');
	}
	
	public function logina() {
		$this->load->view('aaa_logina');
	}
	
	public function act_login() {
		
		$username	= $this->bersih($_POST['username']);
		$password	= $this->bersih($_POST['password']);
		
		$password2	= md5($password);
		
		$q_data		= $this->db->query("SELECT * FROM m_pegawai WHERE username = '".$username."' AND password = '".$password2."'");
		$j_data		= $q_data->num_rows();
		$a_data		= $q_data->row();
		
		$_log		= array();
		if ($j_data === 1) {
			
			$sess_nama_user = "";

			//if ($a_data->level == "0") {
				$det_user = $this->db->query("SELECT nama FROM m_pegawai WHERE username = '".$username."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			/*} else if ($a_data->level == "4") {
				$det_user = $this->db->query("SELECT nama FROM m_guru WHERE id = '".$a_data->kon_id."'")->row();
				if (!empty($det_user)) {
					$sess_nama_user = $det_user->nama;
				}
			} else {
				$sess_nama_user = "Administrator Pusat";
			}
			*/
			$data = array(
                    'admin_id' => $a_data->id,
                    'admin_user' => $a_data->username,
                    'admin_level' => $a_data->level,
                    'admin_nip' => $a_data->nip,
                    'admin_nama' => $sess_nama_user,
					'admin_valid' => true
                    );
					
					
            $this->session->set_userdata($data);
			$_log['log']['status']			= "1";
			$_log['log']['keterangan']		= "Login berhasil";
			$_log['log']['detil_admin']		= $this->session->userdata;
		
		} else {
			$_log['log']['status']			= "0";
			$_log['log']['keterangan']		= "Maaf, username dan password tidak ditemukan";
			$_log['log']['detil_admin']		= null;
		}
		
		$this->j($_log);
	}
	
	public function act_logina() {
		
		$username	= $this->bersih($_POST['username']);
		$password	= $this->bersih($_POST['password']);
		
		$password2	= md5($password);
		if($username && $password){
			
			$q_data		= $this->db->query("SELECT * FROM m_pegawai WHERE username = '".$username."' AND password = '".$password2."'");
			$j_data		= $q_data->num_rows();
			$a_data		= $q_data->row();
			
			$_log		= array();
			if ($j_data == 1) {
				$data = array(
                    'admin_id' 		=> $a_data->id,
                    'admin_user' 	=> $a_data->username,
                    'admin_level' 	=> $a_data->level,
                    'admin_nip' 	=> $a_data->nip,
                    'admin_nama' 	=> $a_data->nama,
					'admin_valid' 	=> true
				);
				
				$this->session->set_userdata($data);
				$_log['log']['status']			= "1";
				$_log['log']['keterangan']		= "Login berhasil";
				$_log['log']['detil_admin']		= $this->session->userdata;
				$this->j($_log);
				return;
			}
			else if($this->input->post('ppnpn') && $this->input->post('ppnpn')=='ppnpn')
			{
				$_log['log']['status']			= "0";
				$_log['log']['keterangan']		= "Maaf, username dan password tidak terdaftar";
				$_log['log']['detil_admin']		= null;
				$this->j($_log);
				return;
			}
			else
			{
				$row 	= $this->pegawai_model->login($username,$password);
				$_log		= array();
				if($row){
					if($username == 'ichiek_vin' || $username == 'christina.lia')
					{
						$level='admin_tu';
					}
					else if($username == 'rizchi')
					{
						$level='admin';
					}
					else
					{
						$level='user';
					}
					$data = array(
						'admin_id' 		=> $row->niplama,
						'admin_user'	=> $username,
						'admin_nama'	=> $row->nama,
						'admin_niplama'	=> $row->niplama,
						'admin_nip'		=> $row->nipbaru,
						'admin_wilayah'	=> $row->id_wilayah,
						'admin_unitkerja'=> substr($row->id_unitkerja,0,4),
						'id_level'		=> $row->eselon,
						'admin_level'   => $level,
						'src'			=> 'db',
						'admin_valid' 	=> true
					); 
				
				$_log['log']['status']			= "1";
				$_log['log']['keterangan']		= "Login berhasil";
				$_log['log']['detil_admin']		= $this->session->userdata;	
				}
				else {
					$this->load->library('user_bps');
					$akun = new UserBPS();
					$akun->login($username, $password);
					if($akun->isLogin()){
					$this->pegawai_model->set_login($username,$password);

					$userJSON = json_decode($akun->getJSON(), true); //print_r($userJSON); exit();
					if($username == 'ganes')
					{
						$level='admin_tu';
					}
					else if($username == 'rizchi' || $username == 'puguh.raharjo')
					{
						$level='admin';
					}
					else
					{
						$level='user';
					}
					if($userJSON && substr($userJSON['id_wilayah'],0,2)=='33'){
						$data = array(
							'admin_username'	=> $user,
							'admin_id' 			=> $userJSON['niplama'],
							'admin_nama'		=> $userJSON['nama'],
							'admin_niplama'		=> $userJSON['niplama'],
							'admin_nip'			=> $userJSON['nipbaru'],
							'admin_wilayah'		=> $userJSON['id_wilayah'],
							'admin_unitkerja'	=> substr($userJSON['id_unitkerja'],0,4),
							'id_level'			=> $userJSON['id_eselon']? 5:1,
							'admin_level'		=> $level,
							'wfh_admin'			=> $userJSON['id_eselon']? 1:0,
							'src'				=> 'lib',
							'admin_valid' 		=> true
						);
					} else
						$_log['log']['status']			= "0";
						$_log['log']['keterangan']		= "Maaf, username dan password tidak ditemukan dalam database pegawai";
						$_log['log']['detil_admin']		= null;
					
				} elseif($akun->getError()) {
					$error = $akun->getError();
				} else {
					$_log['log']['status']			= "0";
					$_log['log']['keterangan']		= "Maaf, username dan password tidak terdaftar dalam database pegawai";
					$_log['log']['detil_admin']		= null;
					}
				}
				$this->session->set_userdata($data);
			}
		}
		else {
			$_log['log']['status']			= "0";
			$_log['log']['keterangan']		= "Username dan password tidak boleh kosong";
			$_log['log']['detil_admin']		= null;
		}
		$this->j($_log);
	}
	
	public function logout() {
		$data = array(
                    'admin_id' 		=> "",
                    'admin_user' 	=> "",
                    'admin_level' 	=> "",
                    'admin_konid' 	=> "",
                    'admin_nama' 	=> "",
					'admin_valid' 	=> false
                    );
        $this->session->set_userdata($data);
		redirect('adm');
	}


	//fungsi tambahan
	public function get_akhir($tabel, $field, $kode_awal, $pad) {
		$get_akhir	= $this->db->query("SELECT MAX($field) AS max FROM $tabel LIMIT 1")->row();
		$data		= (intval($get_akhir->max)) + 1;
		$last		= $kode_awal.str_pad($data, $pad, '0', STR_PAD_LEFT);
	
		return $last;
	}

	
	public function bersih($teks) {
		return mysql_real_escape_string($teks);
	}
	
	public function j($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}
	
	
	//master barang
	public function m_barang() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_barang.* FROM m_barang order by kode_jenisbarang, kode_subjenisbarang asc")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_barang WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_barang SET nama_barang = '".bersih($p,"nama_barang")."', kode_jenisbarang = '".bersih($p,"kode_jenisbarang")."', stok_barang = '".bersih($p,"stok_barang")."', satuan = '".bersih($p,"satuan")."' WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_barang VALUES (null, '".bersih($p,"kode_jenisbarang")."', '".bersih($p,"kode_subjenisbarang")."', '".bersih($p,"nama_barang")."', '".bersih($p,"stok_barang")."', '".bersih($p,"satuan")."')");
			
				$today=date("Y-m-d");
				//$hariini=date_format($today,"Y-m-d");
				$query = mysql_query("select max(substring(id_penerimaan,12,(LENGTH (id_penerimaan)-11))) as maxID from t_penerimaan_barang where substring(tgl_diterima,1,10)='$today' ORDER BY LENGTH(id_penerimaan) DESC, id_penerimaan DESC  ");
				$data = mysql_fetch_array($query);
				$idMax = $data['maxID'];
				$noUrut = (int) $idMax;
				$noUrut++;
				$id_penerimaan = $today."-".sprintf($noUrut);
				$nip_pengajuan='198204262011012009';
			
				$this->db->query("INSERT INTO t_penerimaan_barang VALUES (null,'$id_penerimaan','$nip_pengajuan','".bersih($p,"kode_jenisbarang")."','".bersih($p,"kode_subjenisbarang")."','$today','$today','".bersih($p,"stok_barang")."','Pembelian Baru','0')");
				$query_stok=$this->db->query("select * from m_barang where kode_jenisbarang='".bersih($p,"kode_jenisbarang")."' and kode_subjenisbarang='".bersih($p,"kode_subjenisbarang")."'")->row();
				$stok_barang=$query_stok->stok_barang;
				$this->db->query("insert into t_stok_penerimaan VALUES  (null,'$id_penerimaan','".bersih($p,"kode_jenisbarang")."','".bersih($p,"kode_subjenisbarang")."','$stok_barang')");
			
			}
			
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "update_stok") {
			$today=date("Y-m-d H:i:s");
			$id_penerimaan = addslashes($this->input->post('id_penerimaan'));
			$id = addslashes($this->input->post('id'));
			$nama = isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah = isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$sumber = isset($_POST['sumber_input']) ? $_POST['sumber_input'] : array();
			$nilai = isset($_POST['nilai_input']) ? $_POST['nilai_input'] : array();
			$nip_pengajuan = $this->session->userdata('admin_nip');
					
			//        masukkan nama barang
					$i=1;
					foreach ($nama as $key => $n) {
						$key=$i;
						$kodebarang=$nama[$key];
						$jumlahbarang=$jumlah[$key];
						$sumber_input=$sumber[$key];
						$nilai_input=$nilai[$key];
						$kode_jenisbarang = substr($kodebarang,0,10);
						$kode_subjenisbarang = substr($kodebarang,11,6);
						$this->db->query("INSERT INTO t_penerimaan_barang VALUES (null,'$id_penerimaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$today','$jumlahbarang','$sumber_input','$nilai_input')");
						$this->db->query("UPDATE m_barang set stok_barang=stok_barang+'$jumlahbarang' where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang';");
						$query_stok=$this->db->query("select * from m_barang where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'")->row();
						$stok_barang=$query_stok->stok_barang;
						$this->db->query("insert into t_stok_penerimaan VALUES  (null,'$id_penerimaan','$kode_jenisbarang','$kode_subjenisbarang','$stok_barang')");
						$i++;
					}
			//        redirect
			redirect('adm/m_barang/');

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		}else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_barang WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		}else {
			$a['p']	= "m_barang";
		}

		$this->load->view('aaa', $a);
	}
	
	
	//master pegawai
	public function m_pegawai() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT m_pegawai.* FROM m_pegawai order by id_unitkerja asc, id_eselon desc")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT * FROM m_pegawai WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$ket 	= "";
			if ($p->id != 0) {
				$this->db->query("UPDATE m_pegawai SET username = '".bersih($p,"username")."', password = '".md5(bersih($p,"password"))."', nama = '".bersih($p,"nama")."' , nip = '".bersih($p,"nip")."', level = '".bersih($p,"level")."', id_unitkerja = '".bersih($p,"id_unitkerja")."', id_eselon = '".bersih($p,"id_eselon")."'  WHERE id = '".bersih($p,"id")."'");
				$ket = "edit";
			} else {
				$ket = "tambah";
				$this->db->query("INSERT INTO m_pegawai VALUES (null, '".bersih($p,"username")."', '".md5(bersih($p,"password"))."', '".bersih($p,"nama")."', '".bersih($p,"nip")."', '".bersih($p,"level")."', '".bersih($p,"id_unitkerja")."', '".bersih($p,"id_eselon")."')");
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$this->db->query("DELETE FROM m_pegawai WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		}else {
			$a['p']	= "m_pegawai";
		}

		$this->load->view('aaa', $a);
	}
	
	
	//ajukan permintaan barang
	public function permintaan_barang() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT t_permintaan_barang.* FROM t_permintaan_barang")->result();

		if ($uri3 == "simpan") {
			
				$today=date("Y-m-d");
				//$hariini=date_format($today,"Y-m-d");
				$query = mysql_query("select max(cast(substring(id_permintaan,12,(LENGTH (id_permintaan)-11)) as SIGNED)) as maxID from t_permintaan_barang where substring(tgl_permintaan,1,10)='$today' ORDER BY LENGTH(id_permintaan) DESC, id_permintaan DESC  ");
				$data = mysql_fetch_array($query);
				$idMax = $data['maxID'];
				$noUrut = (int) $idMax;
				$noUrut++;
				$newID = $today."-".sprintf($noUrut);
				
			$today=date("Y-m-d H:i:s");
			$id_permintaan = $newID;
			//$id_permintaan = addslashes($this->input->post('id_permintaan'));
			$id = addslashes($this->input->post('id'));
			$nama = isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah = isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$nip_pengajuan = $this->session->userdata('admin_nip');
				
			//echo implode(',',$nama);
			$ket = "tambah";
			
							$outofstock=0;
							$nama_barang_habis='';
							foreach ($nama as $key => $n) 
							{
								//$key=$i;
								$kodebarang=$nama[$key];
								$jumlahbarang=$jumlah[$key];
								$kode_jenisbarang = substr($kodebarang,0,10);
								$kode_subjenisbarang = substr($kodebarang,11,6);
							
								$stok_barang_sekarang = $this->db->query ("SELECT stok_barang,nama_barang from m_barang where kode_jenisbarang='$kode_jenisbarang' AND kode_subjenisbarang='$kode_subjenisbarang'")->row();
								if($stok_barang_sekarang->stok_barang < $jumlahbarang)
								{
									$outofstock=$outofstock+1;
									$nama_barang_habis=$stok_barang_sekarang->nama_barang;
								}
								else
								{
									$outofstock=$outofstock;
								}
							}
							
							if($outofstock == 0)
							{
								foreach ($nama as $key => $n) 
								{
									//$key=$i;
									$kodebarang=$nama[$key];
									$jumlahbarang=$jumlah[$key];
									$kode_jenisbarang = substr($kodebarang,0,10);
									$kode_subjenisbarang = substr($kodebarang,11,6);
									$this->db->query("INSERT INTO t_permintaan_barang VALUES (null,'$id_permintaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$jumlahbarang','','','$today','1','')");
								}
							}
							else
							{
								$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Jumlah ".$nama_barang_habis." Yang Diminta Melebihi Stok Yang Tersedia</div>");	
							}
	
			//        masukkan nama barang
				/*	$i=1;
					foreach ($nama as $key => $n) {
						$key=$i;
						$kodebarang=$nama[$key];
						$jumlahbarang=$jumlah[$key];
						$kode_jenisbarang = substr($kodebarang,0,10);
						$kode_subjenisbarang = substr($kodebarang,11,6);
						$stok_barang_sekarang = $this->db->query ("SELECT stok_barang,nama_barang from m_barang where kode_jenisbarang='$kode_jenisbarang' AND kode_subjenisbarang='$kode_subjenisbarang'")->row();
						if($jumlahbarang > $stok_barang_sekarang->stok_barang)
						{
							$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Jumlah ".$stok_barang_sekarang->nama_barang." Yang Diminta Melebihi Stok Yang Tersedia</div>");
						}
						else
						{
						$this->db->query("INSERT INTO t_permintaan_barang VALUES (null,'$id_permintaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$jumlahbarang','','','$today','1','')");
						}
						$i++;
					}*/
			//        redirect
			redirect('adm/permintaan_barang');

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else {
			$nip_pengajuan = $this->session->userdata('admin_nip');
			$a['databarang'] = $this->db->query("SELECT distinct t.id_permintaan,t.nip_pegawai, p.nama, t.nip_pegawai_menyerahkan FROM t_permintaan_barang t left join m_pegawai p on t.nip_pegawai=p.nip where t.is_tampil='1' and t.nip_pegawai='$nip_pengajuan' order by tgl_permintaan desc")->result();
			$a['p']	= "v_permintaan_barang";
		}

		$this->load->view('aaa', $a);
	}
	
	public function cetak_formpermintaan() {
		$this->cek_aktif();
		
		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		$a['id_permintaan'] = $uri3;
		$a['permintaan_barang'] = $this->db->query("SELECT t.*,b.* from t_permintaan_barang t left join m_barang b on t.kode_jenisbarang=b.kode_jenisbarang AND t.kode_subjenisbarang=b.kode_subjenisbarang where t.id_permintaan='$uri3'")->result();
		$a['datayangmengajukan'] = $this->db->query("SELECT t.nip_pegawai, p.nama, p.id_unitkerja, u.unitkerja FROM t_permintaan_barang t LEFT JOIN m_pegawai p ON t.nip_pegawai = p.nip LEFT JOIN m_unitkerja u ON p.id_unitkerja = u.id_unitkerja WHERE t.id_permintaan='$uri3' LIMIT 1")->row();
		$a['qtgl_permintaan']=$this->db->query("select date(tgl_permintaan) as tgl_permintaan from t_permintaan_barang where id_permintaan='$uri3' LIMIT 1")->row();
		$this->load->view("v_cetak_formpermintaan", $a);
	}
	
	public function kelola_permintaan_barang() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();
		$bulan_ini=date("m");
		$tahun_ini=date("Y");
		$tahun_sebelumnya = $tahun_ini-1;
		$bulan_sebelumnya=date("m")-1;
		
		$a['data'] = $this->db->query("SELECT distinct t.id_permintaan,t.nip_pegawai, p.nama FROM t_permintaan_barang t left join m_pegawai p on t.nip_pegawai=p.nip where ((substring(t.tgl_permintaan,6,2)='$bulan_ini' or month(t.tgl_permintaan)='$bulan_sebelumnya' or month(t.tgl_permintaan)>='7' or month(t.tgl_permintaan)<='12' or month(t.tgl_permintaan)='10') and (substring(t.tgl_permintaan,1,4)='$tahun_ini' or substring(t.tgl_permintaan,1,4)='$tahun_sebelumnya')) order by tgl_permintaan desc")->result();
		$a['databelumdiserahkan'] = $this->db->query("SELECT distinct t.id_permintaan,t.nip_pegawai, p.nama FROM t_permintaan_barang t left join m_pegawai p on t.nip_pegawai=p.nip where ((substring(t.tgl_permintaan,6,2)='$bulan_ini' or month(t.tgl_permintaan)='$bulan_sebelumnya' or month(t.tgl_permintaan)>='7' or month(t.tgl_permintaan)<='12' or month(t.tgl_permintaan)='10') and (substring(t.tgl_permintaan,1,4)='$tahun_ini' or substring(t.tgl_permintaan,1,4)='$tahun_sebelumnya') and t.nip_pegawai_menyerahkan='') order by tgl_permintaan desc")->result();
		
		
		if ($uri3 == "det") {
			$a = $this->db->query("SELECT t_permintaan_barang FROM m_pegawai WHERE id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "simpan") {
			$today=date("Y-m-d H:i:s");
			$id_permintaan = addslashes($this->input->post('id_permintaan'));
			$id = addslashes($this->input->post('id'));
			$nama = isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah = isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$nip_pengajuan = $this->session->userdata('admin_nip');
				
			echo implode(',',$nama);
			
			$ket = "tambah";
		//        masukkan nama barang
					$i=1;
					foreach ($nama as $key => $n) {
						$key=$i;
						$kodebarang=$nama[$key];
						$jumlahbarang=$jumlah[$key];
						$kode_jenisbarang = substr($kodebarang,0,10);
						$kode_subjenisbarang = substr($kodebarang,11,6);
						$this->db->query("INSERT INTO t_permintaan_barang VALUES (null,'$id_permintaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$jumlahbarang','','','$today','1','')");
						$i++;
					}
					
			//        redirect
			redirect('adm/cetak_formpermintaan/'.$id_permintaan);

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "hapus") {
			$barang_yangdiminta = $this->db->query("select * from t_permintaan_barang WHERE id_permintaan = '".$uri4."'")->result();
			foreach($barang_yangdiminta as $b)
			{
				if($b->nip_pegawai_menyerahkan != '')
				{
				$this->db->query("UPDATE m_barang set stok_barang=stok_barang+'".$b->jumlah_permintaan."' where kode_jenisbarang='".$b->kode_jenisbarang."' and kode_subjenisbarang='".$b->kode_subjenisbarang."'");
				$this->db->query("DELETE FROM t_stok_permintaan WHERE id_permintaan = '".$uri4."' and kode_jenisbarang='".$b->kode_jenisbarang."' and kode_subjenisbarang='".$b->kode_subjenisbarang."'");
				}
			}
			$this->db->query("DELETE FROM t_permintaan_barang WHERE id_permintaan = '".$uri4."'");
			redirect('adm/kelola_permintaan_barang/');
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "not_tampil") {
			$this->db->query("UPDATE t_permintaan_barang SET is_tampil='2' WHERE id_permintaan = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "update sukses";
			$this->j($ret_arr);
			exit();
		} else if ($uri3 == "ambil_barang") {
			$barang = $this->db->query("SELECT t_permintaan_barang.*,m_barang.nama_barang,
										(SELECT COUNT(id) FROM t_permintaan_barang WHERE id_permintaan = '$uri4') AS ok
										FROM t_permintaan_barang left join m_barang on t_permintaan_barang.kode_jenisbarang=m_barang.kode_jenisbarang and t_permintaan_barang.kode_subjenisbarang=m_barang.kode_subjenisbarang WHERE id_permintaan = '$uri4'
										")->result();

			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $barang;
			$this->j($ret_arr);
			exit;
		}else if ($uri3 == "serahkan_barang") {
			$today=date("Y-m-d H:i:s");
			$id_permintaan = addslashes($this->input->post('id_permintaan'));
			$nip_pegawai_menyerahkan = $this->session->userdata('admin_nip');
			$barang_diserahkan = $this->input->post('id_list');
			$nama = isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah = isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			
			foreach ($barang_diserahkan as $key => $n) {
				$a					= 	$barang_diserahkan[$key];
				$kodebarang			=	$nama[$key];
				$jumlahbarang		=	$jumlah[$key];
				$kode_jenisbarang	= 	substr($kodebarang,0,10);
				$kode_subjenisbarang = 	substr($kodebarang,11,6);
				
				$query_tgl_diserahkan=$this->db->query("select nip_pegawai_menyerahkan, tgl_diserahkan from t_permintaan_barang where id='$a'")->row();
				$tgl_diserahkan_terisi=$query_tgl_diserahkan->tgl_diserahkan;
				$nip_pegawai_menyerahkan_terisi = $query_tgl_diserahkan->nip_pegawai_menyerahkan;

				if($nip_pegawai_menyerahkan_terisi == '')
				{
				$this->db->query("UPDATE t_permintaan_barang set tgl_diserahkan='$today', nip_pegawai_menyerahkan='$nip_pegawai_menyerahkan' where id='$a'");
				$this->db->query("UPDATE m_barang set stok_barang=stok_barang-'$jumlahbarang' where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang';");
				$query_stok=$this->db->query("select * from m_barang where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'")->row();
				$stok_barang_update=$query_stok->stok_barang;
				$this->db->query("insert into t_stok_permintaan VALUES (null,'$id_permintaan','$kode_jenisbarang','$kode_subjenisbarang','$stok_barang_update')");
				}
			}
			redirect('adm/kelola_permintaan_barang/');
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= " sukses";
			$this->j($ret_arr);
			exit();
		}else if ($uri3 == "ambil_data_edit") {
			$barang = $this->db->query("SELECT t_permintaan_barang.*,m_barang.nama_barang,m_barang.satuan,
										(SELECT COUNT(id) FROM t_permintaan_barang WHERE id_permintaan = '$uri4') AS ok
										FROM t_permintaan_barang left join m_barang on t_permintaan_barang.kode_jenisbarang=m_barang.kode_jenisbarang and t_permintaan_barang.kode_subjenisbarang=m_barang.kode_subjenisbarang WHERE id_permintaan = '$uri4'
										")->result();

			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $barang;
			$this->j($ret_arr);
			exit;
		}else if ($uri3 == "ambil_master_barang") {
			$barang = $this->db->query("SELECT * from m_barang")->result();
			$ret_arr['status'] = "ok";
			$ret_arr['data'] = $barang;
			$this->j($ret_arr);
			exit;
		}else if ($uri3 == "hapus_barang") {
			$this->db->query("DELETE FROM t_permintaan_barang WHERE id = '".$uri4."'");
			$ret_arr['status'] 	= "ok";
				if ($this->session->userdata('admin_level') != 'user')
				{
				$ret_arr['level'] 	= "notuser";
				}
				else
				{
				$ret_arr['level'] 	= "user";
				}
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		}else if ($uri3 == "edit_permintaan") {
			$today=date("Y-m-d");
			$id_permintaan 			= addslashes($this->input->post('id_permintaan'));
			//$id = addslashes($this->input->post('id'));
			$nama 					= isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah					= isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$query_nip_mengajukan	= $this->db->query("SELECT * from t_permintaan_barang where id_permintaan ='$id_permintaan'  LIMIT 1")->row();
			$nip_mengajukan 		= $query_nip_mengajukan->nip_pegawai;
			$nip_pengajuan = $this->session->userdata('admin_nip');
			echo implode(',',$nama);
							//        masukkan nama barang
							$outofstock=0;
							$nama_barang_habis='';
							foreach ($nama as $key => $n) 
							{
								//$key=$i;
								$kodebarang=$nama[$key];
								$jumlahbarang=$jumlah[$key];
								$kode_jenisbarang = substr($kodebarang,0,10);
								$kode_subjenisbarang = substr($kodebarang,11,6);
							
								$stok_barang_sekarang = $this->db->query ("SELECT stok_barang,nama_barang from m_barang where kode_jenisbarang='$kode_jenisbarang' AND kode_subjenisbarang='$kode_subjenisbarang'")->row();
								if($stok_barang_sekarang->stok_barang < $jumlahbarang )
								{
									$outofstock=$outofstock+1;
									$nama_barang_habis=$stok_barang_sekarang->nama_barang;
								}
								else
								{
									$outofstock=$outofstock;
								}
							}
							
							if($outofstock == 0)
							{
								foreach ($nama as $key => $n) 
								{
									//$key=$i;
									$kodebarang=$nama[$key];
									$jumlahbarang=$jumlah[$key];
									$kode_jenisbarang = substr($kodebarang,0,10);
									$kode_subjenisbarang = substr($kodebarang,11,6);
								
									$cek_sudah_ada = $this->db->query("SELECT kode_jenisbarang,kode_subjenisbarang FROM t_permintaan_barang WHERE  id_permintaan='$id_permintaan' and kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'")->num_rows();
										if ($cek_sudah_ada < 1) 
										{	
										$this->db->query("INSERT INTO t_permintaan_barang VALUES (null,'$id_permintaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$jumlahbarang','','','$today','1','')");
										}
										else 
										{
										$this->db->query("UPDATE t_permintaan_barang SET jumlah_permintaan='$jumlahbarang' where id_permintaan='$id_permintaan' and kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'");
										}
								}
							}
							else
							{
								$this->session->set_flashdata("k", "<div class=\"alert alert-danger\" id=\"alert\">Jumlah ".$nama_barang_habis." Yang Diminta Melebihi Stok Yang Tersedia</div>");	
								redirect('adm/permintaan_barang/');	
							}
			
			//        redirect
			if ($this->session->userdata('admin_level') != 'user')
			{
			redirect('adm/kelola_permintaan_barang/');
			}
			else
			{
			redirect('adm/permintaan_barang/');	
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		}else if ($uri3 == "edit_permintaan_admin") {
			$today=date("Y-m-d");
			$id_permintaan 			= addslashes($this->input->post('id_permintaan'));
			//$id = addslashes($this->input->post('id'));
			$nama 					= isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah					= isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$catatan				= isset($_POST['catatan_input']) ? $_POST['catatan_input'] : array();
			$query_nip_mengajukan	= $this->db->query("SELECT * from t_permintaan_barang where id_permintaan ='$id_permintaan'  LIMIT 1")->row();
			$nip_mengajukan 		= $query_nip_mengajukan->nip_pegawai;
			$nip_pengajuan = $this->session->userdata('admin_nip');
			echo implode(',',$nama);
							//        masukkan nama barang
							foreach ($nama as $key => $n) {
								//$key=$i;
								$kodebarang=$nama[$key];
								$jumlahbarang=$jumlah[$key];
								$kode_jenisbarang = substr($kodebarang,0,10);
								$kode_subjenisbarang = substr($kodebarang,11,6);
								$catatanku=$catatan[$key];
								
								$this->db->query("UPDATE t_permintaan_barang SET jumlah_permintaan='$jumlahbarang' , catatan= '$catatanku' where id_permintaan='$id_permintaan' and kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'");

							$i++;
							}
					
			//        redirect
			if ($this->session->userdata('admin_level') != 'user')
			{
			redirect('adm/kelola_permintaan_barang/');
			}
			else
			{
			redirect('adm/permintaan_barang/');	
			}
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= $ket." sukses";
			$this->j($ret_arr);
			exit();
		}else {
			$a['p']	= "m_kelola_permintaan";
		}

		$this->load->view('aaa', $a);
	}
	
	public function laporan(){
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));
		$uri5 = mysql_real_escape_string($this->uri->segment(5));
		$uri6 = mysql_real_escape_string($this->uri->segment(6));
		$kode_jenisbarang_terpilih = substr($uri6,0,10);
		$kode_subjenisbarang_terpilih = substr($uri6,11,6);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();
		
		
		if($uri5 == '01')
		{
		if ($uri6 == 'semua')
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) <> '05'")->result();
		}
		else
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) <> '05' and kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->result();	
		}
		}
		else if($uri5 == '02')
		{
		if ($uri6 == 'semua')
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) = '05'")->result();
		}
		else
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) = '05' and kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->result();	
		}
		}
		$a['p']	= "v_laporan";
		$this->load->view('aaa', $a);
		
	}
	
	public function cetaklaporan()
	{
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));
		$uri5 = mysql_real_escape_string($this->uri->segment(5));
		$uri6 = mysql_real_escape_string($this->uri->segment(6));
		$kode_jenisbarang_terpilih = substr($uri6,0,10);
		$kode_subjenisbarang_terpilih = substr($uri6,11,6);
		
		if($uri5 == '01')
		{
		if ($uri6 == 'semua')
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) <> '05'")->result();
		}
		else
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) <> '05' and kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->result();	
		}
		}
		else if($uri5 == '02')
		{
		if ($uri6 == 'semua')
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) = '05'")->result();
		}
		else
		{
		$a['datalistatk']=$this->db->query("select * from m_barang where substring(kode_jenisbarang,6,2) = '05' and kode_jenisbarang='$kode_jenisbarang_terpilih' and kode_subjenisbarang='$kode_subjenisbarang_terpilih'")->result();	
		}
		}
		$this->load->view("v_cetak_laporan", $a);
	}
	
	public function laporan_kumulatif(){
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));
		$uri5 = mysql_real_escape_string($this->uri->segment(5));
		$uri6 = mysql_real_escape_string($this->uri->segment(6));
		$kode_jenisbarang_terpilih = substr($uri6,0,10);
		$kode_subjenisbarang_terpilih = substr($uri6,11,6);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();
		
		
		if($uri5 == '01')
		{
		if ($uri6 == 'semua')
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) <> '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2)<> '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		}
		else
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) <> '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) <> '05' and t.nip_pegawai_menyerahkan <> '' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih')
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang ")->result();
		
		}
		}
		else if($uri5 == '02')
		{
		if ($uri6 == 'semua')
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) = '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2) = '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();	

		}
		else
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) = '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2) = '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih')
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang ")->result();
			
		}
		}
		$a['p']	= "v_laporan_kumulatif";
		$this->load->view('aaa', $a);
		
	}
	
	public function cetaklaporankumulatif()
	{
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));
		$uri5 = mysql_real_escape_string($this->uri->segment(5));
		$uri6 = mysql_real_escape_string($this->uri->segment(6));
		$kode_jenisbarang_terpilih = substr($uri6,0,10);
		$kode_subjenisbarang_terpilih = substr($uri6,11,6);
		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();
		
		
		if($uri5 == '01')
		{
		if ($uri6 == 'semua')
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) <> '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2)<> '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		}
		else
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) <> '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2) <> '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih')
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang ")->result();
		
		}
		}
		else if($uri5 == '02')
		{
		if ($uri6 == 'semua')
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) = '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2) = '05') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();	

		}
		else
		{
		$a['datarekapmasuk']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(n.jumlah_penerimaan) as jmlh_masuk from m_barang b left join t_penerimaan_barang n on n.kode_jenisbarang=b.kode_jenisbarang and n.kode_subjenisbarang=b.kode_subjenisbarang 
		where (substring(n.tgl_diterima,1,10) >= '$uri3' and substring(n.tgl_diterima,1,10) <= '$uri4' and substring(b.kode_jenisbarang,6,2) = '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih') 
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang")->result();
		
		$a['datarekapkeluar']=$this->db->query("select b.kode_jenisbarang, b.kode_subjenisbarang, b.nama_barang, sum(t.jumlah_permintaan) as jmlh_keluar from m_barang b left join t_permintaan_barang t on t.kode_jenisbarang=b.kode_jenisbarang and t.kode_subjenisbarang=b.kode_subjenisbarang
		where (substring(t.tgl_permintaan,1,10) >= '$uri3' and substring(t.tgl_permintaan,1,10) <= '$uri4' and t.nip_pegawai_menyerahkan <> '' and substring(b.kode_jenisbarang,6,2) = '05' and b.kode_jenisbarang='$kode_jenisbarang_terpilih' and b.kode_subjenisbarang='$kode_subjenisbarang_terpilih')
		group by b.kode_jenisbarang,b.kode_subjenisbarang order by b.nama_barang ")->result();
			
		}
		}
		$this->load->view("v_cetak_laporan_kumulatif", $a);
	}
	
	//stok barang
	public function stok_barang() {
		$this->cek_aktif();
		
		//var def session
		$a['sess_level'] = $this->session->userdata('admin_level');
		$a['sess_user'] = $this->session->userdata('admin_user');
		$a['sess_nip'] = $this->session->userdata('admin_nip');

		//var def uri segment
		$uri2 = mysql_real_escape_string($this->uri->segment(2));
		$uri3 = mysql_real_escape_string($this->uri->segment(3));
		$uri4 = mysql_real_escape_string($this->uri->segment(4));

		//var post from json
		$p = json_decode(file_get_contents('php://input'));

		//return as json
		$jeson = array();

		$a['data'] = $this->db->query("SELECT t.*,m.nama_barang FROM t_penerimaan_barang t left join m_barang m on t.kode_jenisbarang=m.kode_jenisbarang and t.kode_subjenisbarang=m.kode_subjenisbarang order by t.id asc")->result();

		if ($uri3 == "det") {
			$a = $this->db->query("SELECT t.*,m.nama_barang FROM t_penerimaan_barang t left join m_barang m on t.kode_jenisbarang=m.kode_jenisbarang and t.kode_subjenisbarang=m.kode_subjenisbarang WHERE t.id = '$uri4'")->row();
			$this->j($a);
			exit();
		} else if ($uri3 == "edit_simpan") {
				
				$querystoksekarang 		= mysql_query("select jumlah_penerimaan from t_penerimaan_barang WHERE id = '".bersih($p,"id")."'");
				$datastoksekarang 		= mysql_fetch_array($querystoksekarang);
				$stoksekarang			= $datastoksekarang['jumlah_penerimaan'];
			
				$this->db->query("UPDATE t_penerimaan_barang SET tgl_dokumen = '".bersih($p,"tgl_dokumen")."', jumlah_penerimaan = '".bersih($p,"jumlah_penerimaan")."', sumber_penerimaan = '".bersih($p,"sumber_penerimaan")."', nilai_penerimaan = '".bersih($p,"nilai_penerimaan")."' WHERE id = '".bersih($p,"id")."'");
				
				$this->db->query("UPDATE m_barang SET stok_barang=stok_barang-'$stoksekarang'+'".bersih($p,"jumlah_penerimaan")."' WHERE kode_jenisbarang = '".bersih($p,"kode_jenisbarang")."' and kode_subjenisbarang  = '".bersih($p,"kode_subjenisbarang")."'");
				
				$this->db->query("UPDATE t_stok_penerimaan SET nilai_stok = nilai_stok-'$stoksekarang'+'".bersih($p,"jumlah_penerimaan")."' WHERE id_penerimaan='".bersih($p,"id_penerimaan")."'  and kode_jenisbarang = '".bersih($p,"kode_jenisbarang")."' and kode_subjenisbarang  = '".bersih($p,"kode_subjenisbarang")."'");

			redirect('adm/stok_barang/');
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= " sukses";
			$this->j($ret_arr);
			exit();
			
		} else if ($uri3 == "tambah_stok") {
			$today=date("Y-m-d H:i:s");
			$id_penerimaan = addslashes($this->input->post('id_penerimaan'));
			$id = addslashes($this->input->post('id'));
			$nama = isset($_POST['nama_input']) ? $_POST['nama_input'] : array();
			$jumlah = isset($_POST['jumlah_input']) ? $_POST['jumlah_input'] : array();
			$sumber = isset($_POST['sumber_input']) ? $_POST['sumber_input'] : array();
			$nilai = isset($_POST['nilai_input']) ? $_POST['nilai_input'] : array();
			$tgl = isset($_POST['tgl_diterima']) ? $_POST['tgl_diterima'] : array();
			
			$nip_pengajuan = $this->session->userdata('admin_nip');
					
			//        masukkan nama barang
					$i=1;
					foreach ($nama as $key => $n) {
						$key=$i;
						$kodebarang=$nama[$key];
						$jumlahbarang=$jumlah[$key];
						$sumber_input=$sumber[$key];
						$nilai_input=$nilai[$key];
						$tgl_diterima=$tgl[$key];
												
						$kode_jenisbarang = substr($kodebarang,0,10);
						$kode_subjenisbarang = substr($kodebarang,11,6);
						$this->db->query("INSERT INTO t_penerimaan_barang VALUES (null,'$id_penerimaan','$nip_pengajuan','$kode_jenisbarang','$kode_subjenisbarang','$today','$tgl_diterima','$jumlahbarang','$sumber_input','$nilai_input')");
						$this->db->query("UPDATE m_barang set stok_barang=stok_barang+'$jumlahbarang' where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang';");
						$query_stok=$this->db->query("select * from m_barang where kode_jenisbarang='$kode_jenisbarang' and kode_subjenisbarang='$kode_subjenisbarang'")->row();
						$stok_barang=$query_stok->stok_barang;
						$this->db->query("insert into t_stok_penerimaan VALUES  (null,'$id_penerimaan','$kode_jenisbarang','$kode_subjenisbarang','$stok_barang')");
						$i++;
					}
			//        redirect
			redirect('adm/stok_barang/');
			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "sukses";
			$this->j($ret_arr);
			exit();
		}else if ($uri3 == "hapus") {
			$querystoksekarang 					= mysql_query("select * from t_penerimaan_barang WHERE id = '".$uri4."'");
			$datastoksekarang 					= mysql_fetch_array($querystoksekarang);
			$stoksekarang						= $datastoksekarang['jumlah_penerimaan'];
			$id_penerimaansekarang				= $datastoksekarang['id_penerimaan'];
			$kode_jenisbarangsekarang			= $datastoksekarang['kode_jenisbarang'];
			$kode_subjenisbarangsekarang		= $datastoksekarang['kode_subjenisbarang'];
			
			$this->db->query("DELETE FROM t_penerimaan_barang WHERE id = '".$uri4."'");
			$this->db->query("UPDATE m_barang SET stok_barang=stok_barang-'$stoksekarang' WHERE kode_jenisbarang = '$kode_jenisbarangsekarang' and kode_subjenisbarang  = '$kode_subjenisbarangsekarang'");
			$this->db->query("DELETE FROM t_stok_penerimaan WHERE id_penerimaan='$id_penerimaansekarang' AND kode_jenisbarang='$kode_jenisbarangsekarang' AND kode_subjenisbarangsekarang='$kode_subjenisbarangsekarang'");

			$ret_arr['status'] 	= "ok";
			$ret_arr['caption']	= "hapus sukses";
			$this->j($ret_arr);
			exit();
		}else {
			$a['p']	= "v_stok_barang";
		}

		$this->load->view('aaa', $a);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */