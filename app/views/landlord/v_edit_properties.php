<?php require APPROOT . '/views/inc/landlord_header.php'; ?>

<!-- Page Header -->
<div class="page-header">
  <div class="header-left">
    <h1 class="page-title">Edit Property</h1>
    <p class="page-subtitle">Update property details</p>
  </div>
  <div class="header-actions">
    <a href="<?php echo URLROOT; ?>/landlord/properties" class="btn btn-outline">
      <i class="fas fa-arrow-left"></i> Back to Properties
    </a>
  </div>
</div>

<!-- Edit Property Form -->
<div class="content-card">
  <div class="card-header">
    <h2 class="card-title">Property Information</h2>
  </div>
  <div class="card-body">
    <form id="editPropertyForm" method="POST" action="<?php echo URLROOT; ?>/landlord/update/<?php echo $data['property']->id; ?>" enctype="multipart/form-data">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Left Column -->
        <div>
          <div class="form-group">
            <label class="form-label">Property Address *</label>
            <input type="text" class="form-control" name="address" required
              value="<?php echo htmlspecialchars($data['property']->address ?? ''); ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Property Type *</label>
            <select class="form-control" name="property_type" required>
              <option value="">Select Type</option>
              <option value="apartment" <?php echo ($data['property']->property_type ?? '') == 'apartment' ? 'selected' : ''; ?>>Apartment</option>
              <option value="house" <?php echo ($data['property']->property_type ?? '') == 'house' ? 'selected' : ''; ?>>House</option>
              <option value="condo" <?php echo ($data['property']->property_type ?? '') == 'condo' ? 'selected' : ''; ?>>Condo</option>
              <option value="townhouse" <?php echo ($data['property']->property_type ?? '') == 'townhouse' ? 'selected' : ''; ?>>Townhouse</option>
            </select>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label class="form-label">Bedrooms *</label>
              <select class="form-control" name="bedrooms" required>
                <option value="">Select</option>
                <option value="0" <?php echo ($data['property']->bedrooms ?? '') == '0' ? 'selected' : ''; ?>>Studio</option>
                <option value="1" <?php echo ($data['property']->bedrooms ?? '') == '1' ? 'selected' : ''; ?>>1 Bedroom</option>
                <option value="2" <?php echo ($data['property']->bedrooms ?? '') == '2' ? 'selected' : ''; ?>>2 Bedrooms</option>
                <option value="3" <?php echo ($data['property']->bedrooms ?? '') == '3' ? 'selected' : ''; ?>>3 Bedrooms</option>
                <option value="4" <?php echo ($data['property']->bedrooms ?? '') >= '4' ? 'selected' : ''; ?>>4+ Bedrooms</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Bathrooms *</label>
              <select class="form-control" name="bathrooms" required>
                <option value="">Select</option>
                <option value="1" <?php echo ($data['property']->bathrooms ?? '') == '1' ? 'selected' : ''; ?>>1 Bathroom</option>
                <option value="2" <?php echo ($data['property']->bathrooms ?? '') == '2' ? 'selected' : ''; ?>>2 Bathrooms</option>
                <option value="3" <?php echo ($data['property']->bathrooms ?? '') >= '3' ? 'selected' : ''; ?>>3+ Bathrooms</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Square Footage</label>
            <input type="number" class="form-control" name="sqft"
              value="<?php echo htmlspecialchars($data['property']->sqft ?? ''); ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Monthly Rent *</label>
            <input type="number" step="0.01" class="form-control" name="rent" required
              value="<?php echo htmlspecialchars($data['property']->rent ?? ''); ?>">
          </div>
        </div>

        <!-- Right Column -->
        <div>
          <div class="form-group">
            <label class="form-label">Security Deposit</label>
            <input type="number" class="form-control" name="deposit"
              value="<?php echo htmlspecialchars($data['property']->deposit ?? ''); ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Available Date</label>
            <input type="date" class="form-control" name="available_date"
              value="<?php echo htmlspecialchars($data['property']->available_date ?? ''); ?>">
          </div>

          <div class="form-group">
            <label class="form-label">Parking</label>
            <select class="form-control" name="parking">
              <option value="">Select Parking</option>
              <option value="none" <?php echo ($data['property']->parking ?? '') == 'none' ? 'selected' : ''; ?>>No Parking</option>
              <option value="street" <?php echo ($data['property']->parking ?? '') == 'street' ? 'selected' : ''; ?>>Street Parking</option>
              <option value="driveway" <?php echo ($data['property']->parking ?? '') == 'driveway' ? 'selected' : ''; ?>>Driveway</option>
              <option value="garage" <?php echo ($data['property']->parking ?? '') == 'garage' ? 'selected' : ''; ?>>Garage</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Pet Policy</label>
            <select class="form-control" name="pets">
              <option value="no" <?php echo ($data['property']->pet_policy ?? '') == 'no' ? 'selected' : ''; ?>>No Pets</option>
              <option value="cats" <?php echo ($data['property']->pet_policy ?? '') == 'cats' ? 'selected' : ''; ?>>Cats Only</option>
              <option value="dogs" <?php echo ($data['property']->pet_policy ?? '') == 'dogs' ? 'selected' : ''; ?>>Dogs Only</option>
              <option value="both" <?php echo ($data['property']->pet_policy ?? '') == 'both' ? 'selected' : ''; ?>>Cats & Dogs</option>
            </select>
          </div>

          <div class="form-group">
            <label class="form-label">Laundry</label>
            <select class="form-control" name="laundry">
              <option value="none" <?php echo ($data['property']->laundry ?? '') == 'none' ? 'selected' : ''; ?>>No Laundry</option>
              <option value="shared" <?php echo ($data['property']->laundry ?? '') == 'shared' ? 'selected' : ''; ?>>Shared Laundry</option>
              <option value="hookups" <?php echo ($data['property']->laundry ?? '') == 'hookups' ? 'selected' : ''; ?>>Washer/Dryer Hookups</option>
              <option value="included" <?php echo ($data['property']->laundry ?? '') == 'included' ? 'selected' : ''; ?>>Washer/Dryer Included</option>
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Property Description</label>
        <textarea class="form-control" name="description" rows="4"><?php echo htmlspecialchars($data['property']->description ?? ''); ?></textarea>
      </div>

      <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Property</button>
        <a href="<?php echo URLROOT; ?>/landlord/properties" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

<?php require APPROOT . '/views/inc/landlord_footer.php'; ?>