<?php require APPROOT . '/views/inc/landlord_header.php'; ?>

<!-- Page Header -->
<div class="page-header">
    <div class="header-left">
        <h1 class="page-title">My Properties</h1>
        <p class="page-subtitle">Manage your property listings</p>
    </div>
    <div class="header-actions">
        <a href="<?php echo URLROOT; ?>/landlord/add_property" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Property
        </a>
    </div>
</div>

<!-- Filters -->
<div class="filters">
    <div class="filter-row">
        <div class="filter-group">
            <label class="form-label">Search Properties</label>
            <input type="text" class="form-control" placeholder="Search by address, tenant name..." id="propertySearch">
        </div>
        <div class="filter-group">
            <label class="form-label">Status</label>
            <select class="form-control" id="statusFilter">
                <option value="">All Properties</option>
                <option value="occupied">Occupied</option>
                <option value="vacant">Vacant</option>
                <option value="maintenance">Under Maintenance</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="form-label">Property Type</label>
            <select class="form-control" id="typeFilter">
                <option value="">All Types</option>
                <option value="apartment">Apartment</option>
                <option value="house">House</option>
                <option value="condo">Condo</option>
            </select>
        </div>
        <div class="filter-group">
            <button class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
        </div>
    </div>
</div>


<!--Properties Grid -->
<div class="property-grid">

    <?php if (!empty($data['properties']) && is_array($data['properties'])): ?>
        <?php foreach ($data['properties'] as $property): ?>
            <div class="property-card" data-status="<?php echo isset($property->status) ? htmlspecialchars($property->status) : ''; ?>"
                data-type="<?php echo isset($property->property_type) ? htmlspecialchars($property->property_type) : ''; ?>">

                <!-- Property Image -->
                <img src="<?php echo !empty($property->image) ? $property->image : 'https://via.placeholder.com/300x200?text=Property+Image'; ?>"
                    alt="Property" class="property-image">

                <div class="property-info">
                    <!-- Property Address -->
                    <h3 class="property-title"><?php echo isset($property->address) ? htmlspecialchars($property->address) : 'No Address'; ?></h3>

                    <div class="property-details">
                        <!-- Type -->
                        <p><strong>Type:</strong> <?php echo isset($property->property_type) ? htmlspecialchars($property->property_type) : '-'; ?></p>

                        <!-- Rent -->
                        <p><strong>Rent:</strong> $<?php echo isset($property->rent) ? htmlspecialchars($property->rent) : '-'; ?>/month</p>

                        <!-- Status -->
                        <p><strong>Status:</strong>
                            <?php
                            $statusClass = 'badge-secondary';
                            if (isset($property->status)) {
                                if ($property->status === 'occupied') $statusClass = 'badge-success';
                                elseif ($property->status === 'vacant') $statusClass = 'badge-warning';
                                elseif ($property->status === 'maintenance') $statusClass = 'badge-danger';
                            }
                            ?>
                            <span class="badge <?php echo $statusClass; ?>">
                                <?php echo isset($property->status) ? ucfirst($property->status) : 'Unknown'; ?>
                            </span>
                        </p>

                        <!-- Tenant -->
                        <?php if (isset($property->tenant) && !empty($property->tenant)): ?>
                            <p><strong>Tenant:</strong> <?php echo htmlspecialchars($property->tenant); ?></p>
                        <?php endif; ?>
                        </p>

                        <!-- Issue (Optional) -->
                        <?php if (isset($property->issue) && !empty($property->issue)): ?>
                            <p><strong>Issue:</strong> <?php echo htmlspecialchars($property->issue); ?></p>
                        <?php endif; ?>

                        <!--Available Date-->
                        <?php if (isset($property->available_date) && !empty($property->available_date)): ?>
                            <p><strong>Available Date:</strong> <?php echo htmlspecialchars($property->available_date); ?></p>
                        <?php endif; ?>
                    </div>


                    <!-- Property Actions -->
                    <div class="property-actions">
                        <!-- <button class="btn btn-outline btn-sm view-property" data-property-id="<?php echo isset($property->id) ? $property->id : ''; ?>">
                            <i class="fas fa-eye"></i> View Details
                        </button> -->
                        <!-- before: <button class="btn btn-primary btn-sm edit-property" ...>Edit</button> -->
                        <a href="<?php echo URLROOT; ?>/landlord/edit/<?php echo $property->id; ?>"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <!--Delete button-->
                        <a href="<?php echo URLROOT; ?>/landlord/delete/<?php echo $property->id; ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this property?');">
                            <i class="fas fa-trash"></i> Delete
                        </a>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No properties found. Add a new property to get started.</p>
    <?php endif; ?>

</div>



