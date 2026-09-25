<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        if(!$this->session->has_userdata('username') && ($this->uri->segment(2)!='login' && $this->uri->segment(2)!='login_lama')){
        	$this->session->set_userdata('redirect_url', current_url());
        	redirect('site/login'); 
        }
        $this->load->model('user_model');
        $this->load->model('pegawai_model');

	}

	public function index()
	{	
		$this->load->view('template', array(
			'_view'=>'admin/login',
			'title'=>''
		));
	}

	public function login()
	{
		$error = '';
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		$tahun = $this->input->post('ta');
		
		$data = array();

		if($user && $pass){
			$row = $this->pegawai_model->login($user,$pass);
			if($row){
				$data = array(
					'username'	=> $user,
					'nama'		=> $row->nama,
					'niplama'	=> $row->niplama,
					'id_wilayah'=> $row->id_wilayah,
					'id_unitkerja'=> substr($row->id_unitkerja,0,4),
					'id_level'	=> $row->eselon,
					'src'		=> 'db',
					'tahun'		=> $tahun,
					'admin_valid' => true
				); 
				
			} else {
				
/*				$this->load->library('user_bps');
				$akun = new UserBPS();
				$akun->login($user, $pass);
				if($akun->isLogin()){
					$this->pegawai_model->set_login($user,$pass);
					$userJSON = json_decode($akun->getJSON(), true);

					$userdata = array(
						'username'	=> $user,
						'nama'		=> $userJSON['nama'],
						'niplama'	=> $userJSON['niplama'],
						'is_pegawai'=> true,
						'id_wilayah'=> $userJSON['id_wilayah'],
						'id_unitkerja'=> substr($userJSON['id_unitkerja'],0,4),
						'is_koseka' => false,
						'is_petugas'=> false,
						'nik'		=> '',
					); 
*/

				$this->load->library('user_bps');
				$akun = new UserBPS();
				$akun->login($user, $pass);
				if($akun->isLogin()){
					$this->pegawai_model->set_login($user,$pass);

					$userJSON = json_decode($akun->getJSON(), true); //print_r($userJSON); exit();
					if($userJSON && substr($userJSON['id_wilayah'],0,2)=='33'){
						$data = array(
							'username'	=> $user,
							'nama'		=> $userJSON['nama'],
							'niplama'	=> $userJSON['niplama'],
							'id_wilayah'=> $userJSON['id_wilayah'],
							'id_unitkerja'=> substr($userJSON['id_unitkerja'],0,4),
							'id_level'	=> $userJSON['id_eselon']? 5:1,
							'wfh_admin'	=> $userJSON['id_eselon']? 1:0,
							'src'		=> 'lib',
							'tahun'		=> $tahun,
							'admin_valid' => true
						);
					} else
						$error = 'User tidak terdaftar';
					
				} elseif($akun->getError()) {
					$error = $akun->getError();
				} else {
					$error = 'Username/Password tidak sesuai';
				}
			}
			$this->session->set_userdata($data);
			redirect('index.php/admin');
			//echo $userdata[1];
			if($data) {
				/*if($userdata['id_level']<5){
					$sql = "selectt * from wfh_admin where niplama='".$userdata['niplama']."' and id_wilayah='".$userdata['id_wilayah']."'";
					$this->load->model('wfhpresensi_model');
					if($this->wfhpresensi_model->exec($sql)->row())
						$userdata['wfh_admin'] = 1;
				}*/
				
				//$this->session->set_userdata($userdata);
				//redirect('index.php/admin');
				/*if($this->session->userdata('redirect_url')){
					$sql = "selectt * from wfh_admin where niplama='".$userdata['niplama']."' and id_wilayah='".$userdata['id_wilayah']."'";
					$redirect_url = $this->session->userdata('redirect_url');
					$this->session->set_userdata('redirect_url','');				
					redirect($redirect_url);
				} 
				else {
					$sql = "selecttt * from wfh_admin where niplama='".$userdata['niplama']."' and id_wilayah='".$userdata['id_wilayah']."'";
					redirect('index.php/admin');
				}*/
					//redirect('admin/index');
			}

		} elseif($user || $pass){
			$error = 'Username/Password harus diisi';
		}

		$this->load->view('admin/login', array(
			'username'=>$user,
			'password'=>$pass,
			'error'=>$error,
		));
	}

	public function logout()
	{
		$this->session->set_userdata('username',null);
		$this->session->unset_userdata(array('username'=>''));
		session_destroy();
		redirect('admin/login');
	}

	public function toggle()
	{
		$param = isset($_POST['param'])? $_POST['param'] : '';
		$value = isset($_POST['value'])? $_POST['value'] : '';

		if($param && $value){
			if($param=='sidebar-collapse'){
				$this->session->set_userdata('sidebar-collapse', $value=='true'? '' : 'true');
			}
		}
	}

	public function user()
	{
		$wilayah = $this->uri->segment(3)? $this->uri->segment(3) : null;
		$this->load->model('wilayah_model');
		$this->load->view('template', array(
			'_view'=>'site/user',
			'title'=>'Manajemen Pengguna',
			'wilayah'=>$wilayah,
		));
	}

	public function vpn()
	{
		$this->load->view('template', array(
			'_view'=>'vpn',
			'title'=>'Koneksi VPN',
		));
	}

	public function ping()
	{
		$this->load->library('PingHelper');
		$host = $this->uri->segment(4)? $this->uri->segment(4) : null;
		if($host){
			$ping = new Ping($host);
			echo $ping->ping();
		}
	}

	public function sess()
	{
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}
}
