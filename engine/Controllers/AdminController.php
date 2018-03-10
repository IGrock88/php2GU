<?php

namespace engine\Controllers;


use engine\Models\AdminModel;
use engine\Views\AdminView;
use engine\Views\View;

class AdminController extends Controller
{
    protected $view;
    private $adminModel;
    private $basisTmpl = "adminBase.tmpl";

    public function __construct()
    {
        parent::__construct();
        if ($this->content['user']->getRole() != 2) {
            header("location: /");
        }
        $this->view = new View($this->basisTmpl);
        $this->adminModel = new AdminModel($this->db);
    }

    public function index()
    {
        $this->content['content'] = "admin/indexAdmin.tmpl";
        $this->view->generate($this->content);
    }

    public function orders()
    {
        $this->content['content'] = "admin/orders.tmpl";
        $this->view->generate($this->content);
    }

    public function getOrders()
    {
        $result['orders'] = $this->adminModel->getOrders();
        $result['orders_quantity'] = count($result['orders']);
        echo json_encode($result);
    }

}