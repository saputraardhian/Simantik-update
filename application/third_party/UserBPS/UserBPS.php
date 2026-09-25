<?php
/*
	$user = 'username_pegawai';
	$pass = 'password_community';
	
	$key  = 'key aplikasi yang sudah didaftarkan';

	$akun = new UserBPS();       -> inisiasi class
	$akun->login($user, $pass);  -> proses login dengan username dan password

	$akun->isLogin();   -> menampilkan status login, format boolean
	$akun->getJSON();   -> menampilkan data pegawai, format json
	$akun->getError();  -> menampilkn pesan error jika ada, format string

*/

class UserBPS 
{
	private $ch;
	private $is_login  = FALSE;
	private $error_msg = null;
	private $jsonData  = array();

	function __construct($user=null, $pass=null) 
	{
		$this->ch = curl_init();		
	}

	function __destruct() 
	{
		if($this->ch)
			curl_close($this->ch);
	}

	// menampilkan status login, format boolean
	public function isLogin()
	{
		return $this->is_login;
	}

	// proses login dengan username password
	public function login($username, $password) 
	{
		$options = array(
			CURLOPT_USERAGENT 		=> 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
			CURLOPT_VERBOSE 		=> FALSE,
			CURLOPT_SSL_VERIFYPEER 	=> FALSE,
			//CURLOPT_SSL_VERIFYHOST => 2,
			CURLOPT_HEADER 			=> FALSE,
			CURLOPT_RETURNTRANSFER 	=> TRUE,
			//CURLOPT_COOKIEFILE 		=> '.cookie',
			//CURLOPT_COOKIEJAR 		=> '.cookies',
			CURLOPT_URL				=> 'https://webapps.bps.go.id/jateng/svc/login',
			CURLOPT_POST 			=> TRUE,
			CURLOPT_POSTFIELDS 		=> "username=" . $username ."&password=" . $password
		);

		curl_setopt_array($this->ch, $options);
		$result = json_decode(curl_exec($this->ch), TRUE); 

		if (curl_errno($this->ch)) {
		    $this->error_msg = curl_error($this->ch);
		}

		if(isset($result['username'])){
			$this->is_login = TRUE;
			$this->jsonData = $result;
		}
	}

	// menampilkan data pegawai, format json
	public function getJSON($username=null)
	{
		if($this->is_login) return json_encode($this->jsonData);
	}

	// menampilkan pesan error jika ada, format string
	public function getError()
	{
		return $this->error_msg;
	}
}