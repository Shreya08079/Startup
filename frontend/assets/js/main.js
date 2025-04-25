/**
 * Startup-Corporate Connection Platform - Main JavaScript File
 * Handles frontend interactivity and AJAX requests
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    if (typeof bootstrap !== 'undefined') {
        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (popoverTriggerEl) {
            new bootstrap.Popover(popoverTriggerEl);
        });
    }

    // Handle all AJAX forms
    setupAjaxForms();
    
    // Handle message box auto-resize
    setupMessageBox();
    
    // Handle listing filters
    setupListingFilters();
    
    // Other initializations
    initProfileImageUpload();

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add animation to features cards on scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.features .card').forEach(card => {
        observer.observe(card);
    });

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Mobile menu toggle
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');

    if (navbarToggler && navbarCollapse) {
        navbarToggler.addEventListener('click', () => {
            navbarCollapse.classList.toggle('show');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!navbarToggler.contains(e.target) && !navbarCollapse.contains(e.target)) {
                navbarCollapse.classList.remove('show');
            }
        });
    }

    // Back to top button
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopButton.className = 'back-to-top';
    document.body.appendChild(backToTopButton);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

/**
 * Setup AJAX form handling
 */
function setupAjaxForms() {
    document.querySelectorAll('.ajax-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            // Prepare form data
            const formData = new FormData(form);
            
            // Add CSRF token if available
            if (typeof csrfToken !== 'undefined') {
                formData.append('_token', csrfToken);
            }
            
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    if (data.message) {
                        showAlert('success', data.message);
                    }
                    
                    // Redirect if specified
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                    
                    // Reset form if needed
                    if (data.reset_form) {
                        form.reset();
                    }
                    
                    // Update UI if callback provided
                    if (typeof data.callback === 'function') {
                        data.callback();
                    }
                } else {
                    // Show error message
                    showAlert('danger', data.message || 'An error occurred');
                    
                    // Show field errors if available
                    if (data.errors) {
                        displayFormErrors(form, data.errors);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred. Please try again.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    });
}

/**
 * Setup message box auto-resize and character counter
 */
function setupMessageBox() {
    const messageBoxes = document.querySelectorAll('.auto-resize-textarea');
    
    messageBoxes.forEach(textarea => {
        // Auto-resize
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Character counter
        if (textarea.dataset.maxLength) {
            const counterId = textarea.id + '-counter';
            const counter = document.createElement('small');
            counter.className = 'form-text text-muted text-end d-block';
            counter.id = counterId;
            counter.textContent = `0/${textarea.dataset.maxLength}`;
            
            textarea.parentNode.appendChild(counter);
            
            textarea.addEventListener('input', function() {
                const remaining = textarea.dataset.maxLength - this.value.length;
                counter.textContent = `${this.value.length}/${textarea.dataset.maxLength}`;
                counter.className = remaining < 0 
                    ? 'form-text text-danger text-end d-block' 
                    : 'form-text text-muted text-end d-block';
            });
        }
    });
}

/**
 * Setup listing filters with AJAX
 */
function setupListingFilters() {
    const filterForm = document.getElementById('listings-filter');
    if (!filterForm) return;
    
    const listingsContainer = document.getElementById('listings-container');
    const loadMoreBtn = document.getElementById('load-more');
    let currentPage = 1;
    let isLoading = false;
    
    // Initial load
    loadListings(currentPage);
    
    // Form submission
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        currentPage = 1;
        listingsContainer.innerHTML = '';
        loadListings(currentPage);
    });
    
    // Load more button
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (!isLoading) {
                currentPage++;
                loadListings(currentPage);
            }
        });
    }
    
    function loadListings(page) {
        isLoading = true;
        loadMoreBtn && (loadMoreBtn.disabled = true);
        
        const formData = new FormData(filterForm);
        let queryString = `page=${page}`;
        
        // Convert form data to query string
        for (const [key, value] of formData.entries()) {
            if (value) {
                queryString += `&${key}=${encodeURIComponent(value)}`;
            }
        }
        
        fetch(`${API_BASE_URL}listings?${queryString}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                renderListings(data);
                loadMoreBtn && (loadMoreBtn.style.display = 'block');
            } else if (page === 1) {
                listingsContainer.innerHTML = '<div class="col-12"><div class="alert alert-info">No listings found matching your criteria.</div></div>';
                loadMoreBtn && (loadMoreBtn.style.display = 'none');
            } else {
                loadMoreBtn && (loadMoreBtn.style.display = 'none');
            }
        })
        .catch(error => {
            console.error('Error loading listings:', error);
            showAlert('danger', 'Failed to load listings. Please try again.');
        })
        .finally(() => {
            isLoading = false;
            loadMoreBtn && (loadMoreBtn.disabled = false);
        });
    }
    
    function renderListings(listings) {
        const listingHtml = listings.map(listing => `
            <div class="col-md-6 mb-4">
                <div class="card listing-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">${escapeHtml(listing.title)}</h5>
                        <p class="card-text">${escapeHtml(listing.description.substring(0, 150))}...</p>
                        <div class="mb-2">
                            <span class="badge bg-primary">${escapeHtml(listing.type)}</span>
                            <span class="badge bg-secondary">${escapeHtml(listing.industry)}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="listing.php?id=${listing.id}" class="btn btn-sm btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        `).join('');
        
        listingsContainer.insertAdjacentHTML('beforeend', listingHtml);
    }
}

/**
 * Initialize profile image upload
 */
function initProfileImageUpload() {
    const profileImageInput = document.getElementById('profile-image-upload');
    if (!profileImageInput) return;
    
    const profileImagePreview = document.getElementById('profile-image-preview');
    
    profileImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(event) {
                profileImagePreview.src = event.target.result;
                
                // Auto-submit the form if it exists
                const form = profileImageInput.closest('form');
                if (form && form.classList.contains('auto-submit')) {
                    form.submit();
                }
            };
            
            reader.readAsDataURL(file);
        }
    });
}

/**
 * Display form errors
 */
function displayFormErrors(form, errors) {
    // Clear previous errors
    form.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    form.querySelectorAll('.invalid-feedback').forEach(el => {
        el.remove();
    });
    
    // Add new errors
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            errorDiv.textContent = errors[field][0];
            
            input.parentNode.appendChild(errorDiv);
        }
    });
}

/**
 * Show alert message
 */
function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.role = 'alert';
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const container = document.querySelector('.alert-container') || document.body;
    container.prepend(alertDiv);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        const alert = bootstrap.Alert.getOrCreateInstance(alertDiv);
        alert.close();
    }, 5000);
}

/**
 * Helper function to escape HTML
 */
function escapeHtml(unsafe) {
    return unsafe
        .toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Global API base URL
const API_BASE_URL = 'http://localhost:8000/api/';

// Add custom styles for back to top button
const style = document.createElement('style');
style.textContent = `
    .back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 1000;
    }

    .back-to-top.show {
        opacity: 1;
    }

    .back-to-top:hover {
        background-color: #0b5ed7;
    }
`;
document.head.appendChild(style);