/**
 * OpenGovUI Multilingual Support
 * Integrates with Polylang for WordPress multilingual functionality
 */

(function($) {
    'use strict';

    var OpenGovMultilingual = {
        
        init: function() {
            this.bindEvents();
            this.initializeLanguageSync();
            this.updateContent();
            this.setupLanguageSwitcher();
        },
        
        initializeLanguageSync: function() {
            // Wait for i18nManager to be available, then sync languages
            var self = this;
            var checkI18n = function() {
                if (window.i18nManager && typeof polylang_data !== 'undefined') {
                    var currentLang = polylang_data.current_lang;
                    var i18nLang = polylang_data.i18n_lang_map[currentLang] || 'en';
                    
                    // Set the initial language to match WordPress
                    window.i18nManager.setLanguage(i18nLang);
                    window.i18nManager.updateContent();
                } else {
                    // Retry after a short delay if not ready yet
                    setTimeout(checkI18n, 100);
                }
            };
            checkI18n();
        },

        bindEvents: function() {
            // Handle language switching - let WordPress handle the redirect
            $(document).on('click', '.polylang-switcher a', function(e) {
                var $link = $(this);
                var href = $link.attr('href');
                
                // If this is a proper Polylang link with href, let it redirect naturally
                if (href && href !== '#' && href !== window.location.href) {
                    // Let the browser handle the redirect to WordPress language URL
                    return true;
                }
                
                // Fallback for manual language switching
                e.preventDefault();
                var langCode = $link.attr('lang') || $link.data('lang') || $link.attr('class').match(/lang-(\w+)/)?.[1];
                
                // Convert WordPress language codes to our i18n system
                var i18nLangMap = {
                    'en_US': 'en',
                    'en_GB': 'en',
                    'en': 'en',
                    'si_LK': 'si', 
                    'si': 'si',
                    'ta_LK': 'ta',
                    'ta': 'ta'
                };
                
                var targetLang = i18nLangMap[langCode] || 'en';
                
                // Update the frontend i18n system immediately for static content
                if (window.i18nManager) {
                    window.i18nManager.setLanguage(targetLang);
                    window.i18nManager.updateContent();
                }
                
                // If we have WordPress AJAX data, try to update dynamic content
                if (typeof polylang_ajax !== 'undefined') {
                    this.updateWordPressContent(langCode);
                }
            });

            // Handle fallback language switching for non-Polylang links
            $(document).on('click', '.language-selector a:not(.polylang-switcher a)', function(e) {
                e.preventDefault();
                var $link = $(this);
                var lang = $link.attr('lang');
                
                if (lang && window.i18nManager) {
                    window.i18nManager.setLanguage(lang);
                    window.i18nManager.updateContent();
                    
                    // Update active state
                    $link.closest('.language-selector').find('a').removeClass('active');
                    $link.addClass('active');
                }
            });

            // Handle AJAX content updates when language changes
            if (typeof polylang_ajax !== 'undefined') {
                this.setupAjaxUpdates();
            }
        },

        setupLanguageSwitcher: function() {
            // Enhance the language switcher with better UX
            $('.polylang-switcher a').each(function() {
                var $link = $(this);
                var lang = $link.attr('lang');
                
                // Add language codes for better accessibility
                if (lang) {
                    $link.attr('hreflang', lang);
                    $link.attr('title', 'Switch to ' + $link.text());
                }
            });

            // Add keyboard navigation
            $('.polylang-switcher').on('keydown', 'a', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this)[0].click();
                }
            });
        },

        setupAjaxUpdates: function() {
            var self = this;
            
            // Update featured services when language changes
            self.updateFeaturedServices();
            
            // Update categories when language changes  
            self.updateCategories();
            
            // Update government updates when language changes
            self.updateGovernmentUpdates();
        },

        updateFeaturedServices: function() {
            if (typeof polylang_ajax === 'undefined') return;

            var $servicesGrid = $('.services-grid');
            if ($servicesGrid.length === 0) return;

            $.ajax({
                url: polylang_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_featured_services',
                    lang: polylang_ajax.current_lang,
                    nonce: polylang_ajax.nonce
                },
                success: function(response) {
                    if (response.success && response.data.services) {
                        self.renderServices(response.data.services, $servicesGrid);
                    }
                }
            });
        },

        updateCategories: function() {
            if (typeof polylang_ajax === 'undefined') return;

            var $categoriesGrid = $('.topics-grid');
            if ($categoriesGrid.length === 0) return;

            $.ajax({
                url: polylang_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_service_categories',
                    lang: polylang_ajax.current_lang,
                    nonce: polylang_ajax.nonce
                },
                success: function(response) {
                    if (response.success && response.data.categories) {
                        self.renderCategories(response.data.categories, $categoriesGrid);
                    }
                }
            });
        },

        updateGovernmentUpdates: function() {
            if (typeof polylang_ajax === 'undefined') return;

            var $updatesGrid = $('.updates-grid');
            if ($updatesGrid.length === 0) return;

            $.ajax({
                url: polylang_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_government_updates',
                    lang: polylang_ajax.current_lang,
                    nonce: polylang_ajax.nonce
                },
                success: function(response) {
                    if (response.success && response.data.updates) {
                        self.renderUpdates(response.data.updates, $updatesGrid);
                    }
                }
            });
        },

        renderServices: function(services, $container) {
            var html = '';
            
            services.forEach(function(service) {
                html += '<a href="' + service.url + '" class="service-card">';
                html += '<div class="service-icon">';
                html += '<i class="' + service.icon + '"></i>';
                html += '</div>';
                html += '<h3>' + service.title + '</h3>';
                html += '<p>' + service.description + '</p>';
                html += '</a>';
            });

            $container.fadeOut(200, function() {
                $(this).html(html).fadeIn(200);
            });
        },

        renderCategories: function(categories, $container) {
            var html = '';
            
            categories.forEach(function(category) {
                html += '<a href="' + category.url + '" class="topic-card">';
                html += '<h3>';
                html += '<i class="' + category.icon + '"></i>';
                html += '<span>' + category.title + '</span>';
                html += '</h3>';
                html += '<p>' + category.description + '</p>';
                html += '</a>';
            });

            $container.fadeOut(200, function() {
                $(this).html(html).fadeIn(200);
            });
        },

        renderUpdates: function(updates, $container) {
            var html = '';
            
            updates.forEach(function(update) {
                html += '<article class="update-card">';
                html += '<h3><a href="' + update.url + '">' + update.title + '</a></h3>';
                html += '<p>' + update.description + '</p>';
                html += '<time>' + update.date + '</time>';
                html += '</article>';
            });

            $container.fadeOut(200, function() {
                $(this).html(html).fadeIn(200);
            });
        },

        updateContent: function() {
            // Update any dynamic content based on current language
            this.updateDocumentLang();
            
            // Sync with the main i18n system if available
            if (window.i18nManager && typeof polylang_data !== 'undefined') {
                var currentLang = polylang_data.current_lang;
                var i18nLang = polylang_data.i18n_lang_map[currentLang] || 'en';
                
                // Only update if different from current
                if (window.i18nManager.currentLang !== i18nLang) {
                    window.i18nManager.setLanguage(i18nLang);
                    window.i18nManager.updateContent();
                }
            }
        },

        updateDocumentLang: function() {
            if (typeof polylang_ajax !== 'undefined' && polylang_ajax.current_lang) {
                $('html').attr('lang', polylang_ajax.current_lang);
                
                // Update direction for RTL languages if needed
                var rtlLangs = ['ar', 'he', 'fa', 'ur'];
                var direction = rtlLangs.includes(polylang_ajax.current_lang) ? 'rtl' : 'ltr';
                $('html').attr('dir', direction);
            }
        },

        updateWordPressContent: function(langCode) {
            // Update WordPress content via AJAX
            var self = this;
            
            // Update services
            $.ajax({
                url: '/wp-json/opengovui/v1/featured-services',
                data: { lang: langCode },
                success: function(response) {
                    if (response && response.length > 0) {
                        self.renderServices(response);
                    }
                }
            });
            
            // Update categories
            $.ajax({
                url: '/wp-json/opengovui/v1/categories',
                data: { lang: langCode },
                success: function(response) {
                    if (response && response.length > 0) {
                        self.renderCategories(response);
                    }
                }
            });
        },

        renderServices: function(services) {
            var $grid = $('.services-grid');
            if ($grid.length === 0) return;
            
            $grid.empty();
            services.slice(0, 4).forEach(function(service) {
                var $card = $('<a href="' + (service.permalink || '#') + '" class="service-card">' +
                    '<div class="service-icon"><i class="' + (service.icon || 'fa-solid fa-file') + '"></i></div>' +
                    '<h3>' + service.title + '</h3>' +
                    '<p>' + service.description + '</p>' +
                    '</a>');
                $grid.append($card);
            });
        },

        renderCategories: function(categories) {
            var $grid = $('.topics-grid');
            if ($grid.length === 0) return;
            
            $grid.empty();
            categories.forEach(function(category) {
                var $card = $('<a href="' + (category.permalink || '#') + '" class="topic-card">' +
                    '<h3><i class="' + (category.icon || 'fa-solid fa-folder') + '"></i>' +
                    '<span>' + category.title + '</span></h3>' +
                    '<p>' + category.description + '</p>' +
                    '</a>');
                if (category.color) {
                    $card.css('border-color', category.color);
                }
                $grid.append($card);
            });
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        OpenGovMultilingual.init();
    });

    // Expose to global scope for external access
    window.OpenGovMultilingual = OpenGovMultilingual;

})(jQuery); 