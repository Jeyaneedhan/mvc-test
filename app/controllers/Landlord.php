<?php
require_once '../app/helpers/helper.php';

class Landlord extends Controller
{
    private $userModel; // Explicitly define the property
    private $propertyModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
        $this->propertyModel = $this->model('M_Properties');
        // Check if user is logged in and is a landlord
        if (!isLoggedIn() || $_SESSION['user_type'] !== 'landlord') {
            redirect('users/login');
        }
    }

    public function index()
    {
        $this->dashboard();
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Landlord Dashboard',
            'page' => 'dashboard',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_dashboard', $data);
    }

    /* public function properties()
    {
        $data = [
            'title' => 'My Properties',
            'page' => 'properties',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_properties', $data);
    }

    public function add_property()
    {
        $data = [
            'title' => 'Add Property',
            'page' => 'add_property',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_add_property', $data);
    }*/

    public function properties()
    {
        $properties = $this->propertyModel->getPropertiesByLandlord($_SESSION['user_id']);
        $data = [
            'properties' => $properties
        ];
        $this->view('landlord/v_properties', $data);
    }


    public function add_property()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Map pet policy and laundry values to match database ENUM
            $petOptions = ['no', 'cats', 'dogs', 'both'];
            $laundryOptions = ['none', 'shared', 'hookups', 'included'];

            $data = [
                'landlord_id'   => $_SESSION['user_id'],
                'address'       => trim($_POST['address']),
                'property_type' => trim($_POST['type']),
                'bedrooms'      => (int)$_POST['bedrooms'],
                'bathrooms'     => (float)$_POST['bathrooms'],
                'sqft'          => (int)$_POST['sqft'],
                'rent'          => (float)$_POST['rent'],
                'deposit'       => (float)$_POST['deposit'],
                'available_date' => !empty($_POST['available_date']) ? $_POST['available_date'] : null,
                'parking'       => isset($_POST['parking']) && is_numeric($_POST['parking']) ? (int)$_POST['parking'] : 0,
                'pet_policy'    => in_array($_POST['pets'], $petOptions) ? $_POST['pets'] : 'no',
                'laundry'       => in_array($_POST['laundry'], $laundryOptions) ? $_POST['laundry'] : 'none',
                'description'   => trim($_POST['description']),
                'status'        => 'vacant'
            ];

            if ($this->propertyModel->addProperty($data)) {
                flash('property_message', 'Property Added Successfully');
                redirect('landlord/properties');
            } else {
                die('Something went wrong.');
            }
        } else {
            $this->view('landlord/v_add_property');
        }
    }


    public function edit($id)
    {

        $property = $this->propertyModel->getPropertyById($id);

        if (!$property) {
            flash('property_message', 'Property not found');
            redirect('landlord/properties');
        }

        $data = ['property' => $property];

        $this->view('landlord/v_edit_properties', $data);
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            // Ensure only valid ENUM values for pet_policy and laundry
            $validPetPolicies = ['no', 'cats', 'dogs', 'both'];
            $validLaundry = ['none', 'shared', 'hookups', 'included'];

            $data = [
                'id' => $id,
                'address' => trim($_POST['address']),
                'property_type' => trim($_POST['property_type']),
                'bedrooms' => (int)$_POST['bedrooms'],
                'bathrooms' => (float)$_POST['bathrooms'],
                'sqft' => (int)$_POST['sqft'],
                'rent' => (float)$_POST['rent'],
                'deposit' => (float)$_POST['deposit'],
                'available_date' => !empty($_POST['available_date']) ? $_POST['available_date'] : null,
                'parking' => trim($_POST['parking']),
                'pet_policy' => in_array($_POST['pets'] ?? '', $validPetPolicies) ? $_POST['pets'] : 'no',
                'laundry' => in_array($_POST['laundry'] ?? '', $validLaundry) ? $_POST['laundry'] : 'none',
                'description' => trim($_POST['description']),
            ];

            if ($this->propertyModel->update($data)) {
                flash('property_message', 'Property Updated Successfully');
                redirect('landlord/properties');
            } else {
                die('Something went wrong.');
            }
        } else {
            $property = $this->propertyModel->getPropertyById($id);
            if (!$property) {
                flash('property_message', 'Property not found');
                redirect('landlord/properties');
            }
            $data = ['property' => $property];
            $this->view('landlord/v_edit_properties', $data);
        }
    }


    public function delete($id)
    {
        if ($this->propertyModel->deleteProperty($id)) {
            flash('property_message', 'Property removed');
            redirect('landlord/properties');
        } else {
            die('Something went wrong');
        }
    }


    public function maintenance()
    {
        $data = [
            'title' => 'Maintenance Requests',
            'page' => 'maintenance',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_maintenance', $data);
    }

    public function inquiries()
    {
        $data = [
            'title' => 'Tenant Inquiries',
            'page' => 'inquiries',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_inquiries', $data);
    }

    public function payment_history()
    {
        $data = [
            'title' => 'Payment History',
            'page' => 'payment_history',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_payment_history', $data);
    }

    public function feedback()
    {
        $data = [
            'title' => 'Tenant Feedback',
            'page' => 'feedback',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_feedback', $data);
    }

    public function notifications()
    {
        $data = [
            'title' => 'Notifications',
            'page' => 'notifications',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_notifications', $data);
    }

    public function settings()
    {
        $data = [
            'title' => 'Settings',
            'page' => 'settings',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_settings', $data);
    }

    public function income()
    {
        $data = [
            'title' => 'Income Reports',
            'page' => 'income',
            'user_name' => $_SESSION['user_name']
        ];
        $this->view('landlord/v_income', $data);
    }
}
