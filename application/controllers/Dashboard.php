<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('v_dashboard');
    }

    public function sales_performance()
    {

        $queryEmploye = $this->db->get('employee');
        foreach ($queryEmploye->result_array() as $va) {
            $dEmplye[$va['EmployeeID']] = $va['EmployeeName'];
        }
        $qTgl = $this->db->distinct()->select('MONTH(OrderDate) as OrderDate')->get('order');
        foreach ($qTgl->result_array() as $va) {
            $categories[] = getBulan($va['OrderDate']);
        }


        $tanggal = $this->input->get('orderDate', true);
        $where = '';
        if ($tanggal != '') {
            $tgl = explode(' - ', trim($tanggal));
            $where = ' WHERE a.OrderDate BETWEEN "' . $tgl[0] . '" AND "' . $tgl[1] . '"';
        }

        $query = $this->db->query('SELECT a.EmployeeID,b.EmployeeName,MONTH(a.OrderDate) AS bulan,count(a.OrderID) AS total_penjualan 
                                    FROM `order` AS a JOIN employee AS b ON a.EmployeeID=b.EmployeeID
                                    ' . $where . '
                                    GROUP BY MONTH(a.OrderDate),a.EmployeeID
                                    order BY a.EmployeeID');

        $dJual = [];

        foreach ($query->result_array() as $value) {

            $dJual[$value['EmployeeID']][] = intval($value['total_penjualan']);
        }
        $series = [];
        foreach ($dEmplye as $idEmple => $nmEmple) {
            $series[] = [
                'name' => $nmEmple,
                'data' => $dJual[$idEmple] ?? [0]
            ];
        }

        echo json_encode([
            'series' => $series,
            'categories' => $categories,
        ]);

        // $this->load->view('v_dashboard');
    }

    public function total_order()
    {

        $tanggal = $this->input->get('orderDate', true);


        $this->db->select('count(OrderID) AS total_sales,SUM(OrderAmount) AS total_income');

        if ($tanggal != '') {
            $tgl = explode(' - ', trim($tanggal));
            $where = '`order`.OrderDate BETWEEN "' . $tgl[0] . '" AND "' . $tgl[1] . '"';
            $this->db->where($where);
        }

        $this->db->from('order');
        $query = $this->db->get()->row();

        echo json_encode([
            'totalSales' => $query->total_sales,
            'totalIncome' => $query->total_income,
        ]);
    }
}

/* End of file Dashboard.php and path \application\controllers\Dashboard.php */
