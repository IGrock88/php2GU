<?php

namespace engine\Controllers;


use engine\Models\AdminModel;
use engine\Views\AdminView;

class AdminController extends Controller
{
    protected $view;
    private $adminModel;

    public function __construct()
    {
        parent::__construct();
        if ($this->content['userRole'] != 2) {
            header("location: /");
        }
        $this->view = new AdminView();
        $this->adminModel = new AdminModel($this->db);
    }

    public function index()
    {
        $this->content['content'] = "templates/admin/indexAdmin.php";
        $this->view->generate($this->content);
    }

    public function orders()
    {
        $this->content['content'] = "templates/admin/orders.php";
        $this->view->generate($this->content);
    }

    public function getOrders()
    {
        $result['orders'] = $this->adminModel->getOrders();
        $result['orders_quantity'] = count($result['orders']);
        echo json_encode($result);
    }

}