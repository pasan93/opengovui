<?php
/**
 * OpenGovUI WordPress Theme Functions
 * Custom post types and API for government portal with multilingual support
 */

// Theme support
function opengovui_theme_support() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'opengovui_theme_support');

// Enqueue styles and scripts
function opengovui_enqueue_assets() {
    wp_enqueue_style('opengovui-style', get_stylesheet_uri());
    
    // Enqueue original i18n and script files
    wp_enqueue_script('opengovui-i18n', get_template_directory_uri() . '/../../../js/i18n.js', array(), '1.0.0', true);
    wp_enqueue_script('opengovui-script', get_template_directory_uri() . '/../../../js/script.js', array('opengovui-i18n'), '1.0.0', true);
    
    // Enqueue multilingual scripts if Polylang is active
    if (function_exists('pll_current_language')) {
        wp_enqueue_script('opengovui-multilingual', get_template_directory_uri() . '/js/multilingual.js', array('jquery', 'opengovui-i18n'), '1.0.0', true);
        wp_localize_script('opengovui-multilingual', 'polylang_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'current_lang' => pll_current_language(),
            'languages' => pll_the_languages(array('raw' => 1))
        ));
        
        // Pass language mapping data
        wp_localize_script('opengovui-multilingual', 'polylang_data', array(
            'current_lang' => pll_current_language(),
            'default_lang' => pll_default_language(),
            'i18n_lang_map' => array(
                'en' => 'en',
                'si' => 'si', 
                'ta' => 'ta',
                'en_US' => 'en',
                'en_GB' => 'en',
                'si_LK' => 'si',
                'ta_LK' => 'ta'
            )
        ));
    }
}
add_action('wp_enqueue_scripts', 'opengovui_enqueue_assets');

