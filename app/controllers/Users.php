<?php

class Users extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('M_Users');
    }

    // STEP 1: User type selection page (v_usertype.php)
    public function usertype()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // User selected a type, validate and redirect to step 2
            $user_type = trim($_POST['user_type']);

            if (!empty($user_type) && in_array($user_type, ['admin', 'property_manager', 'tenant', 'landlord'])) {
                // Store user type in session temporarily
                $_SESSION['selected_user_type'] = $user_type;

                // Redirect to PM-specific registration if property_manager
                if ($user_type === 'property_manager') {
                    redirect('Users/register_pm');
                } else {
                    redirect('Users/register');
                }
            } else {
                // Invalid user type, redirect back with error
                $data = ['user_type_err' => 'Please select a valid user type'];
                $this->view('users/v_usertype', $data);
            }
        } else {
            // Show user type selection page (Step 1)
            $data = ['user_type_err' => ''];
            $this->view('users/v_usertype', $data);
        }
    }

    // STEP 2: Regular Registration (for non-PM users)
    public function register()
    {
        // Check if user type is selected (must come from step 1)
        if (!isset($_SESSION['selected_user_type'])) {
            redirect('Users/usertype');
            return;
        }

        // Redirect PM to their specific registration
        if ($_SESSION['selected_user_type'] === 'property_manager') {
            redirect('Users/register_pm');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process registration form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Get user type from session
            $user_type = $_SESSION['selected_user_type'];

            // Input data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => $user_type,
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'user_type_err' => ''
            ];

            // Validate each input
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            } elseif (strlen($data['name']) < 2) {
                $data['name_err'] = 'Name must be at least 2 characters';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registered';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm the password';
            } elseif ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Check if all validations passed
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->register($data)) {
                    unset($_SESSION['selected_user_type']);
                    flash('reg_flash', 'Registration successful! You can now login with your credentials.');
                    redirect('Users/login');
                } else {
                    die('Something went wrong during registration');
                }
            } else {
                $this->view('users/v_register', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => $_SESSION['selected_user_type'],
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'user_type_err' => ''
            ];

            $this->view('users/v_register', $data);
        }
    }

    // STEP 2B: Property Manager Registration (with ID upload)
    public function register_pm()
    {
        // Check if user type is selected and is property_manager
        if (!isset($_SESSION['selected_user_type']) || $_SESSION['selected_user_type'] !== 'property_manager') {
            redirect('Users/usertype');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process PM registration form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Input data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'user_type' => 'property_manager',
                'employee_id_data' => null,
                'employee_id_filename' => '',
                'employee_id_filetype' => '',
                'employee_id_filesize' => 0,
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'employee_id_err' => ''
            ];

            // Validate each input
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter a name';
            } elseif (strlen($data['name']) < 2) {
                $data['name_err'] = 'Name must be at least 2 characters';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter an email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            } else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_err'] = 'Email is already registered';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter a password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm the password';
            } elseif ($data['password'] != $data['confirm_password']) {
                $data['confirm_password_err'] = 'Passwords do not match';
            }

            // Handle file upload - store in database
            if (isset($_FILES['employee_id']) && $_FILES['employee_id']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['employee_id'];
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];
                $max_size = 5 * 1024 * 1024; // 5MB

                if (!in_array($file['type'], $allowed_types)) {
                    $data['employee_id_err'] = 'Only JPG, PNG, and PDF files are allowed';
                } elseif ($file['size'] > $max_size) {
                    $data['employee_id_err'] = 'File size must not exceed 5MB';
                } else {
                    // Read file content into binary data
                    $data['employee_id_data'] = file_get_contents($file['tmp_name']);
                    $data['employee_id_filename'] = $file['name'];
                    $data['employee_id_filetype'] = $file['type'];
                    $data['employee_id_filesize'] = $file['size'];
                }
            } else {
                $data['employee_id_err'] = 'Please upload your employee ID card';
            }

            // Check if all validations passed
            if (
                empty($data['name_err']) && empty($data['email_err']) &&
                empty($data['password_err']) && empty($data['confirm_password_err']) &&
                empty($data['employee_id_err'])
            ) {

                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register PM
                if ($this->userModel->registerPM($data)) {
                    unset($_SESSION['selected_user_type']);
                    flash('reg_flash', 'Registration successful! Your account is pending approval. You will be notified once verified.');
                    redirect('Users/login');
                } else {
                    die('Something went wrong during registration');
                }
            } else {
                $this->view('users/v_register_pm', $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'user_type' => 'property_manager',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'employee_id_err' => ''
            ];

            $this->view('users/v_register_pm', $data);
        }
    }

    // User login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => '',
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = 'Please enter a valid email';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $loggedUser = $this->userModel->login($data['email'], $data['password']);

                    if ($loggedUser) {
                        $this->createUserSession($loggedUser);
                        $this->redirectBasedOnUserType($loggedUser->user_type);
                    } else {
                        $data['password_err'] = 'Password incorrect';
                        $this->view('users/v_login', $data);
                    }
                } else {
                    $data['email_err'] = 'No account found with that email';
                    $this->view('users/v_login', $data);
                }
            } else {
                $this->view('users/v_login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];

            $this->view('users/v_login', $data);
        }
    }

    private function redirectBasedOnUserType($userType)
    {
        switch ($userType) {
            case 'admin':
                redirect('admin/index');
                break;
            case 'property_manager':
                redirect('manager/index');
                break;
            case 'tenant':
                redirect('tenant/index');
                break;
            case 'landlord':
                redirect('landlord/index');
                break;
            default:
                redirect('pages/index');
                break;
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_type'] = $user->user_type;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_type']);
        unset($_SESSION['selected_user_type']);

        session_destroy();
        redirect('Users/login');
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // View employee ID document (for admins)
    public function viewEmployeeId($userId)
    {
        // Check if user is admin
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
            return;
        }

        // Get document from database
        $document = $this->userModel->getEmployeeIdDocument($userId);

        if ($document && $document->employee_id_document) {
            // Set appropriate headers
            header('Content-Type: ' . $document->employee_id_filetype);
            header('Content-Disposition: inline; filename="' . $document->employee_id_filename . '"');
            header('Content-Length: ' . strlen($document->employee_id_document));

            // Output the binary data
            echo $document->employee_id_document;
            exit;
        } else {
            die('Document not found');
        }
    }

    // Download employee ID document (for admins)
    public function downloadEmployeeId($userId)
    {
        // Check if user is admin
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
            redirect('users/login');
            return;
        }

        // Get document from database
        $document = $this->userModel->getEmployeeIdDocument($userId);

        if ($document && $document->employee_id_document) {
            // Set appropriate headers for download
            header('Content-Type: ' . $document->employee_id_filetype);
            header('Content-Disposition: attachment; filename="' . $document->employee_id_filename . '"');
            header('Content-Length: ' . strlen($document->employee_id_document));

            // Output the binary data
            echo $document->employee_id_document;
            exit;
        } else {
            die('Document not found');
        }
    }
}
