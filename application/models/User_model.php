<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class User_model extends CI_Model
{


    public function store($data)
    {
        $simpan = $this->db->insert("users", $data);

        if ($simpan) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function login($username, $password)
    {
        $this->db->where('email', $username);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->password)) {
                return $user;
            }
        } else {
            return false;
        }
    }

    public function register($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function check_username_exists($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    public function check_email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}


/* End of file User_model.php and path \application\models\User_model.php */
