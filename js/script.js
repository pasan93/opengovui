document.addEventListener('DOMContentLoaded', function() {
    // Initialize i18n
    window.i18n.initialize();
    
    // Initialize Components
    initializeSearch();
    initializeUpdates();
    initializeServiceCards();
    initializeAccessibility();
    initializeAnalytics();
});

// Mock updates data - In a real application, this could be loaded from a CMS
const updates = {
    en: [
        {
            title: 'Digital Services Transformation',
            category: 'Services',
            date: '2024-03-13',
            description: 'New online portal launched for streamlined government services.',
            priority: 'high',
            link: '#'
        },
        {
            title: 'COVID-19 Health Guidelines Update',
            category: 'Health',
            date: '2024-03-12',
            description: 'Latest health and safety guidelines for public spaces.',
            priority: 'medium',
            link: '#'
        },
        {
            title: 'Education Sector Development',
            category: 'Education',
            date: '2024-03-11',
            description: 'New initiatives for digital learning and school infrastructure.',
            priority: 'normal',
            link: '#'
        }
    ],
    si: [
        {
            title: 'ඩිජිටල් සේවා පරිවර්තනය',
            category: 'සේවා',
            date: '2024-03-13',
            description: 'වඩාත් කාර්යක්ෂම රාජ්‍ය සේවා සඳහා නව මාර්ගගත පෝර්ටලයක් දියත් කර ඇත.',
            priority: 'high',
            link: '#'
        },
        {
            title: 'කොවිඩ්-19 සෞඛ්‍ය මාර්ගෝපදේශ යාවත්කාලීන කිරීම',
            category: 'සෞඛ්‍ය',
            date: '2024-03-12',
            description: 'පොදු ස්ථාන සඳහා නවතම සෞඛ්‍ය හා ආරක්ෂණ මාර්ගෝපදේශ.',
            priority: 'medium',
            link: '#'
        },
        {
            title: 'අධ්‍යාපන අංශ සංවර්ධනය',
            category: 'අධ්‍යාපන',
            date: '2024-03-11',
            description: 'ඩිජිටල් ඉගෙනුම් හා පාසල් යටිතල පහසුකම් සඳහා නව මුලපිරීම්.',
            priority: 'normal',
            link: '#'
        }
    ],
    ta: [
        {
            title: 'டிஜிட்டல் சேவைகள் மாற்றம்',
            category: 'சேவைகள்',
            date: '2024-03-13',
            description: 'விரைவான அரசு சேவைகளுக்கான புதிய இணைய வாயில் அறிமுகம்.',
            priority: 'high',
            link: '#'
        },
        {
            title: 'கோவிட்-19 சுகாதார வழிகாட்டுதல்கள் புதுப்பிப்பு',
            category: 'சுகாதாரம்',
            date: '2024-03-12',
            description: 'பொது இடங்களுக்கான புதிய சுகாதார மற்றும் பாதுகாப்பு வழிகாட்டுதல்கள்.',
            priority: 'medium',
            link: '#'
        },
        {
            title: 'கல்வித்துறை மேம்பாடு',
            category: 'கல்வி',
            date: '2024-03-11',
            description: 'டிஜிட்டல் கற்றல் மற்றும் பள்ளி உள்கட்டமைப்புக்கான புதிய முயற்சிகள்.',
            priority: 'normal',
            link: '#'
        }
    ]
};

// Search Functionality
function initializeSearch() {
    const searchForm = document.querySelector('.search-wrapper');
    const searchInput = document.querySelector('#search-input');
    let searchTimeout;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();
        
        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                showSearchSuggestions(query);
            }, 300);
        } else {
            clearSearchSuggestions();
        }
    });

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const query = searchInput.value.trim();
        if (query) {
            handleSearch(query);
        }
    });

    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target)) {
            clearSearchSuggestions();
        }
    });
}

function showSearchSuggestions(query) {
    const suggestions = getSearchSuggestions(query);
    displaySearchSuggestions(suggestions);
}

function getSearchSuggestions(query) {
    const currentLang = window.i18n.getCurrentLanguage();
    const commonSearches = {
        en: [
            'Passport application',
            'National ID renewal',
            'Birth certificate',
            'Vehicle registration',
            'Business registration'
        ],
        si: [
            'විදේශ ගමන් බලපත්‍රය',
            'ජාතික හැඳුනුම්පත අලුත් කිරීම',
            'උප්පැන්න සහතිකය',
            'වාහන ලියාපදිංචිය',
            'ව්‍යාපාර ලියාපදිංචිය'
        ],
        ta: [
            'கடவுச்சீட்டு விண்ணப்பம்',
            'தேசிய அடையாள அட்டை புதுப்பித்தல்',
            'பிறப்பு சான்றிதழ்',
            'வாகன பதிவு',
            'வணிக பதிவு'
        ]
    };

    return commonSearches[currentLang].filter(item => 
        item.toLowerCase().includes(query.toLowerCase())
    );
}

