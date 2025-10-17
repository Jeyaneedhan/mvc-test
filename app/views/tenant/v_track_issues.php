<?php require APPROOT . '/views/inc/tenant_header.php'; ?>

<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h2>Track Issue Status</h2>
            <p>Monitor the progress of your reported issues</p>
        </div>
        <div class="header-actions">
            <a href="<?php echo URLROOT; ?>/tenant/report_issue" class="btn btn-primary">
                <i class="fas fa-plus"></i> Report New Issue
            </a>
        </div>
    </div>

    <!-- Issue Status Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">2</h3>
                <p class="stat-label">Pending Issues</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">1</h3>
                <p class="stat-label">In Progress</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">5</h3>
                <p class="stat-label">Resolved</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3 class="stat-number">2.3</h3>
                <p class="stat-label">Avg. Days to Resolve</p>
            </div>
        </div>
    </div>

    <!-- Issues Table -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Your Issues</h3>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Issue ID</th>
                        <th>Property</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Report Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>ISS-001</strong></td>
                        <td>Oak Street Apartment</td>
                        <td>Plumbing</td>
                        <td><span class="priority-badge medium">Medium</span></td>
                        <td><span class="status-badge pending">In Progress</span></td>
                        <td>January 15, 2024</td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="viewIssue('ISS-001', 'Leaky Faucet in Kitchen', 'in_progress', 'medium', 'Kitchen faucet has been leaking for 2 days', '2024-01-15')">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ISS-002</strong></td>
                        <td>Oak Street Apartment</td>
                        <td>Heating/Cooling</td>
                        <td><span class="priority-badge high">High</span></td>
                        <td><span class="status-badge approved">Resolved</span></td>
                        <td>January 10, 2024</td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="viewIssue('ISS-002', 'Heating System Not Working', 'resolved', 'high', 'Heating system stopped working completely', '2024-01-10')">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ISS-003</strong></td>
                        <td>Oak Street Apartment</td>
                        <td>Electrical</td>
                        <td><span class="priority-badge low">Low</span></td>
                        <td><span class="status-badge">Pending</span></td>
                        <td>January 20, 2024</td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="viewIssue('ISS-003', 'Light Bulb Replacement', 'pending', 'low', 'Bathroom light bulb needs replacement', '2024-01-20')">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>ISS-004</strong></td>
                        <td>Oak Street Apartment</td>
                        <td>Maintenance</td>
                        <td><span class="priority-badge medium">Medium</span></td>
                        <td><span class="status-badge approved">Resolved</span></td>
                        <td>December 28, 2023</td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="viewIssue('ISS-004', 'Window Lock Repair', 'resolved', 'medium', 'Bedroom window lock is not functioning properly', '2023-12-28')">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Filter Issues</h3>
        </div>

        <div class="filters-row">
            <div class="filter-group">
                <label>Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Priority</label>
                <select class="form-select" id="priorityFilter">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Category</label>
                <select class="form-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="Plumbing">Plumbing</option>
                    <option value="Electrical">Electrical</option>
                    <option value="Heating/Cooling">Heating/Cooling</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>

            <div class="filter-group">
                <button class="btn btn-primary" onclick="applyFilters()">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<!-- Issue Details Modal -->
<div id="issueModal" class="modal-overlay hidden">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3>Issue Details</h3>
            <button class="modal-close" onclick="closeIssueModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body" id="modalContent">
            <!-- Content will be populated by JavaScript -->
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const status = document.getElementById('statusFilter').value;
        const priority = document.getElementById('priorityFilter').value;
        const category = document.getElementById('categoryFilter').value;

        const rows = document.querySelectorAll('.data-table tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const rowStatus = row.querySelector('.status-badge').textContent.toLowerCase().replace(' ', '_');
            const rowPriority = row.querySelector('.priority-badge').textContent.toLowerCase();
            const rowCategory = row.cells[2].textContent;

            const matchesStatus = !status || rowStatus.includes(status);
            const matchesPriority = !priority || rowPriority === priority;
            const matchesCategory = !category || rowCategory === category;

            if (matchesStatus && matchesPriority && matchesCategory) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        showNotification(`Showing ${visibleCount} issues`, 'info');
    }

    // Add event listeners for real-time filtering
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('priorityFilter').addEventListener('change', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);
</script>

<?php require APPROOT . '/views/inc/tenant_footer.php'; ?>