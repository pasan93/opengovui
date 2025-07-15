<?php
/**
 * OpenGovUI WordPress Theme Functions
 * Custom post types and API for government portal
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
}
add_action('wp_enqueue_scripts', 'opengovui_enqueue_assets');

// Custom Post Type: Government Services
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
        'rest_base' => 'gov_service'
    ));
}
add_action('init', 'create_gov_service_post_type');

// Custom Post Type: Service Categories
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
        'rest_base' => 'service_category'
    ));
}
add_action('init', 'create_service_category_post_type');

// Custom Post Type: Government Updates
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
        'rest_base' => 'gov_update'
    ));
}
add_action('init', 'create_gov_update_post_type');

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

// Add custom meta fields to REST API
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
}
add_action('rest_api_init', 'add_meta_to_rest_api');

// Enable CORS for API access
function add_cors_http_header() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
}
add_action('rest_api_init', 'add_cors_http_header');

?> 