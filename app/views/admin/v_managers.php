<?php require APPROOT . '/views/inc/admin_header.php'; ?>

<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h2>Property Managers</h2>
            <p>Manage property manager registrations and assignments</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="addManager()">
                <i class="fas fa-plus"></i> Add Manager
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">3</h3>
                <p class="stat-label">Registered Managers</p>
                <span class="stat-change">Total Managers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">1</h3>
                <p class="stat-label">Awaiting Review</p>
                <span class="stat-change">Pending Approvals</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">2</h3>
                <p class="stat-label">Currently Approved</p>
                <span class="stat-change">Active Managers</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">1</h3>
                <p class="stat-label">Properties Assigned</p>
                <span class="stat-change">Property Assignments</span>
            </div>
        </div>
    </div>

    <!-- Tabs Container -->
    <div class="managers-content">
        <!-- Tab Navigation -->
        <div class="tab-navigation">
            <button class="tab-btn active" onclick="switchTab('applications')" id="applications-btn">
                Manager Applications
            </button>
            <button class="tab-btn" onclick="switchTab('assignments')" id="assignments-btn">
                Property Assignments
            </button>
        </div>

        <!-- Manager Applications Tab -->
        <div class="tab-content active" id="applications-tab">
            <!-- Search and Filter -->
            <div class="search-filter-row">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search managers..." id="searchManagers">
                </div>
                <div class="filter-container">
                    <select class="filter-select" id="filterManagers">
                        <option value="">All Managers</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Manager Applications Table -->
            <div class="table-section">
                <h3 class="table-title">Pending Manager Applications</h3>
                <div class="table-container">
                    <table class="managers-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Employee ID</th>
                                <th>Join Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['pendingManagers'])): ?>
                                <?php foreach ($data['pendingManagers'] as $manager): ?>
                                    <tr>
                                        <td><?php echo $manager->name; ?></td>
                                        <td><?php echo $manager->email; ?></td>
                                        <td>
                                            <a href="<?php echo URLROOT; ?>/users/viewEmployeeId/<?php echo $manager->id; ?>" target="_blank">
                                                <?php echo $manager->employee_id_filename; ?>
                                            </a>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($manager->created_at)); ?></td>
                                        <td>
                                            <button class="action-btn approve-btn" onclick="approveManager(<?php echo $manager->id; ?>)">
                                                Approve
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">No pending applications</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Property Assignments Tab -->
<div class="tab-content" id="assignments-tab">
    <div class="assignments-content">
        <!-- Assignment Stats -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding: 1rem; background-color: var(--light-color); border-radius: 0.5rem;">
            <div>
                <span style="margin-right: 2rem;"><strong>Available Properties:</strong> 2</span>
                <span><strong>Approved Managers:</strong> 2</span>
            </div>
            <button class="btn btn-primary" onclick="openAssignModal()">
                <i class="fas fa-user-plus"></i> Assign Property
            </button>
        </div>

        <!-- Current Assignments Table -->
        <div class="table-section">
            <h3 class="table-title assignments-title">Current Property Assignments (1)</h3>
            <div class="table-container">
                <table class="managers-table assignments-table">
                    <thead>
                        <tr>
                            <th>Property Name</th>
                            <th>Property Address</th>
                            <th>Assigned Manager</th>
                            <th>Assignment Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="manager-name">Sunset Apartments</td>
                            <td>123 Main St, City A</td>
                            <td>Sarah Wilson</td>
                            <td>20/01/2024</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn reject-btn" onclick="unassignProperty('ASSIGN001')">
                                        Unassign
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
    function approveManager(managerId) {
        if (confirm('Are you sure you want to approve this manager?')) {
            fetch(`<?php echo URLROOT; ?>/admin/approvePM/${managerId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload the page to update the table
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the request. Please check the console for details.');
                });
        }
    }
</script>

<?php require APPROOT . '/views/inc/admin_footer.php'; ?>