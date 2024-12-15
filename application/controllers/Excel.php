<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('v_excel');
    }

    public function import()
    {

        $path         = 'assets/documents/';
        $this->upload_config($path);
        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            return  redirect(base_url('excel'));
        } else {
            $file_data     = $this->upload->data();
            $file_name     = $path . $file_data['file_name'];
            $arr_file     = explode('.', $file_name);
            $extension     = end($arr_file);
            if ('csv' == $extension) {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader     = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet     = $reader->load($file_name);
            $sheet_data     = $spreadsheet->getActiveSheet()->toArray();
            $list             = [];
            foreach ($sheet_data as $key => $val) {
                if ($key != 0 && $val[1] != '') {

                    $EmployeeID[] = $val[1];
                    $ClientID[] = $val[9];

                    $Employee[] = [
                        'EmployeeID'                    => $val[1],
                        'EmployeeName'            => $val[2],
                        'EmployeeEmail'                => $val[3],
                        'EmployeePhone'                    => $val[4],
                        'Office'                    => $val[5],
                        'OrderDate'                    => $val[6],
                        'OrderItem'                    => $val[7],
                        'OrderAmount'                    => $val[8],
                        'ClientID'                    => $val[9],
                        'ClientName'                    => $val[10],
                        'ClientEmail'                    => $val[11],
                        'ClientPhone'                    => $val[12],

                    ];
                }
            }

            $ArrEmployee =  $this->unique_multidimensional_array($Employee, 'EmployeeID');

            $ArrClient =  $this->unique_multidimensional_array($Employee, 'ClientID');
            foreach ($ArrEmployee as $nEmploye) {
                $newEmploye[] = [
                    'EmployeeID'      => $nEmploye['EmployeeID'],
                    'EmployeeName'    => $nEmploye['EmployeeName'],
                    'EmployeeEmail'   => $nEmploye['EmployeeEmail'],
                    'EmployeePhone'   => $nEmploye['EmployeePhone'],
                    'Office'          => $nEmploye['Office'],
                ];
            }
            array_multisort(array_column($newEmploye, 'EmployeeID'), SORT_ASC, $newEmploye);
            $this->db->insert_batch('employee', $newEmploye);

            foreach ($ArrClient as $nClient) {
                $newClient[] = [
                    'ClientID'      => $nClient['ClientID'],
                    'ClientName'    => $nClient['ClientName'],
                    'ClientEmail'   => $nClient['ClientEmail'],
                    'ClientPhone'   => $nClient['ClientPhone'],
                ];
            }
            array_multisort(array_column($newClient, 'ClientID'), SORT_ASC, $newClient);

            $this->db->insert_batch('client', $newClient);


            foreach ($Employee as $employ) {

                $newOrder[] = [
                    'EmployeeID' => $employ['EmployeeID'],
                    'ClientID' => $employ['ClientID'],
                    'OrderDate' => $employ['OrderDate'],
                    'OrderItem' => $employ['OrderItem'],
                    'OrderAmount' => $employ['OrderAmount'],
                ];
            }

            $this->db->insert_batch('order', $newOrder);

            $this->session->set_flashdata('success', 'All Entries are imported successfully.');
            return redirect(base_url('excel'));
        }
    }

    public function upload_config($path)
    {
        if (!is_dir($path))
            mkdir($path, 0777, TRUE);
        $config['upload_path']         = './' . $path;
        $config['allowed_types']     = 'csv|CSV|xlsx|XLSX|xls|XLS';
        $config['max_filename']         = '255';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = 4096;
        $this->load->library('upload', $config);
    }

    function unique_multidimensional_array($array, $key)
    {
        $temp_array = [];
        $key_array = [];

        foreach ($array as $val) {
            $val_key = $val[$key];
            if (!in_array($val_key, $key_array)) {
                $key_array[] = $val_key;
                $temp_array[] = $val;
            }
        }

        return $temp_array;
    }
}

/* End of file Excel.php and path \application\controllers\Excel.php */
