<?php require APPROOT . '/views/inc/manager_header.php'; ?>

<div class="add-inspection-content">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Schedule New Inspection</h1>
            <p class="page-subtitle">Fill in the details to schedule an inspection</p>
        </div>
    </div>

    <div class="form-container">
        <form action="<?php echo URLROOT; ?>/inspection/add" method="post" class="inspection-form">
            
            <div class="form-group">
                <label for="property">Property</label>
                <input type="text" id="property" name="property" class="form-control" placeholder="Enter property name/address" required>
            </div>

            <div class="form-group">
                <label for="issues">Issues</label>
                <input type="number" id="issues" name="issues" class="form-control" placeholder="Enter No of Isseues or Mainatanenaces" required>
            </div>

            <div class="form-group">
                <label for="type">Inspection Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    <option value="Issue">Issue</option>
                    <option value="Maintanace">Maintanace</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Scheduled Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Inspection</button>
                <a href="<?php echo URLROOT; ?>/inspection/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php require APPROOT . '/views/inc/manager_footer.php'; ?>