function displaySearchSuggestions(suggestions) {
    clearSearchSuggestions();

    if (!suggestions.length) return;

    const suggestionsList = document.createElement('ul');
    suggestionsList.className = 'search-suggestions';
    
    suggestions.forEach(suggestion => {
        const li = document.createElement('li');
        li.textContent = suggestion;
        li.addEventListener('click', () => {
            document.querySelector('#search-input').value = suggestion;
            clearSearchSuggestions();
            handleSearch(suggestion);
        });
        suggestionsList.appendChild(li);
    });

    document.querySelector('.search-wrapper').appendChild(suggestionsList);
}

function clearSearchSuggestions() {
    const existing = document.querySelector('.search-suggestions');
    if (existing) existing.remove();
}

function handleSearch(query) {
    const button = document.querySelector('.search-wrapper button');
    const originalContent = button.innerHTML;
    
    // Show loading state
    button.innerHTML = `<i class="fas fa-spinner fa-spin"></i>`;
    button.disabled = true;

    // Simulate search - In production, this would call an API
    setTimeout(() => {
        button.innerHTML = originalContent;
        button.disabled = false;
        // For demo, just show an alert with the search query
        alert(`Search query: ${query}`);
    }, 500);
}

// Updates Section
function initializeUpdates() {
    const updatesGrid = document.querySelector('.updates-grid');
    if (!updatesGrid) return;

    const currentLang = window.i18n.getCurrentLanguage();
    const currentUpdates = updates[currentLang] || updates.en;

    updatesGrid.innerHTML = ''; // Clear existing updates

    currentUpdates.forEach((update, index) => {
        const updateCard = createUpdateCard(update);
        
        // Stagger animation
        setTimeout(() => {
            updateCard.style.opacity = '1';
            updateCard.style.transform = 'translateY(0)';
        }, index * 100);
        
        updatesGrid.appendChild(updateCard);
    });
}

function createUpdateCard(update) {
    const card = document.createElement('article');
    card.className = `update-card priority-${update.priority}`;
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'all 0.3s ease-out';

    const date = new Date(update.date);
    const formattedDate = new Intl.DateTimeFormat(window.i18n.getCurrentLanguage(), {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    }).format(date);

    card.innerHTML = `
        <span class="category-tag">${update.category}</span>
        <h3>${update.title}</h3>
        <time datetime="${update.date}">${formattedDate}</time>
        <p>${update.description}</p>
        <a href="${update.link}" class="read-more">
            ${window.i18n.getTranslation('updates.readMore')}
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </a>
    `;

    return card;
}

// Service Cards Animation
function initializeServiceCards() {
    const cards = document.querySelectorAll('.service-card');
    
    cards.forEach(card => {
        const icon = card.querySelector('.service-icon');
        
        // Mouse interactions
        card.addEventListener('mouseenter', () => {
            icon.style.transform = 'scale(1.2)';
        });

        card.addEventListener('mouseleave', () => {
            icon.style.transform = 'scale(1)';
        });

        // Touch interactions
        card.addEventListener('touchstart', () => {
            icon.style.transform = 'scale(1.2)';
        });

        card.addEventListener('touchend', () => {
            icon.style.transform = 'scale(1)';
        });
    });
}

// Accessibility Enhancements
function initializeAccessibility() {
    // Keyboard navigation indicator
    document.addEventListener('keydown', e => {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });

    document.addEventListener('mousedown', () => {
        document.body.classList.remove('keyboard-nav');
    });

    // Search shortcut
    document.addEventListener('keydown', e => {
        if (e.key === '/' && !e.ctrlKey && !e.metaKey) {
            e.preventDefault();
            document.querySelector('#search-input')?.focus();
        }
    });
}

// Analytics
function initializeAnalytics() {
    // Page load timing
    window.addEventListener('load', () => {
        if (window.performance) {
            const timing = performance.timing;
            const pageLoad = timing.loadEventEnd - timing.navigationStart;
            logAnalytics('timing', 'page_load', pageLoad);
        }
    });

    // Track interactions
    document.addEventListener('click', e => {
        const link = e.target.closest('a');
        if (link) {
            logAnalytics('click', 'link', {
                href: link.href,
                text: link.textContent.trim(),
                lang: window.i18n.getCurrentLanguage()
            });
        }
    });

    // Track searches
    document.querySelector('.search-wrapper')?.addEventListener('submit', e => {
        const query = document.querySelector('#search-input').value;
        logAnalytics('action', 'search', {
            query,
            lang: window.i18n.getCurrentLanguage()
        });
    });

    // Track language changes
    window.i18n.subscribe((newLang) => {
        logAnalytics('action', 'language_change', {
            from: window.i18n.getCurrentLanguage(),
            to: newLang
        });
        initializeUpdates(); // Refresh updates when language changes
    });
}

