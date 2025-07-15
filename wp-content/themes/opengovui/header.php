<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;500;600;700&family=Noto+Sans+Sinhala:wght@400;500;700&family=Noto+Sans+Tamil:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- FontAwesome 6.5.1 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<a href="#main-content" class="skip-to-main" data-i18n="accessibility.skipToMain">Skip to main content</a>

<header class="gov-header">
    <div class="top-banner">
        <div class="container">
            <div class="utility-nav">
                <div class="language-selector">
                    <?php 
                    // Use WordPress language switcher if available, otherwise fallback to static
                    if (function_exists('opengovui_language_switcher')) {
                        opengovui_language_switcher();
                    } else {
                        ?>
                        <a href="#" lang="si">සිංහල</a>
                        <a href="#" lang="ta">தமிழ்</a>
                        <a href="#" lang="en" class="active">English</a>
                        <?php
                    }
                    ?>
                </div>

                <div class="utility-links">
                    <?php
                    // Check if we have a Contact page
                    $contact_page = get_page_by_path('contact');
                    $contact_url = $contact_page ? get_permalink($contact_page->ID) : '#';
                    ?>
                    <a href="<?php echo esc_url($contact_url); ?>" data-i18n="header.contact">Contact</a>
                    <a href="<?php echo wp_login_url(); ?>" class="login-link">
                        <i class="fa-solid fa-user"></i>
                        <span data-i18n="header.login">Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="main-header">
        <div class="container">
            <div class="header-content">
                <a href="<?php echo home_url('/'); ?>" class="logo">
                    <?php
                    $logo_url = get_template_directory_uri() . '/../../../images/govt-logo.png';
                    if (file_exists(get_template_directory() . '/../../../images/govt-logo.png')) {
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>" width="60" height="60" alt="<?php bloginfo('name'); ?> Logo">
                        <?php
                    }
                    ?>
                    <span data-i18n="header.govtName"><?php bloginfo('name'); ?></span>
                </a>

                <div class="header-search">
                    <form class="search-wrapper" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="search" 
                               id="search-input" 
                               name="s"
                               value="<?php echo get_search_query(); ?>"
                               data-i18n="search.placeholder" 
                               data-i18n-attr="placeholder" 
                               placeholder="Search">
                        <button type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <span data-i18n="search.button">Search</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header> 