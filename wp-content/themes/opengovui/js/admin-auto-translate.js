/**
 * OpenGovUI Auto Translation Admin Interface
 * Handles the frontend functionality for the translation manager
 */

(function($) {
    'use strict';

    var translationManager = {
        
        init: function() {
            this.bindEvents();
            this.loadLanguageStatus();
        },

        bindEvents: function() {
            $('#scan-translations').on('click', this.scanTranslations);
            $('#auto-translate').on('click', this.startAutoTranslation);
            $('#backup-translations').on('click', this.createBackup);
        },

        loadLanguageStatus: function() {
            // Auto-scan translations on page load
            this.scanTranslations(null, true);
        },

        scanTranslations: function(e, silent) {
            if (e) e.preventDefault();
            
            if (!silent) {
                $('#scan-translations').text('🔍 Scanning...').prop('disabled', true);
                $('#translation-status').html('<p>Scanning for missing translations...</p>');
            }

            $.ajax({
                url: opengovui_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'opengovui_auto_translate',
                    action_type: 'scan',
                    nonce: opengovui_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        translationManager.displayScanResults(response.data.missing);
                    } else {
                        translationManager.showError('Scan failed: ' + response.data);
                    }
                },
                error: function() {
                    translationManager.showError('Failed to scan translations');
                },
                complete: function() {
                    if (!silent) {
                        $('#scan-translations').text('🔍 Scan Translations').prop('disabled', false);
                    }
                }
            });
        },

        displayScanResults: function(missing) {
            var statusHtml = '';
            var totalMissing = 0;
            var languageStatusHtml = '';

            // Calculate totals
            $.each(missing, function(lang, strings) {
                totalMissing += Object.keys(strings).length;
            });

            // Build status display
            if (totalMissing === 0) {
                statusHtml = '<div class="notice notice-success inline"><p>✅ <strong>All translations are complete!</strong></p></div>';
                $('#auto-translate').prop('disabled', true);
            } else {
                statusHtml = '<div class="notice notice-warning inline">';
                statusHtml += '<p>⚠️ <strong>' + totalMissing + ' missing translations found</strong></p>';
                statusHtml += '<ul>';
                
                $.each(missing, function(lang, strings) {
                    var count = Object.keys(strings).length;
                    if (count > 0) {
                        var langName = translationManager.getLanguageName(lang);
                        statusHtml += '<li><strong>' + langName + ':</strong> ' + count + ' missing strings</li>';
                    }
                });
                
                statusHtml += '</ul></div>';
                $('#auto-translate').prop('disabled', false);
            }

            $('#translation-status').html(statusHtml);

            // Update languages table
            languageStatusHtml = translationManager.buildLanguagesTable(missing);
            $('#languages-table').html(languageStatusHtml);
        },

        buildLanguagesTable: function(missing) {
            var languages = {
                'en': 'English',
                'si': 'Sinhala',
                'ta': 'Tamil'
            };

            var html = '';
            
            $.each(languages, function(code, name) {
                var missingCount = missing[code] ? Object.keys(missing[code]).length : 0;
                var status = '';
                var statusClass = '';
                var completeness = '';

                if (code === 'en') {
                    status = '✅ Base Language';
                    statusClass = 'status-complete';
                    completeness = '100%';
                } else if (missingCount === 0) {
                    status = '✅ Complete';
                    statusClass = 'status-complete';
                    completeness = '100%';
                } else {
                    status = '⚠️ Missing ' + missingCount + ' strings';
                    statusClass = 'status-partial';
                    // This is a rough estimate - you'd need to know total strings for accuracy
                    var estimated = Math.max(0, 100 - (missingCount * 2));
                    completeness = estimated + '%';
                }

                html += '<tr>';
                html += '<td><strong>' + name + '</strong></td>';
                html += '<td><code>' + code + '</code></td>';
                html += '<td class="' + statusClass + '">' + status + '</td>';
                html += '<td>' + completeness + '</td>';
                html += '</tr>';
            });

            return html;
        },

        getLanguageName: function(code) {
            var names = {
                'en': 'English',
                'si': 'Sinhala',
                'ta': 'Tamil'
            };
            return names[code] || code;
        },

        startAutoTranslation: function(e) {
            e.preventDefault();

            var confirmed = confirm(
                'This will automatically translate missing strings using Claude Sonnet 3.7 API.\n\n' +
                'This process may take several minutes and will update your i18n.js file.\n' +
                'A backup will be created automatically.\n\n' +
                'Continue?'
            );

            if (!confirmed) return;

            $('#auto-translate').text('🤖 Translating...').prop('disabled', true);
            $('#progress-container').show();
            $('#progress-text').text('Starting translation process...');

            // Simulate progress (since we can't get real-time progress easily)
            var progressInterval = setInterval(function() {
                var currentWidth = parseInt($('#progress-fill').css('width')) || 0;
                var containerWidth = $('#progress-bar').width();
                var currentPercent = (currentWidth / containerWidth) * 100;
                
                if (currentPercent < 90) {
                    $('#progress-fill').css('width', (currentPercent + 5) + '%');
                }
            }, 500);

            $.ajax({
                url: opengovui_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'opengovui_auto_translate',
                    action_type: 'translate',
                    nonce: opengovui_ajax.nonce
                },
                timeout: 120000, // 2 minutes timeout
                success: function(response) {
                    clearInterval(progressInterval);
                    $('#progress-fill').css('width', '100%');
                    
                    if (response.success) {
                        $('#progress-text').html('✅ Translation completed successfully!');
                        
                        setTimeout(function() {
                            translationManager.showSuccess(
                                'Translation completed! ' + 
                                (response.data.details.updated_strings || 0) + 
                                ' strings were translated. Backup saved as: ' + 
                                (response.data.details.backup_file || 'Unknown')
                            );
                            
                            // Refresh the scan
                            translationManager.scanTranslations(null, true);
                            
                            $('#progress-container').hide();
                            $('#progress-fill').css('width', '0%');
                        }, 2000);
                    } else {
                        translationManager.showError('Translation failed: ' + response.data);
                    }
                },
                error: function(xhr, status, error) {
                    clearInterval(progressInterval);
                    if (status === 'timeout') {
                        translationManager.showError('Translation timed out. Please try again or check your API key.');
                    } else {
                        translationManager.showError('Translation failed: ' + error);
                    }
                },
                complete: function() {
                    $('#auto-translate').text('🤖 Auto-Translate Missing Strings').prop('disabled', false);
                }
            });
        },

        createBackup: function(e) {
            e.preventDefault();

            $('#backup-translations').text('💾 Creating Backup...').prop('disabled', true);

            $.ajax({
                url: opengovui_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'opengovui_auto_translate',
                    action_type: 'backup',
                    nonce: opengovui_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        translationManager.showSuccess('Backup created: ' + response.data.backup_file);
                    } else {
                        translationManager.showError('Backup failed: ' + response.data);
                    }
                },
                error: function() {
                    translationManager.showError('Failed to create backup');
                },
                complete: function() {
                    $('#backup-translations').text('💾 Backup Current Translations').prop('disabled', false);
                }
            });
        },

        showSuccess: function(message) {
            var notice = $('<div class="notice notice-success is-dismissible"><p><strong>Success:</strong> ' + message + '</p></div>');
            $('.translation-manager-container').prepend(notice);
            
            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                notice.fadeOut(function() {
                    notice.remove();
                });
            }, 5000);
        },

        showError: function(message) {
            var notice = $('<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> ' + message + '</p></div>');
            $('.translation-manager-container').prepend(notice);
            
            // Auto-dismiss after 8 seconds
            setTimeout(function() {
                notice.fadeOut(function() {
                    notice.remove();
                });
            }, 8000);
        }
    };

    // Initialize when document is ready
    $(document).ready(function() {
        translationManager.init();
    });

})(jQuery); 