<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Employee_model extends CI_Model
{
    public function login($username, $password)
    {
        $this->db->where('EmployeeEmail', $username);
        $query = $this->db->get('employee');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password, $user->Password)) {
                return $user;
            }
        } else {
            return false;
        }
    }
}


/* End of file Employee_model.php and path \application\models\Employee_model.php */
