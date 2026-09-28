<?php
/**
 * PHP 7/8 Compatibility Layer for legacy ext/mysql functions
 */

if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}

if (!defined('MYSQL_BOTH')) define('MYSQL_BOTH', MYSQLI_BOTH);
if (!defined('MYSQL_NUM'))  define('MYSQL_NUM', MYSQLI_NUM);
if (!defined('MYSQL_ASSOC')) define('MYSQL_ASSOC', MYSQLI_ASSOC);

if (!function_exists('_get_mysql_compat_link')) {
    function _get_mysql_compat_link($link = null) {
        static $default_link = null;
        if ($link instanceof mysqli) {
            return $link;
        }
        if (function_exists('get_instance')) {
            $ci =& get_instance();
            if (isset($ci->db) && isset($ci->db->conn_id) && $ci->db->conn_id instanceof mysqli) {
                return $ci->db->conn_id;
            }
        }
        if ($default_link instanceof mysqli && @mysqli_ping($default_link)) {
            return $default_link;
        }
        $default_link = @mysqli_connect('localhost', 'root', '', 'simantik');
        return $default_link;
    }
}

if (!function_exists('mysql_connect')) {
    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0) {
        return _get_mysql_compat_link();
    }
}

if (!function_exists('mysql_pconnect')) {
    function mysql_pconnect($server = null, $username = null, $password = null, $client_flags = 0) {
        return _get_mysql_compat_link();
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($database_name, $link = null) {
        $conn = _get_mysql_compat_link($link);
        return $conn ? @mysqli_select_db($conn, $database_name) : false;
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link = null) {
        $conn = _get_mysql_compat_link($link);
        if (!$conn) return false;
        return @mysqli_query($conn, $query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result instanceof mysqli_result) return false;
        return mysqli_fetch_array($result, $result_type);
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        if (!$result instanceof mysqli_result) return false;
        return mysqli_fetch_assoc($result);
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($result) {
        if (!$result instanceof mysqli_result) return false;
        return mysqli_fetch_row($result);
    }
}

if (!function_exists('mysql_fetch_object')) {
    function mysql_fetch_object($result, $class_name = "stdClass", ...$params) {
        if (!$result instanceof mysqli_result) return false;
        if (!empty($params)) {
            return mysqli_fetch_object($result, $class_name, $params);
        }
        return mysqli_fetch_object($result, $class_name);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if (!$result instanceof mysqli_result) return false;
        return mysqli_num_rows($result);
    }
}

if (!function_exists('mysql_num_fields')) {
    function mysql_num_fields($result) {
        if (!$result instanceof mysqli_result) return false;
        return mysqli_num_fields($result);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($string, $link = null) {
        if ($string === null) return '';
        $conn = _get_mysql_compat_link($link);
        if ($conn) {
            return mysqli_real_escape_string($conn, (string)$string);
        }
        return addslashes((string)$string);
    }
}

if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        return mysql_real_escape_string($string);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link = null) {
        $conn = _get_mysql_compat_link($link);
        return $conn ? mysqli_error($conn) : '';
    }
}

if (!function_exists('mysql_errno')) {
    function mysql_errno($link = null) {
        $conn = _get_mysql_compat_link($link);
        return $conn ? mysqli_errno($conn) : 0;
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link = null) {
        $conn = _get_mysql_compat_link($link);
        return $conn ? mysqli_insert_id($conn) : 0;
    }
}

if (!function_exists('mysql_affected_rows')) {
    function mysql_affected_rows($link = null) {
        $conn = _get_mysql_compat_link($link);
        return $conn ? mysqli_affected_rows($conn) : 0;
    }
}

if (!function_exists('mysql_free_result')) {
    function mysql_free_result($result) {
        if ($result instanceof mysqli_result) {
            mysqli_free_result($result);
            return true;
        }
        return false;
    }
}

if (!function_exists('mysql_data_seek')) {
    function mysql_data_seek($result, $row_number) {
        if ($result instanceof mysqli_result) {
            return mysqli_data_seek($result, $row_number);
        }
        return false;
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link = null) {
        return true;
    }
}
