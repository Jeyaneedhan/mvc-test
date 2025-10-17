<?php
class Inspection extends Controller {
    private $inspectionModel;

    public function __construct() {
        $this->inspectionModel = $this->model('InspectionModel');
    }

    // Show all inspections
    public function index() {
        $inspections = $this->inspectionModel->getInspections();
        $data = [
            'title' => 'Property Inspections',
            'page' => 'inspections',
            'inspections' => $inspections,
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('manager/v_inspections', $data);
    }

    // Add inspection
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'property'  => trim($_POST['property']),
                'type'      => trim($_POST['type']),
                'issues'    => ($_POST['issues'] === '' ? 0 : (int)$_POST['issues']),
                'date'      => trim($_POST['date']),
                // Inspector comes from session (logged-in user)
                'inspector' => $_SESSION['user_name'] 
            ];

            // Attempt to add inspection
            $inserted = $this->inspectionModel->addInspection($data);

            if ($inserted) {
                redirect('inspection/index');
            } else {
                echo '<h3 style="color:red;">Failed to save inspection. Check database connection, table structure, or input values.</h3>';
            }
        } else {
            // GET request → show form
            $data = [
                'title' => 'Schedule Inspection',
                'page'  => 'add_inspection',
                'user_name' => $_SESSION['user_name']
            ];
            $this->view('manager/v_add_inspection', $data);
        }
    }

    // Edit inspection
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'id'        => $id,
                'property'  => trim($_POST['property']),
                'type'      => trim($_POST['type']),
                'inspector' => trim($_POST['inspector']),
                'date'      => trim($_POST['date']),
                'status'    => trim($_POST['status']),
                'issues'    => ($_POST['issues'] === '' ? 0 : (int)$_POST['issues'])
            ];

            $updated = $this->inspectionModel->updateInspection($id, $data);

            if ($updated) {
                redirect('inspection/index');
            } else {
                echo '<h3 style="color:red;">Failed to update inspection. Check database connection, table structure, or input values.</h3>';
            }
        } else {
            $inspection = $this->inspectionModel->getInspectionById($id);
            if (!$inspection) {
                die('Inspection not found');
            }

            $data = [
                'title' => 'Edit Inspection',
                'page'  => 'edit_inspection',
                'inspection' => $inspection,
                'user_name' => $_SESSION['user_name']
            ];
            $this->view('manager/v_edit_inspection', $data);
        }
    }
}
