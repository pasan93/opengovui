<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?> - <?php bloginfo('name'); ?></title>
    
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
                        <a href="#" lang="si">සිංහල</a>
                        <a href="#" lang="ta">தமிழ்</a>
                        <a href="#" lang="en" class="active">English</a>
                    </div>

                    <div class="utility-links">
                        <a href="#" data-i18n="header.contact">Contact</a>
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
                    <a href="<?php echo home_url(); ?>" class="logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/../../../images/govt-logo.png" width="60" height="60" alt="Norvalis Government Logo">
                        <span data-i18n="header.govtName"><?php bloginfo('name'); ?></span>
                    </a>

                    <div class="header-search">
                        <form class="search-wrapper" method="get" action="<?php echo home_url(); ?>">
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

    <main id="main-content" role="main">
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <h1 data-i18n="hero.title">Access government services and information in one place</h1>

                    <div class="featured-services">
                        <h2 data-i18n="hero.subtitle">Most requested services</h2>

                        <div class="services-grid">
                            <?php
                            // Get featured services from WordPress
                            $services = get_posts(array(
                                'post_type' => 'gov_service',
                                'posts_per_page' => 4,
                                'meta_key' => 'featured',
                                'meta_value' => '1'
                            ));
                            
                            if ($services): foreach($services as $service): ?>
                                <a href="<?php echo get_post_meta($service->ID, 'service_url', true); ?>" class="service-card">
                                    <div class="service-icon">
                                        <i class="<?php echo get_post_meta($service->ID, 'service_icon', true); ?>"></i>
                                    </div>
                                    <h3><?php echo $service->post_title; ?></h3>
                                    <p><?php echo $service->post_excerpt; ?></p>
                                </a>
                            <?php endforeach; else: ?>
                                <!-- Default services if none configured -->
                                <a href="#" class="service-card">
                                    <div class="service-icon">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>
                                    <h3 data-i18n="services.nationalId.title">National ID</h3>
                                    <p data-i18n="services.nationalId.description">Apply for or renew your National Identity Card</p>
                                </a>
                                <a href="#" class="service-card">
                                    <div class="service-icon">
                                        <i class="fa-solid fa-passport"></i>
                                    </div>
                                    <h3 data-i18n="services.passport.title">Passport</h3>
                                    <p data-i18n="services.passport.description">Apply for or renew your passport</p>
                                </a>
                                <a href="#" class="service-card">
                                    <div class="service-icon">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <h3 data-i18n="services.vehicleReg.title">Vehicle Registration</h3>
                                    <p data-i18n="services.vehicleReg.description">Register or transfer vehicle ownership</p>
                                </a>
                                <a href="#" class="service-card">
                                    <div class="service-icon">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <h3 data-i18n="services.education.title">Education</h3>
                                    <p data-i18n="services.education.description">Access educational services</p>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="topics-section">
            <div class="container">
                <h2 data-i18n="categories.title">Browse by category</h2>

                <div class="topics-grid">
                    <?php
                    // Get service categories
                    $categories = get_posts(array(
                        'post_type' => 'service_category',
                        'posts_per_page' => 4
                    ));
                    
                    if ($categories): foreach($categories as $category): ?>
                        <a href="#" class="topic-card">
                            <h3>
                                <i class="<?php echo get_post_meta($category->ID, 'category_icon', true); ?>"></i>
                                <span><?php echo $category->post_title; ?></span>
                            </h3>
                            <p><?php echo $category->post_excerpt; ?></p>
                        </a>
                    <?php endforeach; else: ?>
                        <!-- Default categories -->
                        <a href="#" class="topic-card">
                            <h3>
                                <i class="fa-solid fa-heart-pulse"></i>
                                <span data-i18n="categories.health.title">Health & Care</span>
                            </h3>
                            <p data-i18n="categories.health.description">Healthcare, insurance, elderly care</p>
                        </a>
                        <a href="#" class="topic-card">
                            <h3>
                                <i class="fa-solid fa-briefcase"></i>
                                <span data-i18n="categories.business.title">Business</span>
                            </h3>
                            <p data-i18n="categories.business.description">Registration, licenses, taxes</p>
                        </a>
                        <a href="#" class="topic-card">
                            <h3>
                                <i class="fa-solid fa-house"></i>
                                <span data-i18n="categories.housing.title">Housing</span>
                            </h3>
                            <p data-i18n="categories.housing.description">Property, utilities, local services</p>
                        </a>
                        <a href="#" class="topic-card">
                            <h3>
                                <i class="fa-solid fa-plane"></i>
                                <span data-i18n="categories.immigration.title">Immigration</span>
                            </h3>
                            <p data-i18n="categories.immigration.description">Visas, citizenship, work permits</p>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="updates-section">
            <div class="container">
                <div class="section-header">
                    <h2 data-i18n="updates.title">Government Updates</h2>
                    <a href="#" class="view-all" data-i18n="updates.viewAll">View all updates</a>
                </div>
                <div class="updates-grid">
                    <?php
                    // Get government updates
                    $updates = get_posts(array(
                        'post_type' => 'gov_update',
                        'posts_per_page' => 3
                    ));
                    
                    if ($updates): foreach($updates as $update): ?>
                        <article class="update-card">
                            <h3><a href="<?php echo get_permalink($update->ID); ?>"><?php echo $update->post_title; ?></a></h3>
                            <p><?php echo $update->post_excerpt; ?></p>
                            <time><?php echo get_the_date('', $update->ID); ?></time>
                        </article>
                    <?php endforeach; else: ?>
                        <!-- Default content -->
                        <p>No updates available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <footer class="gov-footer">
        <div class="container">
            <div class="footer-sections">
                <div class="footer-primary">
                    <div class="footer-brand">
                        <img src="<?php echo get_template_directory_uri(); ?>/../../../images/govt-logo.png" width="50" height="50" alt="Norvalis Government Logo">
                        <span data-i18n="header.govtName"><?php bloginfo('name'); ?></span>
                    </div>

                    <div class="social-links">
                        <a href="#" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" aria-label="Twitter">
                            <i class="fa-brands fa-square-x-twitter"></i>
                        </a>
                        <a href="#" aria-label="LinkedIn">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="#" aria-label="YouTube">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <div class="footer-links-container">
                    <div class="footer-col">
                        <h4 data-i18n="footer.quickLinks.title">Quick Links</h4>
                        <ul>
                            <li><a href="#" data-i18n="footer.quickLinks.aboutSL">About Norvalis</a></li>
                            <li><a href="#" data-i18n="footer.quickLinks.gazette">Government Gazette</a></li>
                            <li><a href="#" data-i18n="footer.quickLinks.parliament">Parliament</a></li>
                            <li><a href="#" data-i18n="footer.quickLinks.departments">Departments</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4 data-i18n="footer.help.title">Help & Support</h4>
                        <ul>
                            <li><a href="#" data-i18n="footer.help.contact">Contact Us</a></li>
                            <li><a href="#" data-i18n="footer.help.faq">FAQs</a></li>
                            <li><a href="#" data-i18n="footer.help.siteMap">Site Map</a></li>
                            <li><a href="#" data-i18n="footer.help.accessibility">Accessibility</a></li>
                        </ul>
                    </div>

                    <div class="footer-col">
                        <h4 data-i18n="footer.legal.title">Legal</h4>
                        <ul>
                            <li><a href="#" data-i18n="footer.legal.privacy">Privacy Policy</a></li>
                            <li><a href="#" data-i18n="footer.legal.terms">Terms of Use</a></li>
                            <li><a href="#" data-i18n="footer.legal.copyright">Copyright</a></li>
                            <li><a href="#" data-i18n="footer.legal.disclaimer">Disclaimer</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p data-i18n="footer.copyright">© 2024 <?php bloginfo('name'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo get_template_directory_uri(); ?>/../../../js/i18n.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/../../../js/script.js"></script>
    <?php wp_footer(); ?>
</body>
</html> 