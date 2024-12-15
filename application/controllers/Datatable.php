<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';
require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;
use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Datatable extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $tanggal = $this->input->get('tanggal', true);

        $datatables = new Datatables(new CodeigniterAdapter);

        $where = '';
        if ($tanggal != '') {
            $tgl = explode(' - ', trim($tanggal));
            $where = ' WHERE `order`.OrderDate BETWEEN "' . $tgl[0] . '" AND "' . $tgl[1] . '"';
        }

        $datatables->query('SELECT employee.EmployeeID,employee.EmployeeName,employee.EmployeeEmail,employee.EmployeePhone,employee.Office,`order`.OrderDate,`order`.OrderItem,`order`.OrderAmount,client.ClientID,client.ClientName,client.ClientEmail,client.ClientPhone
                        FROM `order`
                        JOIN employee ON employee.EmployeeID = `order`.EmployeeID 
                        JOIN client ON client.ClientID = `order`.ClientID
                        ' . $where . '
                        ORDER BY `order`.OrderItem,`order`.OrderDate,client.ClientID');
        echo $datatables->generate();
    }
}

/* End of file Datatable.php and path \application\controllers\Datatable.php */
