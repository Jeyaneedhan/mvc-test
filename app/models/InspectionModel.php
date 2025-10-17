<?php 
class InspectionModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Insert inspection
    public function addInspection($data) {
        try {
            // Insert inspection - inspector is required in DB, so make sure it's passed in controller
            $this->db->query("INSERT INTO inspections (property, `type`, issues, scheduled_date, status, inspector) 
                              VALUES (:property, :type, :issues, :date, 'scheduled', :inspector)");

            // Bind parameters
            $this->db->bind(':property', $data['property']);
            $this->db->bind(':type', $data['type']);
            $this->db->bind(':issues', ($data['issues'] === '' ? 0 : (int)$data['issues']));
            $this->db->bind(':date', $data['date']);
            $this->db->bind(':inspector', $data['inspector']); 

            return $this->db->execute();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Fetch all inspections
    public function getInspections() {
        $this->db->query("SELECT * FROM inspections ORDER BY scheduled_date DESC");
        return $this->db->resultSet();
    }

    // Fetch inspection by ID
    public function getInspectionById($id) {
        $this->db->query("SELECT * FROM inspections WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Update inspection
    public function updateInspection($id, $data) {
        $this->db->query("UPDATE inspections 
                          SET property = :property, 
                              `type` = :type, 
                              inspector = :inspector, 
                              scheduled_date = :date, 
                              status = :status, 
                              issues = :issues 
                          WHERE id = :id");

        $this->db->bind(':property', $data['property']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':inspector', $data['inspector']);
        $this->db->bind(':date', $data['date']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':issues', ($data['issues'] === '' ? 0 : (int)$data['issues']));
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // Delete inspection
    public function deleteInspection($id) {
        $this->db->query("DELETE FROM inspections WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>
