// Initialize charts when the DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    initializeInteractivity();
});

/**
 * Initialize all data visualization charts
 */
function initializeCharts() {
    // Chart.js global options for consistency
    Chart.defaults.font.family = "'Instrument Sans', ui-sans-serif, system-ui, sans-serif";
    Chart.defaults.color = '#9ca3af';
    Chart.defaults.borderColor = 'rgba(0, 255, 221, 0.1)';
    Chart.defaults.plugins.legend.labels.color = '#e5e7eb';
    
    // Initialize Line Chart
    initializeLineChart();
    
    // Initialize Bar Chart
    initializeBarChart();
    
    // Initialize Donut Chart
    initializeDonutChart();
}

/**
 * Line Chart - Economic Growth Trend
 */
function initializeLineChart() {
    const ctx = document.getElementById('lineChart');
    if (!ctx) return;

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(0, 255, 221, 0.3)');
    gradient.addColorStop(1, 'rgba(0, 255, 221, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Economic Growth (%)',
                    data: [12, 19, 3, 5, 2, 3, 14, 18, 16, 15, 17, 21],
                    borderColor: '#00ffdd',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#00ffdd',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#00d4ff',
                    pointHoverBorderColor: '#ffffff',
                    hoverBackgroundColor: 'rgba(0, 255, 221, 0.1)',
                },
                {
                    label: 'Growth Projection (%)',
                    data: [10, 17, 5, 7, 4, 5, 12, 16, 18, 19, 20, 23],
                    borderColor: '#00d4ff',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: false,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 500
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(10, 14, 39, 0.95)',
                    titleColor: '#00ffdd',
                    bodyColor: '#e5e7eb',
                    borderColor: '#00ffdd',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.parsed.y.toFixed(1) + '%';
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 25,
                    grid: {
                        color: 'rgba(0, 255, 221, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
}

/**
 * Bar Chart - Regional Distribution
 */
function initializeBarChart() {
    const ctx = document.getElementById('barChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Pampanga', 'Laguna', 'Bulacan', 'Nueva Ecija', 'Batangas', 'Cavite'],
            datasets: [
                {
                    label: 'Q3 2026',
                    data: [320, 280, 250, 220, 190, 170],
                    backgroundColor: 'rgba(0, 255, 221, 0.8)',
                    borderColor: '#00ffdd',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: '#00ffdd',
                    hoverBorderColor: '#ffffff'
                },
                {
                    label: 'Q4 2026 (Projected)',
                    data: [360, 310, 280, 250, 220, 200],
                    backgroundColor: 'rgba(0, 212, 255, 0.6)',
                    borderColor: '#00d4ff',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: '#00d4ff',
                    hoverBorderColor: '#ffffff'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: undefined,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: 500
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(10, 14, 39, 0.95)',
                    titleColor: '#00ffdd',
                    bodyColor: '#e5e7eb',
                    borderColor: '#00ffdd',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 400,
                    grid: {
                        color: 'rgba(0, 255, 221, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                }
            }
        }
    });
}

/**
 * Donut Chart - Project Status Distribution
 */
function initializeDonutChart() {
    const ctx = document.getElementById('donutChart');
    if (!ctx) return;

    const total = 248;
    const data = [
        { label: 'Completed', value: 87, color: '#10b981' },
        { label: 'In Progress', value: 98, color: '#00ffdd' },
        { label: 'Pending', value: 45, color: '#f59e0b' },
        { label: 'On Hold', value: 18, color: '#ef4444' }
    ];

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(d => d.label),
            datasets: [
                {
                    data: data.map(d => d.value),
                    backgroundColor: data.map(d => d.color),
                    borderColor: '#0a0e27',
                    borderWidth: 3,
                    hoverBorderColor: '#ffffff',
                    hoverBorderWidth: 4,
                    hoverOffset: 8
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(10, 14, 39, 0.95)',
                    titleColor: '#00ffdd',
                    bodyColor: '#e5e7eb',
                    borderColor: '#00ffdd',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const index = context.dataIndex;
                            const label = context.label || '';
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
}

/**
 * Initialize interactive features
 */
function initializeInteractivity() {
    // Add animation to elements on scroll
    setupScrollAnimations();
    
    // Handle card hover effects
    setupCardHovers();
    
    // Add real-time data updates (simulate)
    setupDataUpdates();
}

/**
 * Setup scroll-based animations
 */
function setupScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all glass cards
    document.querySelectorAll('.glass-card').forEach(card => {
        card.style.opacity = '0';
        observer.observe(card);
    });
}

/**
 * Setup card hover effects and interactions
 */
function setupCardHovers() {
    const cards = document.querySelectorAll('.glass-card');
    
    cards.forEach(card => {
        // Enhanced hover effect
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // KPI cards click interaction
    document.querySelectorAll('.glass-card:not(.glass-card-lg)').forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function() {
            this.classList.add('animate-glow');
            setTimeout(() => this.classList.remove('animate-glow'), 3000);
        });
    });
}

/**
 * Simulate real-time data updates
 */
function setupDataUpdates() {
    // Update metrics periodically
    setInterval(function() {
        updateMetrics();
    }, 5000);
}

/**
 * Update metric values with animation
 */
function updateMetrics() {
    const metrics = document.querySelectorAll('.metric');
    
    metrics.forEach(metric => {
        const value = metric.querySelector('.text-lg, .text-3xl');
        if (value) {
            // Add subtle pulse animation
            value.style.animation = 'none';
            setTimeout(() => {
                value.style.animation = 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite';
            }, 10);
        }
    });
}

/**
 * Export functionality
 */
function exportData(format = 'csv') {
    console.log('Exporting data as ' + format);
    // Implementation would depend on backend
}

/**
 * Utility function to format currency
 */
function formatCurrency(value) {
    return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(value);
}

/**
 * Utility function to format percentages
 */
function formatPercent(value, decimals = 1) {
    return (Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals)).toFixed(decimals) + '%';
}

// Export functions for external use
window.DashboardUtils = {
    formatCurrency,
    formatPercent,
    exportData
};
