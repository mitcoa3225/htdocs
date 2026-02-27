// Frontend helpers for VelocityNet pages.
// Binds UI events and small page behaviors.
// Keeps common page scripts in one place.

// Global app object
const ComplaintsApp = {
    // Initialize the application
    init() {
        this.bindEvents();
        this.initializeComponents();
        console.log('Complaints system initialized');
    },

    // Bind event listeners
    bindEvents() {
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                // Animate icon
                const icon = mobileMenuBtn.querySelector('svg');
                if (icon) {
                    icon.classList.toggle('rotate-90');
                }
            });
        }

        // Form validation
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            form.addEventListener('submit', this.validateForm);
        });

        // Dismiss alerts
        const dismissButtons = document.querySelectorAll('[data-dismiss="alert"]');
        dismissButtons.forEach(button => {
            button.addEventListener('click', this.dismissAlert);
        });

        // Confirmation dialogs
        const confirmButtons = document.querySelectorAll('[data-confirm]');
        confirmButtons.forEach(button => {
            button.addEventListener('click', this.confirmAction);
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                const href = anchor.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });
    },

    // Initialize components
    initializeComponents() {
        this.initTooltips();
        this.initDataTables();
        this.initFormEnhancements();
        this.initAnimations();
    },

    // Initialize scroll animations
    initAnimations() {
        // Fade in elements on scroll
        const fadeElements = document.querySelectorAll('[data-animate]');
        if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            fadeElements.forEach(el => observer.observe(el));
        }
    },

    // Form validation
    validateForm(e) {
        const form = e.target;
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        // Clear previous errors
        form.querySelectorAll('.form-error').forEach(error => {
            error.remove();
        });

        // Validate required fields
        requiredFields.forEach(field => {
            field.classList.remove('border-red-500', 'border-[#c75d5d]');

            if (!field.value.trim()) {
                ComplaintsApp.showFieldError(field, 'This field is required');
                isValid = false;
            } else if (field.type === 'email' && !ComplaintsApp.isValidEmail(field.value)) {
                ComplaintsApp.showFieldError(field, 'Please enter a valid email address');
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            ComplaintsApp.showAlert('error', 'Please fix the errors below and try again.');
        }
    },

    // Show field error
    showFieldError(field, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'form-error text-[#c75d5d] text-sm mt-1';
        errorElement.textContent = message;

        field.classList.add('border-[#c75d5d]');
        field.parentNode.appendChild(errorElement);
    },

    // Email validation
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },

    // Dismiss alert
    dismissAlert(e) {
        e.preventDefault();
        const alert = e.target.closest('.alert');
        if (alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    },

    // Confirmation dialog
    confirmAction(e) {
        const message = e.target.getAttribute('data-confirm');
        if (!confirm(message)) {
            e.preventDefault();
            return false;
        }
        return true;
    },

    // Show dynamic alert
    showAlert(type, message) {
        const alertContainer = document.querySelector('.alert-container') || document.querySelector('main');
        if (!alertContainer) return;

        const alertElement = document.createElement('div');

        const alertStyles = {
            'success': 'bg-[#7cb369]/10 border-[#7cb369]/20 text-[#7cb369]',
            'error': 'bg-[#c75d5d]/10 border-[#c75d5d]/20 text-[#c75d5d]',
            'warning': 'bg-[#d4a84b]/10 border-[#d4a84b]/20 text-[#d4a84b]',
            'info': 'bg-[#6b9dad]/10 border-[#6b9dad]/20 text-[#6b9dad]'
        };

        const icons = {
            'success': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>',
            'error': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
            'warning': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L12.732 3.5c-.77-.833-1.964-.833-2.732 0L1.732 17.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>',
            'info': '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        };

        alertElement.className = `flex items-center gap-3 p-4 rounded-lg border mb-4 transition-all duration-300 ${alertStyles[type] || alertStyles['info']}`;
        alertElement.innerHTML = `
            ${icons[type] || icons['info']}
            <p class="text-sm flex-1">${message}</p>
            <button type="button" class="hover:opacity-70 transition-opacity" onclick="this.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;

        alertContainer.insertBefore(alertElement, alertContainer.firstChild);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertElement.parentNode) {
                alertElement.style.opacity = '0';
                alertElement.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alertElement.remove();
                }, 300);
            }
        }, 5000);
    },

    // Initialize tooltips
    initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', this.showTooltip);
            element.addEventListener('mouseleave', this.hideTooltip);
        });
    },

    // Show tooltip
    showTooltip(e) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = e.target.getAttribute('data-tooltip');
        tooltip.style.cssText = `
            position: absolute;
            background: #1d211a;
            color: #f5f3eb;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            z-index: 1000;
            pointer-events: none;
            border: 1px solid #333430;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.2);
        `;

        document.body.appendChild(tooltip);

        const rect = e.target.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + window.scrollY + 'px';

        e.target._tooltip = tooltip;
    },

    // Hide tooltip
    hideTooltip(e) {
        if (e.target._tooltip) {
            e.target._tooltip.remove();
            delete e.target._tooltip;
        }
    },

    // Initialize data tables
    initDataTables() {
        const tables = document.querySelectorAll('.data-table');
        tables.forEach(table => {
            this.enhanceTable(table);
        });
    },

    // Enhance table with sorting and filtering
    enhanceTable(table) {
        // Add sorting to headers
        const headers = table.querySelectorAll('th[data-sortable]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.classList.add('hover:text-[#f5f3eb]', 'transition-colors');
            header.addEventListener('click', () => {
                this.sortTable(table, header);
            });
        });

        // Add search if search input exists
        const searchInput = document.querySelector(`[data-table="${table.id}"]`);
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterTable(table, e.target.value);
            });
        }
    },

    // Sort table
    sortTable(table, header) {
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const index = Array.from(header.parentNode.children).indexOf(header);
        const isAscending = !header.classList.contains('sort-desc');

        rows.sort((a, b) => {
            const aText = a.children[index]?.textContent.trim() || '';
            const bText = b.children[index]?.textContent.trim() || '';

            const aNum = parseFloat(aText);
            const bNum = parseFloat(bText);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAscending ? aNum - bNum : bNum - aNum;
            }

            return isAscending ?
                aText.localeCompare(bText) :
                bText.localeCompare(aText);
        });

        table.querySelectorAll('th').forEach(th => {
            th.classList.remove('sort-asc', 'sort-desc');
        });
        header.classList.add(isAscending ? 'sort-asc' : 'sort-desc');

        rows.forEach(row => tbody.appendChild(row));
    },

    // Filter table
    filterTable(table, searchTerm) {
        const tbody = table.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(searchTerm.toLowerCase());
            row.style.display = matches ? '' : 'none';
        });
    },

    // Initialize form enhancements
    initFormEnhancements() {
        // Auto-resize textareas
        const textareas = document.querySelectorAll('textarea[data-auto-resize]');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', this.autoResizeTextarea);
            // Initial resize
            this.autoResizeTextarea({ target: textarea });
        });

        // Character counters
        const countElements = document.querySelectorAll('[data-character-count]');
        countElements.forEach(element => {
            const maxLength = element.getAttribute('maxlength');
            if (maxLength) {
                this.addCharacterCounter(element, maxLength);
            }
        });

        // Focus states for form groups
        const formInputs = document.querySelectorAll('.form-input, input, textarea, select');
        formInputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.closest('.form-group')?.classList.add('focused');
            });
            input.addEventListener('blur', () => {
                input.closest('.form-group')?.classList.remove('focused');
            });
        });
    },

    // Auto-resize textarea
    autoResizeTextarea(e) {
        const textarea = e.target;
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    },

    // Add character counter
    addCharacterCounter(element, maxLength) {
        const counter = document.createElement('div');
        counter.className = 'text-xs text-stone-500 mt-1 text-right';
        element.parentNode.appendChild(counter);

        //function to update an existing record
        const updateCounter = () => {
            const remaining = maxLength - element.value.length;
            counter.textContent = `${remaining} characters remaining`;
            counter.className = remaining < 20 ?
                'text-xs text-[#c75d5d] mt-1 text-right' :
                'text-xs text-stone-500 mt-1 text-right';
        };

        element.addEventListener('input', updateCounter);
        updateCounter();
    },

    // Loading state management
    showLoading(element) {
        element.classList.add('loading', 'opacity-50', 'pointer-events-none');
        element.disabled = true;
    },

    hideLoading(element) {
        element.classList.remove('loading', 'opacity-50', 'pointer-events-none');
        element.disabled = false;
    },

    // AJAX helper
    async request(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };

        try {
            const response = await fetch(url, { ...defaultOptions, ...options });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error('Request failed:', error);
            this.showAlert('error', 'An error occurred. Please try again.');
            throw error;
        }
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    ComplaintsApp.init();
});

// Export for use in other scripts
window.ComplaintsApp = ComplaintsApp;