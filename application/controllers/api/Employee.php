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
 * If you want to get access employee/employee_get with GET then simply go for employee/employee.
 * If you used POST method it will access employee_post.
 * 
 * In case you want to define your own then use methodname_requestmethod i.e employee_career_post
 * 
 * Default is index so you don't need to define the function name in your uri just change the
 * request method name.
 * 
 * In below case GET example.com/employee/1 it will call index_get.  
 * Also if PUT example.com/employee/1 it will call index_put.
 * 
 */

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;


class Employee extends RestController
{
    private $user_id;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'Auth');
        $param =  $this->Auth->validate_token();
        if ($param['status'] == false) {
            $this->response([
                'status' => false,
                'message' => $param['message']
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            $this->user_id = $param['items']->sub;
        }
    }


    /**
     * Get All Data from this method.
     *
     * @return Response
     */
    public function index_get()
    {
        try {
            $data = $this->db->get_where("employee", ['EmployeeID' => $this->user_id])->row_array();

            $this->response([
                'status' => true,
                'message' => 'successfully',
                'items' => $data
            ], RestController::HTTP_OK);
        } catch (\Throwable $err) {

            $this->response([
                'status' => true,
                'message' => $err->getMessage()
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}

/* End of file Employee.php and path \application\controllers\api\Employee.php */
