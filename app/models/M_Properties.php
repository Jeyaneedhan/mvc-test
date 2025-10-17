<?php
class M_Properties
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // CREATE - Add new property
    public function addProperty($data)
    {
        $this->db->query('INSERT INTO properties 
            (landlord_id, address, property_type, bedrooms, bathrooms, sqft, rent, 
             deposit, available_date, parking, pet_policy, laundry, description, status) 
             VALUES (:landlord_id, :address, :property_type, :bedrooms, :bathrooms, :sqft, :rent, 
                     :deposit, :available_date, :parking, :pet_policy, :laundry, :description, :status)');

        $this->db->bind(':landlord_id', $data['landlord_id']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':property_type', $data['property_type']);
        $this->db->bind(':bedrooms', $data['bedrooms']);
        $this->db->bind(':bathrooms', $data['bathrooms']);
        $this->db->bind(':sqft', $data['sqft']);
        $this->db->bind(':rent', $data['rent']);
        $this->db->bind(':deposit', $data['deposit']);
        $this->db->bind(':available_date', $data['available_date']);
        $this->db->bind(':parking', $data['parking']);
        $this->db->bind(':pet_policy', $data['pet_policy']);
        $this->db->bind(':laundry', $data['laundry']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':status', $data['status']); // e.g., "available", "draft", "rented"

        return $this->db->execute();
    }

    // READ - Get all properties
    public function getAllProperties()
    {
        $this->db->query('SELECT p.*, u.name as landlord_name 
                          FROM properties p
                          JOIN users u ON p.landlord_id = u.id
                          ORDER BY p.created_at DESC');
        return $this->db->resultSet();
    }

    // READ - Get property by ID
    public function getPropertyById($id)
    {
        $this->db->query('SELECT * FROM properties WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // READ - Get properties by landlord
    public function getPropertiesByLandlord($landlord_id)
    {
        $this->db->query('SELECT * FROM properties WHERE landlord_id = :landlord_id ORDER BY created_at DESC');
        $this->db->bind(':landlord_id', $landlord_id);
        return $this->db->resultSet();
    }

    // UPDATE - Edit property
    public function update($data)
    {
        $this->db->query('UPDATE properties SET 
                    address = :address, 
                    property_type = :property_type,
                    bedrooms = :bedrooms, 
                    bathrooms = :bathrooms, 
                    sqft = :sqft, 
                    rent = :rent, 
                    deposit = :deposit, 
                    available_date = :available_date, 
                    parking = :parking, 
                    pet_policy = :pet_policy, 
                    laundry = :laundry, 
                    description = :description
                  WHERE id = :id');

        $this->db->bind(':id', $data['id']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':property_type', $data['property_type']);
        $this->db->bind(':bedrooms', $data['bedrooms']);
        $this->db->bind(':bathrooms', $data['bathrooms']);
        $this->db->bind(':sqft', $data['sqft']);
        $this->db->bind(':rent', $data['rent']);
        $this->db->bind(':deposit', $data['deposit']);
        $this->db->bind(':available_date', $data['available_date']);
        $this->db->bind(':parking', $data['parking']);
        $this->db->bind(':pet_policy', $data['pet_policy']);
        $this->db->bind(':laundry', $data['laundry']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }



    // public function updateProperty($data) {
    //     // Update properties table
    //     $this->db->query('UPDATE properties 
    //         SET address = :address, 
    //             rent = :rent, 
    //             status = :status,
    //             property_type = :property_type,
    //             issue = :issue,
    //             tenant = :tenant,
    //             available_date = :available_date
    //         WHERE id = :id');

    //     $this->db->bind(':address', $data['address']);
    //     $this->db->bind(':rent', $data['rent']);
    //     $this->db->bind(':status', $data['status']);
    //     $this->db->bind(':property_type', $data['property_type'] ?? null);
    //     $this->db->bind(':issue', $data['issue'] ?? null);
    //     $this->db->bind(':tenant', $data['tenant'] ?? null);
    //     $this->db->bind(':available_date', $data['available_date'] ?? null);
    //     $this->db->bind(':id', $data['id']);

    //     return $this->db->execute(); // execute once
    // }


    // DELETE - Remove property
    public function deleteProperty($id)
    {
        $this->db->query('DELETE FROM properties WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Search property (address/type/landlord)
    public function searchProperties($searchTerm, $type = '', $status = '')
    {
        $query = 'SELECT * FROM properties WHERE 1=1';

        if (!empty($searchTerm)) {
            $query .= ' AND (address LIKE :search OR description LIKE :search)';
        }

        if (!empty($type)) {
            $query .= ' AND property_type = :type';
        }

        if (!empty($status)) {
            $query .= ' AND status = :status';
        }

        $query .= ' ORDER BY created_at DESC';

        $this->db->query($query);

        if (!empty($searchTerm)) {
            $this->db->bind(':search', '%' . $searchTerm . '%');
        }
        if (!empty($type)) {
            $this->db->bind(':type', $type);
        }
        if (!empty($status)) {
            $this->db->bind(':status', $status);
        }

        return $this->db->resultSet();
    }
}
