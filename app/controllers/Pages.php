<?php

class Pages extends Controller
{
    private $pagesModel; // Added -> ERROR: Undefined property '$pagesModel'.intelephense(P1014) 

    public function __construct()
    {
        $this->pagesModel = $this->model('M_Pages');
    }

    public function index()
    {
        $data = [];

        $this->view('pages/v_index', $data);
    }

    public function about()
    {
        $users = $this->pagesModel->getUsers();

        $data = [
            'users' => $users
        ];

        $this->view('v_about', $data);
    }
}
