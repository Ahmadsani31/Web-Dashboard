<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/JWK.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth_model extends CI_Model
{
    private $secret_key = "3101199602";

    public function __construct()
    {
        parent::__construct();
    }


    // Method to generate JWT token
    public function generate_jwt($user_data)
    {
        $secret_key = "3101199602";

        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // jwt valid for 1 hour from the issued time
        $payload = array(
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "sub" => $user_data->EmployeeID,
            "email" => $user_data->EmployeeEmail
        );

        return JWT::encode($payload, $secret_key, 'HS256');
    }

    public function validate_token()
    {
        $headers = $this->input->request_headers();

        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $token = $arr[1];
            try {
                $decoded = JWT::decode($token, new Key($this->secret_key, 'HS256'));


                if (isset($decoded->exp) && $decoded->exp < time()) {
                    // Token expired
                    return [
                        'status' => false,
                        'message' => 'Token is expired.'
                    ];
                } else {
                    return [
                        'status' => true,
                        'message' => 'successfully',
                        'items' => (object) $decoded
                    ];
                }
            } catch (Exception $e) {
                return [
                    'status' => false,
                    'message' => $e->getMessage()
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'Token is missing.'
            ];
        }
    }
}


/* End of file Auth_model.php and path \application\models\Auth_model.php */
