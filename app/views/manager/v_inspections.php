<?php require APPROOT . '/views/inc/manager_header.php'; ?>

<div class="inspections-content">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Pre-Inspection Reports</h1>
            <p class="page-subtitle">Manage inspection checklists and reports</p>
        </div>
        <div class="header-right">
            
        <a href="<?php echo URLROOT; ?>/inspection/add" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Schedule Inspection
        </a>
    </div>
    </div>

    <div class="tabs-container">
        <div class="tabs-nav">
            <button class="tab-button active" onclick="showInspectionTab('all-inspections')">All Inspections</button>
        </div>

        <!-- All Inspections Tab -->
        <div id="all-inspections-tab" class="tab-content active">
            <!-- Search and Filters -->
            <div class="dashboard-section">
                <div class="filters-grid">
                    <div class="search-container">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search inspections..." id="inspectionSearch">
                    </div>
                    <select class="filter-select" id="typeFilter">
                        <option value="all">All Types</option>
                        <option value="move-in">Move-in</option>
                        <option value="move-out">Move-out</option>
                        <option value="annual">Annual</option>
                    </select>
                    <select class="filter-select" id="statusFilter">
                        <option value="all">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>

            <!-- Inspections Table -->
            <div class="dashboard-section">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>INSPECTION ID</th>
                                <th>PROPERTY</th>
                                <th>TYPE</th>
                                <th>INSPECTOR</th>
                                <th>SCHEDULED DATE</th>
                                <th>STATUS</th>
                                <th>ISSUES</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['inspections'])): ?>
                                <?php foreach ($data['inspections'] as $inspection): ?>
                                    <tr>
                                        <td class="font-medium">INS-<?php echo $inspection->id; ?></td>
                                        <td><?php echo htmlspecialchars($inspection->property); ?></td>
                                        <td><?php echo ucfirst($inspection->type); ?></td>
                                        <td><?php echo htmlspecialchars($inspection->inspector); ?></td>
                                        <td><?php echo $inspection->scheduled_date; ?></td>
                                        <td><span class="status-badge pending"><?php echo ucfirst($inspection->status); ?></span></td>
                                        <td><?php echo $inspection->issues ?? '-'; ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-secondary">
                                                    <i class="fas fa-eye"></i> View Report
                                                </button>
                                                <a href="<?php echo URLROOT; ?>/inspection/edit/<?php echo $inspection->id; ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <button class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $inspection->id; ?>)">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center">No inspections found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/manager_footer.php'; ?>
