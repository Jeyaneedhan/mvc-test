<?php require APPROOT . '/views/inc/tenant_header.php'; ?>

<div class="page-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h2>Report an Issue</h2>
            <p>Report maintenance issues with your property</p>
        </div>
    </div>

    <!-- Success Message (Hidden by default) -->
    <div id="successMessage" class="dashboard-section text-center hidden">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h3>Issue Reported Successfully!</h3>
        <p>Your issue has been reported and assigned ticket #<span id="ticketNumber">ISS-2024-001</span>. We'll notify you when it's updated.</p>
        <button onclick="reportAnother()" class="btn btn-primary">Report Another Issue</button>
    </div>

    <!-- Issue Form -->
    <div id="issueForm" class="dashboard-section">
        <div class="section-header">
            <h3>Issue Details</h3>
        </div>

        <form onsubmit="submitIssue(event)" class="issue-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Property</label>
                    <select id="property" class="form-select" required>
                        <option value="">Select Property</option>
                        <option value="Oak Street Apartment">Oak Street Apartment</option>
                        <option value="Maple Avenue Studio">Maple Avenue Studio</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Issue Category</label>
                    <select id="category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Heating/Cooling">Heating/Cooling</option>
                        <option value="Appliances">Appliances</option>
                        <option value="Locks/Security">Locks/Security</option>
                        <option value="Pest Control">Pest Control</option>
                        <option value="Maintenance">General Maintenance</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Priority Level</label>
                <select id="priority" class="form-select">
                    <option value="low">Low - Can wait a few days</option>
                    <option value="medium" selected>Medium - Within 24-48 hours</option>
                    <option value="high">High - Urgent, needs immediate attention</option>
                    <option value="emergency">Emergency - Safety concern, immediate action required</option>
                </select>
            </div>

            <div class="form-group">
                <label>Issue Title</label>
                <input type="text" id="issueTitle" placeholder="Brief description of the issue" class="form-input" required>
            </div>

            <div class="form-group">
                <label>Detailed Description</label>
                <textarea id="description" placeholder="Please describe the issue in detail..." class="form-textarea" required></textarea>
            </div>

            <div class="form-group">
                <label>Upload Images (Optional)</label>
                <div class="upload-area">
                    <div class="upload-content">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Drag & drop images here or click to browse</p>
                        <p class="upload-note">JPG, PNG files only (max 5MB each)</p>
                    </div>
                    <input type="file" accept="image/*" multiple id="imageUpload" class="hidden">
                </div>

                <div id="imagePreview" class="image-preview hidden"></div>
            </div>

            <div class="form-group">
                <label>Best Time to Contact</label>
                <select class="form-select">
                    <option value="anytime">Anytime</option>
                    <option value="morning">Morning (8AM - 12PM)</option>
                    <option value="afternoon">Afternoon (12PM - 5PM)</option>
                    <option value="evening">Evening (5PM - 8PM)</option>
                    <option value="weekend">Weekends only</option>
                </select>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary w-full">
                <i class="fas fa-paper-plane"></i>
                Report Issue
            </button>
        </form>
    </div>

    <!-- Recent Issues -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3>Recent Issues</h3>
            <a href="<?php echo URLROOT; ?>/tenant/track_issues" class="btn btn-secondary btn-sm">View All</a>
        </div>

        <div class="recent-issues">
            <div class="issue-item">
                <div class="issue-status">
                    <span class="status-badge pending">In Progress</span>
                </div>
                <div class="issue-details">
                    <h4>Leaky Faucet in Kitchen</h4>
                    <p>Kitchen faucet has been leaking for 2 days</p>
                    <span class="issue-date">Reported: January 15, 2024</span>
                </div>
                <div class="issue-priority">
                    <span class="priority-badge medium">Medium</span>
                </div>
            </div>

            <div class="issue-item">
                <div class="issue-status">
                    <span class="status-badge approved">Resolved</span>
                </div>
                <div class="issue-details">
                    <h4>Heating System Not Working</h4>
                    <p>Heating system stopped working completely</p>
                    <span class="issue-date">Reported: January 10, 2024</span>
                </div>
                <div class="issue-priority">
                    <span class="priority-badge high">High</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Make upload area clickable
    document.querySelector('.upload-area').addEventListener('click', function() {
        document.getElementById('imageUpload').click();
    });

    // Handle drag and drop
    const uploadArea = document.querySelector('.upload-area');

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');

        const files = Array.from(e.dataTransfer.files);
        const imageFiles = files.filter(file => file.type.startsWith('image/'));

        if (imageFiles.length > 0) {
            selectedImages = [...selectedImages, ...imageFiles];
            updateImagePreview();
        }
    });
</script>

<?php require APPROOT . '/views/inc/tenant_footer.php'; ?>