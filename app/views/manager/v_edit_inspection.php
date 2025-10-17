<!-- 
// here is v edit view file -->
<?php require APPROOT . '/views/inc/manager_header.php'; ?>
<div class="edit-inspection-content">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Edit Inspection</h1>
            <p class="page-subtitle">Update the details of the inspection</p>
        </div>
    </div>

    <div class="form-container">
        <form action="<?php echo URLROOT; ?>/inspection/edit/<?php echo $data['inspection']->id; ?>" method="post" class="inspection-form">
            
            <div class="form-group
">
                <label for="property">Property</label>
                <input type="text" id="property" name="property" class="form-control" value="<?php echo htmlspecialchars($data['inspection']->property); ?>" required>
            </div>
            <div class="form-group">
                <label for="type">Inspection Type</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="move-in" <?php echo $data['inspection']->type == 'move-in' ? 'selected' : ''; ?>>Move-in</option>
                    <option value="move-out" <?php echo $data['inspection']->type == 'move-out' ? 'selected' : ''; ?>>Move-out</option>
                    <option value="annual" <?php echo $data['inspection']->type == 'annual' ? 'selected' : ''; ?>>Annual</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inspector">Inspector</label>
                <input type="text" id="inspector" name="inspector" class="form-control" value="<?php echo htmlspecialchars($data['inspection']->inspector); ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Scheduled Date</label>
                <input type="date" id="date" name="date" class="form-control" value="<?php echo $data['inspection']->scheduled_date; ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="scheduled" <?php echo $data['inspection']->status == 'scheduled' ? 'selected' : ''; ?>>Scheduled</option>
                    <option value="in-progress" <?php echo $data['inspection']->status == 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="completed" <?php echo $data['inspection']->status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="issues">Issues Found</label>
                <textarea id="issues" name="issues" class="form-control" rows="4"><?php echo htmlspecialchars($data['inspection']->issues ?? ''); ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Inspection</button>
                <a href="<?php echo URLROOT; ?>/inspection/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/manager_footer.php'; ?>
