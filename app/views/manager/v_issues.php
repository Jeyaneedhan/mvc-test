<?php require APPROOT . '/views/inc/manager_header.php'; ?>

<div class="issues-content">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Issue Resolution</h1>
            <p class="page-subtitle">Track and resolve tenant-reported issues and maintenance requests.</p>
        </div>
        <div class="header-right">
        </div>
    </div>

    <!-- Search Bar -->
    <div class="dashboard-section">
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Search issues..." id="issueSearch">
        </div>
    </div>

    <div class="issues-layout">
        <!-- Reported Issues -->
        <div class="issues-list">
            <div class="dashboard-section">
                <div class="section-header">
                    <div class="header-icon">
                        <i class="fas fa-exclamation-circle"></i>
                        <h2>Reported Issues</h2>
                    </div>
                </div>

                <div class="tabs-container">
                    <div class="tabs-nav">
                        <button class="tab-button active" onclick="showIssueTab('all')">All</button>
                        <button class="tab-button" onclick="showIssueTab('open')">Open</button>
                        <button class="tab-button" onclick="showIssueTab('assigned')">Assigned</button>
                        <button class="tab-button" onclick="showIssueTab('in-progress')">In Progress</button>
                        <button class="tab-button" onclick="showIssueTab('resolved')">Resolved</button>
                    </div>

                    <div id="all-issues-tab" class="tab-content active">
                        <div class="issues-cards">
                            <div class="issue-card" onclick="selectIssue('ISS-001')">
                                <div class="issue-header">
                                    <div class="issue-title-priority">
                                        <h3 class="font-medium">Water leak in bathroom</h3>
                                        <span class="priority-badge high">HIGH</span>
                                    </div>
                                    <span class="status-badge rejected">Open</span>
                                </div>
                                <p class="issue-property">Sunset Apartments 2A</p>
                                <p class="issue-description">Tenant reports water leaking from ceiling in bathroom area</p>
                                <div class="issue-footer">
                                    <span>By Sarah Johnson</span>
                                    <span>2024-01-15</span>
                                    <span>2 images</span>
                                </div>
                            </div>

                            <div class="issue-card" onclick="selectIssue('ISS-002')">
                                <div class="issue-header">
                                    <div class="issue-title-priority">
                                        <h3 class="font-medium">Broken elevator</h3>
                                        <span class="priority-badge high">HIGH</span>
                                    </div>
                                    <span class="status-badge pending">Assigned</span>
                                </div>
                                <p class="issue-property">Downtown Lofts Building B</p>
                                <p class="issue-description">Elevator in building B is not working properly</p>
                                <div class="issue-footer">
                                    <span>By Mike Chen</span>
                                    <span>2024-01-14</span>
                                    <span>1 images</span>
                                </div>
                            </div>

                            <div class="issue-card" onclick="selectIssue('ISS-003')">
                                <div class="issue-header">
                                    <div class="issue-title-priority">
                                        <h3 class="font-medium">Noisy neighbors</h3>
                                        <span class="priority-badge medium">MEDIUM</span>
                                    </div>
                                    <span class="status-badge approved">In Progress</span>
                                </div>
                                <p class="issue-property">Garden View Condos 3C</p>
                                <p class="issue-description">Repeated noise complaints about upstairs neighbors</p>
                                <div class="issue-footer">
                                    <span>By Emma Davis</span>
                                    <span>2024-01-13</span>
                                    <span>0 images</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/manager_footer.php'; ?>
