<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

    public $table = 'dash_user';

    function __construct()
    {
        parent::__construct();
        $this->db = $this->load->database('default',true);
    }

        function get_by_nip_lama($nip_lama)
        {
            $this->db->where('nip_lama', $nip_lama);
            return $this->db->get($this->table)->row();
        }

        function login($user, $pass)
        {
            $this->db->where('user', $user);
            $user = $this->db->get($this->table)->row();
            if($user && $user->hash==sha1($pass)){
                $this->db->where('id', $user->id);
                $this->db->update($this->table,array('last_login'=>date('Y-m-d H:i:s')));
                return $user;
            }elseif($user && password_verify($pass, $user->hash)){
                return $user;
            } 
        }

        function get_all($where=null)
        {
            if($where)
                $this->db->where($where);
            $this->db->order_by('id_wilayah, nama','asc');
            return $this->db->get($this->table)->result();
        }

        function get_by_field($field,$value)
        {
            $this->db->where($field, $value);
            return $this->db->get($this->table)->result();
        }
         
        function query($sql)
        {
            return $this->db->query($sql)->result();
        }
         
        function exec($sql)
        {
            return $this->db->query($sql);
        }
         
        function blank()
        {
            return (object)array(
                'nama'=>null,
                'nip_lama'=>null,
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

        function get_kepala($kab)
        {
            $this->db->where('id_unitkerja','9280','and');
            $this->db->where('id_wilayah',$kab,'and');
            $this->db->where('id_eselon','3');           
            return $this->db->get($this->table)->row();
        }

        function get_kasisos($kab)
        {
            $this->db->where('id_unitkerja','9282','and');
            $this->db->where('id_wilayah',$kab,'and');
            $this->db->where('id_eselon','4');           
            return $this->db->get($this->table)->row();
        }

}