// Custom Post Type: Government Services (Translatable)
function create_gov_service_post_type() {
    register_post_type('gov_service', array(
        'labels' => array(
            'name' => 'Services',
            'singular_name' => 'Service',
            'add_new' => 'Add New Service',
            'add_new_item' => 'Add New Service',
            'edit_item' => 'Edit Service',
            'new_item' => 'New Service',
            'view_item' => 'View Service',
            'search_items' => 'Search Services',
            'not_found' => 'No services found',
            'not_found_in_trash' => 'No services found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest' => true, // Enable REST API
        'rest_base' => 'gov_service',
        'rewrite' => array('slug' => 'service')
    ));
}
add_action('init', 'create_gov_service_post_type');

// Custom Post Type: Service Categories (Translatable)
function create_service_category_post_type() {
    register_post_type('service_category', array(
        'labels' => array(
            'name' => 'Categories',
            'singular_name' => 'Category',
            'add_new' => 'Add New Category',
            'add_new_item' => 'Add New Category',
            'edit_item' => 'Edit Category',
            'new_item' => 'New Category',
            'view_item' => 'View Category',
            'search_items' => 'Search Categories',
            'not_found' => 'No categories found',
            'not_found_in_trash' => 'No categories found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-category',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest' => true, // Enable REST API
        'rest_base' => 'service_category',
        'rewrite' => array('slug' => 'category')
    ));
}
add_action('init', 'create_service_category_post_type');

// Custom Post Type: Government Updates (Translatable)
function create_gov_update_post_type() {
    register_post_type('gov_update', array(
        'labels' => array(
            'name' => 'Updates',
            'singular_name' => 'Update',
            'add_new' => 'Add New Update',
            'add_new_item' => 'Add New Update',
            'edit_item' => 'Edit Update',
            'new_item' => 'New Update',
            'view_item' => 'View Update',
            'search_items' => 'Search Updates',
            'not_found' => 'No updates found',
            'not_found_in_trash' => 'No updates found in trash'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
        'show_in_rest' => true, // Enable REST API
        'rest_base' => 'gov_update',
        'rewrite' => array('slug' => 'update')
    ));
}
add_action('init', 'create_gov_update_post_type');

// Make custom post types translatable with Polylang
function opengovui_polylang_register_post_types($post_types, $is_settings) {
    if ($is_settings) {
        // Remove the custom post types from this list to allow Polylang management
        unset($post_types['gov_service']);
        unset($post_types['service_category']);
        unset($post_types['gov_update']);
    } else {
        // Add custom post types to translatable list
        $post_types['gov_service'] = 'gov_service';
        $post_types['service_category'] = 'service_category';
        $post_types['gov_update'] = 'gov_update';
    }
    return $post_types;
}
add_filter('pll_get_post_types', 'opengovui_polylang_register_post_types', 10, 2);

// Add custom meta fields for services
function add_service_meta_boxes() {
    add_meta_box(
        'service_details',
        'Service Details',
        'service_meta_box_callback',
        'gov_service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_service_meta_boxes');

function service_meta_box_callback($post) {
    wp_nonce_field('save_service_meta', 'service_meta_nonce');
    
    $service_icon = get_post_meta($post->ID, 'service_icon', true);
    $service_url = get_post_meta($post->ID, 'service_url', true);
    $service_requirements = get_post_meta($post->ID, 'service_requirements', true);
    $service_processing_time = get_post_meta($post->ID, 'service_processing_time', true);
    $featured = get_post_meta($post->ID, 'featured', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="service_icon">Service Icon (FontAwesome class)</label></th>';
    echo '<td><input type="text" id="service_icon" name="service_icon" value="' . esc_attr($service_icon) . '" placeholder="e.g., fas fa-id-card" /></td></tr>';
    
    echo '<tr><th><label for="service_url">Service URL</label></th>';
    echo '<td><input type="url" id="service_url" name="service_url" value="' . esc_url($service_url) . '" /></td></tr>';
    
    echo '<tr><th><label for="service_requirements">Requirements</label></th>';
    echo '<td><textarea id="service_requirements" name="service_requirements" rows="3">' . esc_textarea($service_requirements) . '</textarea></td></tr>';
    
    echo '<tr><th><label for="service_processing_time">Processing Time</label></th>';
    echo '<td><input type="text" id="service_processing_time" name="service_processing_time" value="' . esc_attr($service_processing_time) . '" placeholder="e.g., 2-3 weeks" /></td></tr>';
    
    echo '<tr><th><label for="featured">Featured Service</label></th>';
    echo '<td><input type="checkbox" id="featured" name="featured" value="1" ' . checked($featured, '1', false) . ' /> Show on homepage</td></tr>';
    echo '</table>';
}

function save_service_meta($post_id) {
    if (!isset($_POST['service_meta_nonce']) || !wp_verify_nonce($_POST['service_meta_nonce'], 'save_service_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, 'service_icon', sanitize_text_field($_POST['service_icon']));
    }
    
    if (isset($_POST['service_url'])) {
        update_post_meta($post_id, 'service_url', esc_url_raw($_POST['service_url']));
    }
    
    if (isset($_POST['service_requirements'])) {
        update_post_meta($post_id, 'service_requirements', sanitize_textarea_field($_POST['service_requirements']));
    }
    
    if (isset($_POST['service_processing_time'])) {
        update_post_meta($post_id, 'service_processing_time', sanitize_text_field($_POST['service_processing_time']));
    }
    
    if (isset($_POST['featured'])) {
        update_post_meta($post_id, 'featured', '1');
    } else {
        update_post_meta($post_id, 'featured', '0');
    }
}
add_action('save_post', 'save_service_meta');

// Add custom meta fields for categories
function add_category_meta_boxes() {
    add_meta_box(
        'category_details',
        'Category Details',
        'category_meta_box_callback',
        'service_category',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_category_meta_boxes');

function category_meta_box_callback($post) {
    wp_nonce_field('save_category_meta', 'category_meta_nonce');
    
    $category_icon = get_post_meta($post->ID, 'category_icon', true);
    $category_color = get_post_meta($post->ID, 'category_color', true);
    
    echo '<table class="form-table">';
    echo '<tr><th><label for="category_icon">Category Icon (FontAwesome class)</label></th>';
    echo '<td><input type="text" id="category_icon" name="category_icon" value="' . esc_attr($category_icon) . '" placeholder="e.g., fas fa-heart" /></td></tr>';
    
    echo '<tr><th><label for="category_color">Category Color</label></th>';
    echo '<td><input type="color" id="category_color" name="category_color" value="' . esc_attr($category_color) . '" /></td></tr>';
    echo '</table>';
}

function save_category_meta($post_id) {
    if (!isset($_POST['category_meta_nonce']) || !wp_verify_nonce($_POST['category_meta_nonce'], 'save_category_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (isset($_POST['category_icon'])) {
        update_post_meta($post_id, 'category_icon', sanitize_text_field($_POST['category_icon']));
    }
    
    if (isset($_POST['category_color'])) {
        update_post_meta($post_id, 'category_color', sanitize_hex_color($_POST['category_color']));
    }
}
add_action('save_post', 'save_category_meta');

// Sync custom meta fields across translations
function opengovui_polylang_copy_post_metas($keys, $sync, $from, $to, $lang) {
    // Add custom meta fields to sync across translations
    $custom_keys = array(
        'service_icon',
        'service_url', 
        'service_requirements',
        'service_processing_time',
        'featured',
        'category_icon',
        'category_color'
    );
    
    return array_merge($keys, $custom_keys);
}
add_filter('pll_copy_post_metas', 'opengovui_polylang_copy_post_metas', 10, 5);

// Add custom meta fields to REST API with language support
function add_meta_to_rest_api() {
    // Service meta fields
    register_rest_field('gov_service', 'service_icon', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'service_icon', true);
        }
    ));
    
    register_rest_field('gov_service', 'service_url', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'service_url', true);
        }
    ));
    
    register_rest_field('gov_service', 'service_requirements', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'service_requirements', true);
        }
    ));
    
    register_rest_field('gov_service', 'service_processing_time', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'service_processing_time', true);
        }
    ));
    
    register_rest_field('gov_service', 'featured', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'featured', true);
        }
    ));
    
    // Category meta fields
    register_rest_field('service_category', 'category_icon', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'category_icon', true);
        }
    ));
    
    register_rest_field('service_category', 'category_color', array(
        'get_callback' => function($post) {
            return get_post_meta($post['id'], 'category_color', true);
        }
    ));
    
    // Add language information to all custom post types
    $post_types = array('gov_service', 'service_category', 'gov_update');
    foreach ($post_types as $post_type) {
        register_rest_field($post_type, 'language', array(
            'get_callback' => function($post) {
                if (function_exists('pll_get_post_language')) {
                    return pll_get_post_language($post['id']);
                }
                return 'en'; // fallback
            }
        ));
        
        register_rest_field($post_type, 'translations', array(
            'get_callback' => function($post) {
                if (function_exists('pll_get_post_translations')) {
                    return pll_get_post_translations($post['id']);
                }
                return array();
            }
        ));
    }
}
add_action('rest_api_init', 'add_meta_to_rest_api');

