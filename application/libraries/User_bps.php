<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_bps
{
    public function __construct()
    {
		require_once APPPATH.'third_party/UserBPS/UserBPS.php';
    }
}