<!--Properties Grid 
<div class="property-grid">
   
    <div class="property-card" data-status="vacant" data-type="house">
        <img src="https://via.placeholder.com/300x200?text=Property+Image" alt="Property" class="property-image">
        <div class="property-info">
            <h3 class="property-title">456 Oak Avenue</h3>
            <div class="property-details">
                <p><strong>Type:</strong> 3BR/2BA House</p>
                <p><strong>Rent:</strong> $1,800/month</p>
                <p><strong>Status:</strong> <span class="badge badge-warning">Vacant</span></p>
                <p><strong>Available:</strong> March 1, 2024</p>
            </div>
            <div class="property-actions">
                <button class="btn btn-outline btn-sm view-property" data-property-id="2">
                    <i class="fas fa-eye"></i> View Details
                </button>
                <button class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> List Property
                </button>
            </div>
        </div>
    </div>

     <div class="property-card" data-status="occupied" data-type="condo">
        <img src="https://via.placeholder.com/300x200?text=Property+Image" alt="Property" class="property-image">
        <div class="property-info">
            <h3 class="property-title">789 Pine St, Unit 12</h3>
            <div class="property-details">
                <p><strong>Type:</strong> 1BR/1BA Condo</p>
                <p><strong>Rent:</strong> $950/month</p>
                <p><strong>Status:</strong> <span class="badge badge-success">Occupied</span></p>
                <p><strong>Tenant:</strong> Sarah Wilson</p>
            </div>
            <div class="property-actions">
                <button class="btn btn-outline btn-sm view-property" data-property-id="3">
                    <i class="fas fa-eye"></i> View Details
                </button>
                <button class="btn btn-primary btn-sm edit-property" data-property-id="3">
                    <i class="fas fa-edit"></i> Edit
                </button>
            </div>
        </div>
    </div> 

    <div class="property-card" data-status="maintenance" data-type="apartment">
        <img src="https://via.placeholder.com/300x200?text=Property+Image" alt="Property" class="property-image">
        <div class="property-info">
            <h3 class="property-title">321 Elm Drive, Apt 5B</h3>
            <div class="property-details">
                <p><strong>Type:</strong> 2BR/2BA Apartment</p>
                <p><strong>Rent:</strong> $1,350/month</p>
                <p><strong>Status:</strong> <span class="badge badge-danger">Maintenance</span></p>
                <p><strong>Issue:</strong> Plumbing repair needed</p>
            </div>
            <div class="property-actions">
                <button class="btn btn-outline btn-sm view-property" data-property-id="4">
                    <i class="fas fa-eye"></i> View Details
                </button>
                <button class="btn btn-warning btn-sm">
                    <i class="fas fa-tools"></i> Schedule Repair
                </button>
            </div>
        </div>
    </div>
</div> -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize filter functionality
        initFilter('#statusFilter', '.property-card', '.badge');
        initFilter('#typeFilter', '.property-card', null, 'data-type');

        // Search functionality
        const searchInput = document.getElementById('propertySearch');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const propertyCards = document.querySelectorAll('.property-card');

                propertyCards.forEach(card => {
                    const title = card.querySelector('.property-title').textContent.toLowerCase();
                    const details = card.querySelector('.property-details').textContent.toLowerCase();

                    if (title.includes(searchTerm) || details.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        }

        // Button click handlers
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                const action = this.textContent.trim();
                const propertyId = this.dataset.propertyId;

                switch (action) {
                    case 'View Details':
                        showNotification(Opening details
                            for property $ {
                                propertyId
                            }, 'info');
                        break;
                    case 'Edit':
                        showNotification(Opening editor
                            for property $ {
                                propertyId
                            }, 'info');
                        break;
                    case 'List Property':
                        showNotification('Opening property listing form', 'info');
                        break;
                    case 'Schedule Repair':
                        showNotification('Opening maintenance scheduling', 'info');
                        break;
                }
            });
        });
    });

    function resetFilters() {
        document.getElementById('statusFilter').value = '';
        document.getElementById('typeFilter').value = '';
        document.getElementById('propertySearch').value = '';

        document.querySelectorAll('.property-card').forEach(card => {
            card.style.display = 'block';
        });

        showNotification('Filters reset', 'info');
    }

    // Helper function for filter functionality
    function initFilter(selectId, cardClass, badgeClass = null, dataAttr = null) {
        const filterSelect = document.querySelector(selectId);
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const selectedValue = this.value.toLowerCase();
                const cards = document.querySelectorAll(cardClass);

                cards.forEach(card => {
                    if (selectedValue === '') {
                        card.style.display = 'block';
                    } else {
                        let cardValue;
                        if (dataAttr) {
                            cardValue = card.getAttribute(dataAttr);
                        } else if (badgeClass) {
                            const badge = card.querySelector(badgeClass);
                            cardValue = badge ? badge.textContent.toLowerCase() : '';
                        }

                        if (cardValue && cardValue.includes(selectedValue)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        }
    }

    // Notification function
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = notification notification - $ {
            type
        };
        notification.textContent = message;

        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            padding: '1rem 1.5rem',
            borderRadius: '0.5rem',
            color: 'white',
            fontWeight: '500',
            zIndex: '9999',
            opacity: '0',
            transform: 'translateY(-20px)',
            transition: 'all 0.3s ease'
        });

        const colors = {
            success: '#10b981',
            warning: '#f59e0b',
            error: '#ef4444',
            info: '#3b82f6'
        };
        notification.style.backgroundColor = colors[type] || colors.info;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateY(0)';
        }, 100);

        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
</script>

<script>
    const URLROOT = '<?php echo URLROOT; ?>';

    document.addEventListener('DOMContentLoaded', () => {
        // Search/filter code: keep as you had it (no change needed)

        // If you want "View Details" buttons to navigate via JS (optional)
        document.querySelectorAll('.view-property').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const id = this.dataset.propertyId;
                if (id) {
                    window.location.href = URLROOT + '/landlord/view_property/' + id;
                }
            });
        });

        // Remove the old global '.btn' handler that showed notifications for all buttons.
    });
</script>


<?php require APPROOT . '/views/inc/landlord_footer.php'; ?>