// Helper function to get posts in current language
function opengovui_get_posts_in_language($post_type, $args = array()) {
    $default_args = array(
        'post_type' => $post_type,
        'post_status' => 'publish'
    );
    
    $args = wp_parse_args($args, $default_args);
    
    // Add language filter if Polylang is active
    if (function_exists('pll_current_language')) {
        $args['lang'] = pll_current_language();
    }
    
    return get_posts($args);
}

// Language switcher widget
function opengovui_language_switcher() {
    if (function_exists('pll_the_languages')) {
        $languages = pll_the_languages(array(
            'show_flags' => 1,
            'show_names' => 1,
            'hide_if_empty' => 0,
            'force_home' => 0,
            'echo' => 0,
            'raw' => 1
        ));
        
        if (!empty($languages)) {
            echo '<div class="language-selector polylang-switcher">';
            foreach ($languages as $lang) {
                $active_class = $lang['current_lang'] ? ' active' : '';
                
                // Clean up language name to avoid duplication
                $lang_name = $lang['name'];
                
                // Map to proper display names
                $display_names = array(
                    'English' => 'English',
                    'Sinhala' => 'සිංහල',
                    'Tamil' => 'தமிழ்'
                );
                
                if (isset($display_names[$lang_name])) {
                    $lang_name = $display_names[$lang_name];
                }
                
                echo '<a href="' . esc_url($lang['url']) . '" class="lang-' . esc_attr($lang['slug']) . $active_class . '" lang="' . esc_attr($lang['slug']) . '" data-lang="' . esc_attr($lang['slug']) . '">';
                echo esc_html($lang_name);
                echo '</a>';
            }
            echo '</div>';
        }
    }
}

// Enable CORS for API access with language support
function add_cors_http_header() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
}
add_action('rest_api_init', 'add_cors_http_header');

