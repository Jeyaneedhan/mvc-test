<?php
class M_Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Register regular user (tenant, landlord, admin)
    public function register($data)
    {
        $this->db->query('INSERT INTO Users(name, email, password, user_type) VALUES (:name, :email, :password, :user_type)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':user_type', $data['user_type']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Register Property Manager with employee ID
    public function registerPM($data)
    {
        $this->db->query('INSERT INTO Users(name, email, password, user_type, employee_id_document, 
                         employee_id_filename, employee_id_filetype, employee_id_filesize, account_status) 
                         VALUES (:name, :email, :password, :user_type, :employee_id_document, 
                         :employee_id_filename, :employee_id_filetype, :employee_id_filesize, :status)');

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':user_type', $data['user_type']);
        $this->db->bind(':employee_id_document', $data['employee_id_data']);
        $this->db->bind(':employee_id_filename', $data['employee_id_filename']);
        $this->db->bind(':employee_id_filetype', $data['employee_id_filetype']);
        $this->db->bind(':employee_id_filesize', $data['employee_id_filesize']);
        $this->db->bind(':status', 'pending'); // PM accounts need approval

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM Users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if ($this->db->rowcount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Login user
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM Users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if (!$row) {
            return false; // User not found
        }

        $hashed_password = $row->password;

        if (password_verify($password, $hashed_password)) {
            // Check if PM account is approved
            if ($row->user_type === 'property_manager') {
                if (!isset($row->account_status)) {
                    return false; // No account status set
                }
                if ($row->account_status === 'pending') {
                    // Return special code for pending account
                    return 'pending';
                }
                if ($row->account_status === 'rejected') {
                    // Return special code for rejected account
                    return 'rejected';
                }
                if ($row->account_status !== 'approved') {
                    return false; // Some other status
                }
            }
            return $row; // Login successful
        } else {
            return false; // Wrong password
        }
    }

    // Get pending Property Managers for admin approval
    public function getPendingPMs()
    {
        $this->db->query('SELECT id, name, email, employee_id_filename, employee_id_filetype, 
                         employee_id_filesize, created_at 
                         FROM Users 
                         WHERE user_type = :user_type AND account_status = :status 
                         ORDER BY created_at DESC');
        $this->db->bind(':user_type', 'property_manager');
        $this->db->bind(':status', 'pending');

        return $this->db->resultSet();
    }

    // Get employee ID document by user ID
    public function getEmployeeIdDocument($userId)
    {
        $this->db->query('SELECT employee_id_document, employee_id_filename, employee_id_filetype 
                         FROM Users 
                         WHERE id = :id');
        $this->db->bind(':id', $userId);

        return $this->db->single();
    }

    // Approve Property Manager account
    public function approvePM($userId)
    {
        $this->db->query('UPDATE Users 
                      SET account_status = :status, 
                          verified_at = NOW() 
                      WHERE id = :id');
        $this->db->bind(':status', 'approved');
        $this->db->bind(':id', $userId);

        return $this->db->execute();
    }

    // Get managers by status
    public function getManagersByStatus($status)
    {
        $this->db->query('SELECT id, name, email, employee_id_filename, created_at 
                      FROM Users 
                      WHERE user_type = :user_type AND account_status = :status 
                      ORDER BY created_at DESC');
        $this->db->bind(':user_type', 'property_manager');
        $this->db->bind(':status', $status);

        return $this->db->resultSet();
    }

    // Get manager counts
    public function getManagerCounts()
    {
        $this->db->query('SELECT 
                         COUNT(*) as total,
                         SUM(CASE WHEN account_status = "pending" THEN 1 ELSE 0 END) as pending,
                         SUM(CASE WHEN account_status = "approved" THEN 1 ELSE 0 END) as approved,
                         SUM(CASE WHEN account_status = "rejected" THEN 1 ELSE 0 END) as rejected
                         FROM Users 
                         WHERE user_type = :user_type');
        $this->db->bind(':user_type', 'property_manager');

        return $this->db->single();
    }

    // Reject Property Manager account
    public function rejectPM($userId, $adminId)
    {
        $this->db->query('UPDATE Users 
                         SET account_status = :status, 
                             verified_at = NOW(), 
                             verified_by = :admin_id 
                         WHERE id = :id');
        $this->db->bind(':status', 'rejected');
        $this->db->bind(':admin_id', $adminId);
        $this->db->bind(':id', $userId);

        return $this->db->execute();
    }
}
