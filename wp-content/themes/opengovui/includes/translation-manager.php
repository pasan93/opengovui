<?php
/**
 * OpenGovUI Translation Manager
 * Automatically fills missing translations using Claude Sonnet 3.7 API
 */

class OpenGovUI_Translation_Manager {
    
    private $api_key;
    private $languages = ['en', 'si', 'ta'];
    private $language_names = [
        'en' => 'English',
        'si' => 'Sinhala', 
        'ta' => 'Tamil'
    ];
    private $js_file_path;
    
    public function __construct() {
        $this->api_key = defined('CLAUDE_API_KEY') ? CLAUDE_API_KEY : get_option('opengovui_claude_api_key', '');
        $this->js_file_path = ABSPATH . 'js/i18n.js';
    }
    
    /**
     * Initialize hooks and admin interface
     */
    public function init() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('wp_ajax_opengovui_auto_translate', array($this, 'handle_auto_translate'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    /**
     * Add admin menu item
     */
    public function add_admin_menu() {
        add_management_page(
            'Auto Translation',
            'Auto Translation',
            'manage_options',
            'opengovui-auto-translate',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook === 'tools_page_opengovui-auto-translate') {
            wp_enqueue_script('opengovui-auto-translate', get_template_directory_uri() . '/js/admin-auto-translate.js', array('jquery'), '1.0.0', true);
            wp_localize_script('opengovui-auto-translate', 'opengovui_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('opengovui_auto_translate_nonce')
            ));
        }
    }
    
    /**
     * Admin page HTML
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>🌐 Auto Translation Manager</h1>
            <div class="notice notice-info">
                <p><strong>Claude Sonnet 3.7 API Integration</strong> - Automatically fill missing translations</p>
            </div>
            
            <?php if (empty($this->api_key)): ?>
                <div class="notice notice-error">
                    <p><strong>⚠️ Claude API Key Required</strong></p>
                    <p>To use auto-translation, please add your Claude API key to your wp-config.php file:</p>
                    <code>define('CLAUDE_API_KEY', 'your_api_key_here');</code>
                    <p>Or set it in the database: <a href="<?php echo admin_url('options-general.php'); ?>">Settings</a></p>
                </div>
            <?php endif; ?>
            
            <div class="translation-manager-container" style="max-width: 800px;">
                <div class="card">
                    <h2>🔍 Translation Status</h2>
                    <div id="translation-status">
                        <p>Click "Scan Translations" to check for missing strings...</p>
                    </div>
                </div>
                
                <div class="card">
                    <h2>⚡ Actions</h2>
                    <div style="margin: 20px 0;">
                        <button id="scan-translations" class="button button-secondary" style="margin-right: 10px;">
                            🔍 Scan Translations
                        </button>
                        <button id="auto-translate" class="button button-primary" disabled>
                            🤖 Auto-Translate Missing Strings
                        </button>
                        <button id="backup-translations" class="button button-secondary" style="margin-left: 10px;">
                            💾 Backup Current Translations
                        </button>
                    </div>
                    <div id="progress-container" style="display: none;">
                        <div id="progress-bar" style="background: #f0f0f0; border-radius: 3px; overflow: hidden;">
                            <div id="progress-fill" style="background: #0073aa; height: 20px; width: 0%; transition: width 0.3s;"></div>
                        </div>
                        <div id="progress-text" style="margin-top: 10px; font-style: italic;"></div>
                    </div>
                </div>
                
                <div class="card">
                    <h2>📊 Current Languages</h2>
                    <table class="widefat">
                        <thead>
                            <tr>
                                <th>Language</th>
                                <th>Code</th>
                                <th>Status</th>
                                <th>Completeness</th>
                            </tr>
                        </thead>
                        <tbody id="languages-table">
                            <tr><td colspan="4">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="card">
                    <h2>🛠️ API Configuration</h2>
                    <?php if (!empty($this->api_key)): ?>
                        <p>✅ Claude API Key: <code>***<?php echo substr($this->api_key, -4); ?></code></p>
                    <?php else: ?>
                        <form method="post" action="options.php">
                            <?php settings_fields('opengovui_translation_settings'); ?>
                            <table class="form-table">
                                <tr>
                                    <th scope="row">Claude API Key</th>
                                    <td>
                                        <input type="password" name="opengovui_claude_api_key" value="<?php echo esc_attr(get_option('opengovui_claude_api_key')); ?>" class="regular-text" />
                                        <p class="description">Enter your Claude Sonnet 3.7 API key</p>
                                    </td>
                                </tr>
                            </table>
                            <?php submit_button('Save API Key'); ?>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <style>
        .translation-manager-container .card {
            background: white;
            border: 1px solid #c3c4c7;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
        }
        
        .translation-manager-container h2 {
            margin-top: 0;
            font-size: 18px;
        }
        
        #translation-status {
            background: #f9f9f9;
            border-left: 4px solid #0073aa;
            padding: 15px;
            margin: 15px 0;
        }
        
        .status-complete { color: #46b450; }
        .status-partial { color: #ffb900; }
        .status-missing { color: #dc3232; }
        </style>
        <?php
    }
    
    /**
     * Parse the i18n.js file to extract current translations
     */
    public function parse_translations() {
        if (!file_exists($this->js_file_path)) {
            return new WP_Error('file_not_found', 'i18n.js file not found');
        }
        
        $content = file_get_contents($this->js_file_path);
        
        // Extract the translations object using regex
        preg_match('/this\.translations\s*=\s*(\{.*?\});/s', $content, $matches);
        
        if (!isset($matches[1])) {
            return new WP_Error('parse_error', 'Could not parse translations object');
        }
        
        // Clean up the JS object to make it valid JSON
        $js_object = $matches[1];
        
        // Convert JavaScript object to JSON
        // This is a simplified approach - in production you might want a more robust parser
        $json_string = preg_replace('/(\w+):\s*/', '"$1": ', $js_object);
        $json_string = str_replace("'", '"', $json_string);
        
        $translations = json_decode($json_string, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new WP_Error('json_error', 'Failed to parse translations as JSON: ' . json_last_error_msg());
        }
        
        return $translations;
    }
    
    /**
     * Find missing translation strings
     */
    public function find_missing_translations() {
        $translations = $this->parse_translations();
        
        if (is_wp_error($translations)) {
            return $translations;
        }
        
        $missing = [];
        $base_lang = 'en'; // Use English as the base language
        
        if (!isset($translations[$base_lang])) {
            return new WP_Error('no_base_lang', 'Base language (English) not found');
        }
        
        $base_strings = $this->flatten_array($translations[$base_lang]);
        
        foreach ($this->languages as $lang) {
            if ($lang === $base_lang) continue;
            
            $lang_strings = isset($translations[$lang]) ? $this->flatten_array($translations[$lang]) : [];
            
            foreach ($base_strings as $key => $value) {
                if (!isset($lang_strings[$key]) || empty(trim($lang_strings[$key]))) {
                    $missing[$lang][$key] = $value;
                }
            }
        }
        
        return $missing;
    }
    
    /**
     * Flatten nested array with dot notation keys
     */
    private function flatten_array($array, $prefix = '') {
        $result = [];
        
        foreach ($array as $key => $value) {
            $new_key = $prefix ? $prefix . '.' . $key : $key;
            
            if (is_array($value)) {
                $result = array_merge($result, $this->flatten_array($value, $new_key));
            } else {
                $result[$new_key] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Call Claude API to translate text
     */
    public function translate_with_claude($text, $target_language) {
        if (empty($this->api_key)) {
            return new WP_Error('no_api_key', 'Claude API key not configured');
        }
        
        $language_context = [
            'si' => 'Sinhala (used in Sri Lanka)',
            'ta' => 'Tamil (used in Sri Lanka and Tamil Nadu)'
        ];
        
        $context = isset($language_context[$target_language]) ? $language_context[$target_language] : $this->language_names[$target_language];
        
        $prompt = "Translate the following government/administrative text to {$context}. Keep the tone formal and official. Only return the translation, no explanations:\n\n{$text}";
        
        $response = wp_remote_post('https://api.anthropic.com/v1/messages', [
            'headers' => [
                'Content-Type' => 'application/json',
                'x-api-key' => $this->api_key,
                'anthropic-version' => '2023-06-01'
            ],
            'body' => json_encode([
                'model' => 'claude-3-5-sonnet-20241022',
                'max_tokens' => 1000,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]),
            'timeout' => 30
        ]);
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (isset($data['error'])) {
            return new WP_Error('claude_api_error', $data['error']['message']);
        }
        
        if (!isset($data['content'][0]['text'])) {
            return new WP_Error('no_translation', 'No translation received from Claude API');
        }
        
        return trim($data['content'][0]['text']);
    }
    
    /**
     * Update the i18n.js file with new translations
     */
    public function update_translations_file($new_translations) {
        $current_translations = $this->parse_translations();
        
        if (is_wp_error($current_translations)) {
            return $current_translations;
        }
        
        // Merge new translations
        foreach ($new_translations as $lang => $translations) {
            foreach ($translations as $key => $value) {
                $this->set_nested_value($current_translations[$lang], $key, $value);
            }
        }
        
        // Read the original file
        $content = file_get_contents($this->js_file_path);
        
        // Format the new translations object
        $new_js_object = $this->array_to_js_object($current_translations);
        
        // Replace the translations object in the file
        $updated_content = preg_replace(
            '/this\.translations\s*=\s*\{.*?\};/s',
            'this.translations = ' . $new_js_object . ';',
            $content
        );
        
        // Create backup
        $backup_path = $this->js_file_path . '.backup.' . date('Y-m-d-H-i-s');
        copy($this->js_file_path, $backup_path);
        
        // Write updated file
        $result = file_put_contents($this->js_file_path, $updated_content);
        
        if ($result === false) {
            return new WP_Error('write_error', 'Failed to write updated translations file');
        }
        
        return [
            'success' => true,
            'backup_file' => basename($backup_path),
            'updated_strings' => array_sum(array_map('count', $new_translations))
        ];
    }
    
    /**
     * Set nested array value using dot notation
     */
    private function set_nested_value(&$array, $key, $value) {
        $keys = explode('.', $key);
        $current = &$array;
        
        foreach ($keys as $k) {
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
        
        $current = $value;
    }
    
    /**
     * Convert PHP array to JavaScript object string
     */
    private function array_to_js_object($array, $indent = 0) {
        $spaces = str_repeat('    ', $indent);
        $inner_spaces = str_repeat('    ', $indent + 1);
        
        if (empty($array)) {
            return '{}';
        }
        
        $lines = [];
        $lines[] = '{';
        
        foreach ($array as $key => $value) {
            $quoted_key = is_numeric($key) ? $key : '"' . addslashes($key) . '"';
            
            if (is_array($value)) {
                $lines[] = $inner_spaces . $quoted_key . ': ' . $this->array_to_js_object($value, $indent + 1) . ',';
            } else {
                $quoted_value = '"' . addslashes($value) . '"';
                $lines[] = $inner_spaces . $quoted_key . ': ' . $quoted_value . ',';
            }
        }
        
        // Remove trailing comma from last line
        $last_line = array_pop($lines);
        $lines[] = rtrim($last_line, ',');
        
        $lines[] = $spaces . '}';
        
        return implode("\n", $lines);
    }
    
    /**
     * Handle AJAX request for auto translation
     */
    public function handle_auto_translate() {
        check_ajax_referer('opengovui_auto_translate_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }
        
        $action_type = sanitize_text_field($_POST['action_type']);
        
        switch ($action_type) {
            case 'scan':
                $missing = $this->find_missing_translations();
                if (is_wp_error($missing)) {
                    wp_send_json_error($missing->get_error_message());
                }
                wp_send_json_success(['missing' => $missing]);
                break;
                
            case 'translate':
                $this->process_auto_translation();
                break;
                
            case 'backup':
                $backup_path = $this->js_file_path . '.backup.' . date('Y-m-d-H-i-s');
                if (copy($this->js_file_path, $backup_path)) {
                    wp_send_json_success(['backup_file' => basename($backup_path)]);
                } else {
                    wp_send_json_error('Failed to create backup');
                }
                break;
                
            default:
                wp_send_json_error('Invalid action');
        }
    }
    
    /**
     * Process automatic translation
     */
    private function process_auto_translation() {
        $missing = $this->find_missing_translations();
        
        if (is_wp_error($missing)) {
            wp_send_json_error($missing->get_error_message());
        }
        
        if (empty($missing)) {
            wp_send_json_success(['message' => 'No missing translations found']);
        }
        
        $translated = [];
        $total_items = 0;
        $processed_items = 0;
        
        // Count total items
        foreach ($missing as $lang => $strings) {
            $total_items += count($strings);
        }
        
        foreach ($missing as $lang => $strings) {
            $translated[$lang] = [];
            
            foreach ($strings as $key => $text) {
                $translation = $this->translate_with_claude($text, $lang);
                
                if (!is_wp_error($translation)) {
                    $translated[$lang][$key] = $translation;
                }
                
                $processed_items++;
                
                // Send progress update
                $progress = ($processed_items / $total_items) * 100;
                
                // In a real implementation, you might want to use a different method
                // to send progress updates (like Server-Sent Events)
            }
        }
        
        // Update the file
        $result = $this->update_translations_file($translated);
        
        if (is_wp_error($result)) {
            wp_send_json_error($result->get_error_message());
        }
        
        wp_send_json_success([
            'message' => 'Translation completed successfully',
            'details' => $result,
            'translated' => $translated
        ]);
    }
}

// Initialize the translation manager
if (is_admin()) {
    $opengovui_translation_manager = new OpenGovUI_Translation_Manager();
    $opengovui_translation_manager->init();
} 