// Custom API endpoints for frontend integration
function opengovui_register_api_routes() {
    // Get featured services
    register_rest_route('opengovui/v1', '/featured-services', array(
        'methods' => 'GET',
        'callback' => 'opengovui_get_featured_services',
        'permission_callback' => '__return_true'
    ));
    
    // Get service categories
    register_rest_route('opengovui/v1', '/categories', array(
        'methods' => 'GET',
        'callback' => 'opengovui_get_categories',
        'permission_callback' => '__return_true'
    ));
    
    // Get government updates
    register_rest_route('opengovui/v1', '/updates', array(
        'methods' => 'GET',
        'callback' => 'opengovui_get_updates',
        'permission_callback' => '__return_true'
    ));
    
    // Get all services
    register_rest_route('opengovui/v1', '/services', array(
        'methods' => 'GET',
        'callback' => 'opengovui_get_services',
        'permission_callback' => '__return_true'
    ));
}
add_action('rest_api_init', 'opengovui_register_api_routes');

function opengovui_get_featured_services($request) {
    $lang = $request->get_param('lang') ?: 'en';
    
    $services = opengovui_get_posts_in_language('gov_service', array(
        'meta_key' => 'featured',
        'meta_value' => '1',
        'numberposts' => 4
    ));
    
    $formatted_services = array();
    foreach ($services as $service) {
        $formatted_services[] = array(
            'id' => $service->ID,
            'title' => $service->post_title,
            'description' => $service->post_excerpt,
            'icon' => get_post_meta($service->ID, 'service_icon', true),
            'url' => get_post_meta($service->ID, 'service_url', true),
            'permalink' => get_permalink($service->ID),
            'processing_time' => get_post_meta($service->ID, 'service_processing_time', true),
            'requirements' => get_post_meta($service->ID, 'service_requirements', true)
        );
    }
    
    return rest_ensure_response($formatted_services);
}

function opengovui_get_categories($request) {
    $lang = $request->get_param('lang') ?: 'en';
    
    $categories = opengovui_get_posts_in_language('service_category', array(
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    ));
    
    $formatted_categories = array();
    foreach ($categories as $category) {
        $formatted_categories[] = array(
            'id' => $category->ID,
            'title' => $category->post_title,
            'description' => $category->post_excerpt,
            'icon' => get_post_meta($category->ID, 'category_icon', true),
            'color' => get_post_meta($category->ID, 'category_color', true),
            'permalink' => get_permalink($category->ID),
            'slug' => $category->post_name
        );
    }
    
    return rest_ensure_response($formatted_categories);
}

