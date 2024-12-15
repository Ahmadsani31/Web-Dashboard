<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Required Files
 * 
 * application/language/english/rest_controller_lang.php
 * https://gist.githubusercontent.com/SyedMuradAliShah/c2b4003128f8ec263a7253efda29f29f/raw/edfd1f9e13504a837095a5e57aa8489ab29667ad/rest_controller_lang.php
 * 
 * application/libraries/REST_Controller.php
 * https://gist.githubusercontent.com/SyedMuradAliShah/c2b4003128f8ec263a7253efda29f29f/raw/edfd1f9e13504a837095a5e57aa8489ab29667ad/REST_Controller.php
 * 
 * application/libraries/Format.php
 * https://gist.githubusercontent.com/SyedMuradAliShah/c2b4003128f8ec263a7253efda29f29f/raw/edfd1f9e13504a837095a5e57aa8489ab29667ad/Format.php
 * 
 * application/config/rest.php
 * https://gist.githubusercontent.com/SyedMuradAliShah/c2b4003128f8ec263a7253efda29f29f/raw/edfd1f9e13504a837095a5e57aa8489ab29667ad/rest.php
 * 
 * 
 * PLEASE NOTE
 * Alway declear request method name with the function.
 * 
 * For example
 * If you want to get access login/login_get with GET then simply go for login/login.
 * If you used POST method it will access login_post.
 * 
 * In case you want to define your own then use methodname_requestmethod i.e login_career_post
 * 
 * Default is index so you don't need to define the function name in your uri just change the
 * request method name.
 * 
 * In below case GET example.com/login/1 it will call index_get.  
 * Also if PUT example.com/login/1 it will call index_put.
 * 
 */

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_model', 'Employee');
        $this->load->model('Auth_model', 'Auth');
    }


    public function index_post()
    {
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $input = $this->input->post();

            $param = $this->Employee->login($input['email'], $input['password']);

            if ($param == false) {
                $this->response([
                    'status' => false,
                    'message' => 'User not found.',
                ], RestController::HTTP_BAD_REQUEST);
            } else {
                $token = $this->Auth->generate_jwt($param);

                $this->response([
                    'status' => true,
                    'message' => 'successfully',
                    'token' => $token
                ], RestController::HTTP_OK);
            }
        } else {
            $errors = $this->form_validation->error_array();
            $this->response([
                'status' => false,
                'message' => 'Validation Failed',
                'items' => $errors
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}

/* End of file Login.php and path \application\controllers\api\Login.php */