function logAnalytics(type, action, data) {
    // In production, this would send to an analytics service
    console.log(`Analytics: ${type} - ${action}`, data);
}

// Error Handling
window.addEventListener('error', e => {
    console.error('An error occurred:', e.error);
    logAnalytics('error', 'javascript', {
        message: e.error.message,
        stack: e.error.stack,
        lang: window.i18n.getCurrentLanguage()
    });
});

// Helper Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// WordPress Integration
class WordPressIntegration {
    constructor() {
        this.wpApiBase = window.location.origin + '/wp-json/opengovui/v1';
        this.useWordPress = false;
        this.init();
    }

    async init() {
        await this.checkWordPressAvailability();
        if (this.useWordPress) {
            await this.loadWordPressContent();
        }
    }

    async checkWordPressAvailability() {
        try {
            const response = await fetch(this.wpApiBase + '/featured-services');
            if (response.ok) {
                this.useWordPress = true;
                console.log('WordPress integration available');
            }
        } catch (error) {
            console.log('WordPress not available, using static content');
        }
    }

    async loadWordPressContent() {
        try {
            await Promise.all([
                this.loadFeaturedServices(),
                this.loadCategories(),
                this.loadWordPressUpdates()
            ]);
        } catch (error) {
            console.error('Error loading WordPress content:', error);
        }
    }

    async loadFeaturedServices() {
        try {
            const response = await fetch(this.wpApiBase + '/featured-services');
            const services = await response.json();
            
            const servicesGrid = document.querySelector('.services-grid');
            if (servicesGrid && services.length > 0) {
                servicesGrid.innerHTML = '';
                
                services.forEach(service => {
                    const serviceCard = this.createServiceCard(service);
                    servicesGrid.appendChild(serviceCard);
                });
            }
        } catch (error) {
            console.error('Error loading featured services:', error);
        }
    }

    async loadCategories() {
        try {
            const response = await fetch(this.wpApiBase + '/categories');
            const categories = await response.json();
            
            const topicsGrid = document.querySelector('.topics-grid');
            if (topicsGrid && categories.length > 0) {
                topicsGrid.innerHTML = '';
                
                categories.forEach(category => {
                    const categoryCard = this.createCategoryCard(category);
                    topicsGrid.appendChild(categoryCard);
                });
            }
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    async loadWordPressUpdates() {
        try {
            const response = await fetch(this.wpApiBase + '/updates?limit=3');
            const updates = await response.json();
            
            const updatesGrid = document.querySelector('.updates-grid');
            if (updatesGrid && updates.length > 0) {
                updatesGrid.innerHTML = '';
                
                updates.forEach(update => {
                    const updateCard = this.createUpdateCard(update);
                    updatesGrid.appendChild(updateCard);
                });
            }
        } catch (error) {
            console.error('Error loading WordPress updates:', error);
            // Fallback to static updates if WordPress fails
            initializeUpdates();
        }
    }

    createServiceCard(service) {
        const card = document.createElement('a');
        card.href = service.permalink || service.url || '#';
        card.className = 'service-card';
        
        card.innerHTML = `
            <div class="service-icon">
                <i class="${service.icon || 'fa-solid fa-file'}"></i>
            </div>
            <h3>${service.title}</h3>
            <p>${service.description}</p>
        `;
        
        // Add animation events
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-4px)';
            card.style.boxShadow = '0 8px 24px rgba(0,0,0,0.12)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
        
        return card;
    }

    createCategoryCard(category) {
        const card = document.createElement('a');
        card.href = category.permalink || '#';
        card.className = 'topic-card';
        
        if (category.color) {
            card.style.borderColor = category.color;
        }
        
        card.innerHTML = `
            <h3>
                <i class="${category.icon || 'fa-solid fa-folder'}"></i>
                <span>${category.title}</span>
            </h3>
            <p>${category.description}</p>
        `;
        
        // Add animation events
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-4px)';
            card.style.boxShadow = '0 8px 24px rgba(0,0,0,0.12)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
        
        return card;
    }

    createUpdateCard(update) {
        const card = document.createElement('article');
        card.className = 'update-card';
        
        card.innerHTML = `
            <h3><a href="${update.permalink}">${update.title}</a></h3>
            <p class="update-excerpt">${update.excerpt}</p>
            <div class="update-meta">
                <time datetime="${update.date}">${update.date_formatted}</time>
                <a href="${update.permalink}" class="read-more" data-i18n="updates.readMore">Read more</a>
            </div>
        `;
        
        return card;
    }
}

// Initialize WordPress integration after DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add a small delay to ensure other scripts are loaded
    setTimeout(() => {
        window.wpIntegration = new WordPressIntegration();
    }, 500);
});