function opengovui_get_updates($request) {
    $lang = $request->get_param('lang') ?: 'en';
    $limit = $request->get_param('limit') ?: 3;
    
    $updates = opengovui_get_posts_in_language('gov_update', array(
        'numberposts' => $limit,
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    
    $formatted_updates = array();
    foreach ($updates as $update) {
        $formatted_updates[] = array(
            'id' => $update->ID,
            'title' => $update->post_title,
            'excerpt' => $update->post_excerpt,
            'content' => $update->post_content,
            'date' => get_the_date('c', $update->ID),
            'date_formatted' => get_the_date('', $update->ID),
            'permalink' => get_permalink($update->ID)
        );
    }
    
    return rest_ensure_response($formatted_updates);
}

function opengovui_get_services($request) {
    $lang = $request->get_param('lang') ?: 'en';
    $category = $request->get_param('category');
    
    $args = array(
        'numberposts' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    );
    
    if ($category) {
        // If we had a proper taxonomy, we'd filter by category here
        // For now, we'll return all services
    }
    
    $services = opengovui_get_posts_in_language('gov_service', $args);
    
    $formatted_services = array();
    foreach ($services as $service) {
        $formatted_services[] = array(
            'id' => $service->ID,
            'title' => $service->post_title,
            'description' => $service->post_excerpt,
            'content' => $service->post_content,
            'icon' => get_post_meta($service->ID, 'service_icon', true),
            'url' => get_post_meta($service->ID, 'service_url', true),
            'permalink' => get_permalink($service->ID),
            'processing_time' => get_post_meta($service->ID, 'service_processing_time', true),
            'requirements' => get_post_meta($service->ID, 'service_requirements', true),
            'featured' => get_post_meta($service->ID, 'featured', true) === '1'
        );
    }
    
    return rest_ensure_response($formatted_services);
}

// Add Polylang support notice for admin
function opengovui_admin_notice_polylang() {
    if (!function_exists('pll_current_language')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>OpenGovUI Theme:</strong> For full multilingual support, please install and activate the Polylang plugin.</p>';
        echo '</div>';
    }
}
add_action('admin_notices', 'opengovui_admin_notice_polylang');

// Include translation manager for auto-translation functionality
if (file_exists(get_template_directory() . '/includes/translation-manager.php')) {
    require_once get_template_directory() . '/includes/translation-manager.php';
}

// Include content populator
if (file_exists(get_template_directory() . '/includes/content-populator.php')) {
    require_once get_template_directory() . '/includes/content-populator.php';
}

// Register settings for Claude API key
add_action('admin_init', function() {
    register_setting('opengovui_translation_settings', 'opengovui_claude_api_key');
});

// Add admin menu for content management
function opengovui_admin_menu() {
    add_menu_page(
        'OpenGovUI Content',
        'OpenGovUI',
        'manage_options',
        'opengovui-content',
        'opengovui_content_page',
        'dashicons-admin-site-alt3',
        30
    );
    
    add_submenu_page(
        'opengovui-content',
        'Populate Content',
        'Populate Content',
        'manage_options',
        'opengovui-populate',
        'opengovui_populate_page'
    );
}
add_action('admin_menu', 'opengovui_admin_menu');

function opengovui_content_page() {
    ?>
    <div class="wrap">
        <h1>OpenGovUI Content Management</h1>
        
        <?php if (isset($_GET['populated'])): ?>
            <div class="notice notice-success is-dismissible">
                <p>Content has been successfully populated!</p>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <h2>Content Overview</h2>
            <p>This page provides an overview of all OpenGovUI content.</p>
            
            <h3>Content Statistics</h3>
            <ul>
                <li><strong>Services:</strong> <?php echo wp_count_posts('gov_service')->publish; ?> published</li>
                <li><strong>Categories:</strong> <?php echo wp_count_posts('service_category')->publish; ?> published</li>
                <li><strong>Updates:</strong> <?php echo wp_count_posts('gov_update')->publish; ?> published</li>
            </ul>
            
            <p><a href="<?php echo admin_url('admin.php?page=opengovui-populate'); ?>" class="button button-primary">Manage Content Population</a></p>
        </div>
    </div>
    <?php
}

function opengovui_populate_page() {
    ?>
    <div class="wrap">
        <h1>Populate OpenGovUI Content</h1>
        
        <div class="card">
            <h2>Content Population</h2>
            <p>This will create all the services, categories, pages, and updates from your frontend in WordPress with proper multilingual support.</p>
            
            <h3>What will be created:</h3>
            <ul>
                <li><strong>Service Categories:</strong> Health & Care, Business, Housing, Immigration</li>
                <li><strong>Government Services:</strong> National ID, Passport, Vehicle Registration, Education</li>
                <li><strong>Government Updates:</strong> News and announcements</li>
                <li><strong>Main Pages:</strong> About, Contact, etc.</li>
            </ul>
            
            <p><strong>Note:</strong> This will create content in English, Sinhala, and Tamil. Existing content will be updated.</p>
            
            <p>
                <a href="<?php echo admin_url('admin.php?page=opengovui-content&populate_opengovui_content=1'); ?>" 
                   class="button button-primary button-large"
                   onclick="return confirm('Are you sure you want to populate content? This will create/update posts in all languages.');">
                    Populate All Content
                </a>
            </p>
            
            <div id="populate-progress" style="display:none;">
                <p>Populating content... Please wait.</p>
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2>Manual Content Management</h2>
            <p>You can also manually manage content through the WordPress admin:</p>
            <ul>
                <li><a href="<?php echo admin_url('edit.php?post_type=gov_service'); ?>">Manage Services</a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=service_category'); ?>">Manage Categories</a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=gov_update'); ?>">Manage Updates</a></li>
                <li><a href="<?php echo admin_url('edit.php?post_type=page'); ?>">Manage Pages</a></li>
            </ul>
        </div>
    </div>
    
    <style>
        .progress-bar {
            width: 100%;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin: 10px 0;
        }
        .progress-fill {
            height: 20px;
            background-color: #0073aa;
            border-radius: 4px;
            width: 0%;
            transition: width 0.3s ease;
        }
    </style>
    <?php
}

// Customize WordPress Admin Footer Text
function opengovui_admin_footer_text($footer_text) {
    return sprintf(
        'Made with <a href="https://wordpress.org/" target="_blank">WordPress</a> in Sri Lanka 🇱🇰 by <a href="https://highflyerglobal.com" target="_blank">HighFlyer</a>'
    );
}
add_filter('admin_footer_text', 'opengovui_admin_footer_text');

?> 