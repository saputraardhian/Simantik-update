<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

    public $table = 'dash_pegawai';

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('test',true);
    }

    function login($username, $password)
    {
        $this->db->where('email', $username.'@bps.go.id');
        $row = $this->db->get($this->table)->row();
        if($row && (sha1($row->salt.$password)==$row->hash || hash('sha512', $row->salt.$password)==$row->hash )){
            return $row;
        }
    }

    function set_login($username, $password)
    {
        $this->db->where('email', $username.'@bps.go.id');
        $row = $this->db->get($this->table)->row();
        if($row){
            $salt = sha1(time());
            $hash = sha1($salt.$password);

            $this->db->where('email', $username.'@bps.go.id');
            $this->db->update($this->table, array(
                'salt' => $salt,
                'hash' => $hash,
                'last_login' => time(),
            ));
        }
    }

    function get_by_niplama($nip_lama)
    {
        $this->db->where('niplama', $nip_lama);
        return $this->db->get($this->table)->row();
    }

    function get_all()
    {
        $this->db->order_by('id_wilayah, nama','asc');
        return $this->db->get($this->table)->result();
    }

    function get_by_field($field,$value)
    {
        $this->db->where($field, $value);
        return $this->db->get($this->table)->result();
    }
     
    function get_by($field,$value)
    {
        $this->db->where($field, $value);
        return $this->db->get($this->table);
    }
     
    function get_kepala($wilayah,$unitkerja)
    {
        $this->db->where('id_wilayah', $wilayah, 'and');
        $this->db->where('id_unitkerja', $unitkerja.'0', 'and');
        $this->db->where('left(eselon,6)', 'Eselon');
        return $this->db->get($this->table)->row();
    }
     
    function get_staf($wilayah,$unitkerja)
    {
        $this->db->where('id_wilayah', $wilayah, 'and');
        $this->db->where('id_unitkerja', $unitkerja.'0');
        $this->db->order_by('nama');
        return $this->db->get($this->table)->result();
    }
     
    function blank()
    {
        return (object)array(
            'nama'=>null,
            'nip_lama'=>null,
			'nip_baru'=>null,
            'id_unitkerja'=>null,
            'id_wilayah'=>null,
            'id_level'=>null,
            'user'=>null,
            'pass'=>null
        );
    }

    function insert($data)
    {
        if($this->db->insert($this->table, $data))
            return true;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        if($this->db->update($this->table, $data))
            return true;
    }

    public function search($nip_lama)
    {
//        $nip_lama = $this->uri->segment(3)? $this->uri->segment(3) : null;
        if($nip_lama && strlen($nip_lama)==9){
            $search = self::get_by_niplama($nip_lama);
            if($search){
                return json_encode(array(
                    $search->nama,
                    $search->niplama,
                    $search->nipbaru,
                    $search->id_unitkerja,
                    $search->unitkerja,
                    $search->eselon,
                    $search->id_wilayah,
                    $search->wilayah,
                    $search->status,
                    $search->email,
                    $search->avatar
                ));
            }else{
                $ch = curl_init();

                //Set options for curl session
                $options = array(
                    CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)',
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    //CURLOPT_SSL_VERIFYHOST => 2,
                    CURLOPT_HEADER => TRUE,
                    CURLOPT_RETURNTRANSFER => TRUE, //tidak otomatis menampilkan respon ke webpage
                    CURLOPT_VERBOSE => FALSE,       //mensupport pilihan di atas (tidak otomatis respon ditampilkan)
                    CURLOPT_POST => TRUE,
                    CURLOPT_FOLLOWLOCATION => TRUE,
                    CURLOPT_URL => "https://api.bps.go.id/client/pegawai_data.php"
                );


                $options[CURLOPT_POSTFIELDS] = "jenisinput=niplama&proses=Proses&input=" . $nip_lama;   
                curl_setopt_array($ch, $options);
                $respon = curl_exec($ch);

                if(stripos($respon, 'nama')){
                    $begin = stripos($respon, '<table cellspacing=5');
                    $end = stripos($respon, '</table>', $begin);

                    $result = substr($respon, $begin+35, $end - $begin - 35);
                    $result = str_replace("</tr>", "", $result);
                    $arr = array();

                    foreach(explode("<tr>", $result) as $tr){
                        if($tr <> ""){
                            $tr = str_replace("<td>:</td>", "", $tr);
                            $tr = str_replace("</td>", "", $tr);

                            $td = explode("<td>", $tr);
                            $arr[] = trim($td[2]);
                        }
                    }

                    if(file_get_contents($arr[10])=='404 - Notfound')
                        $arr[10] = substr($arr[10], 0, -4).'.JPG';

                    $this->db->insert($this->table, (array(
                        'nama'=>$arr[0],
                        'niplama'=>$arr[1],
                        'nipbaru'=>$arr[2],
                        'id_unitkerja'=>$arr[3],
                        'unitkerja'=>$arr[4],
                        'eselon'=>$arr[5],
                        'id_wilayah'=>$arr[6],
                        'wilayah'=>$arr[7],
                        'status'=>$arr[8],
                        'email'=>$arr[9],
                        'avatar'=>$arr[10],
                    )));

                    return json_encode($arr);
                }
                curl_close($ch);
            }
        }
    }

}