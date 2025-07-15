<?php
/**
 * Front Page Template - OpenGovUI
 * Integrates WordPress content with frontend design
 */

get_header(); ?>

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
                        $featured_services = opengovui_get_posts_in_language('gov_service', array(
                            'meta_key' => 'featured',
                            'meta_value' => '1',
                            'numberposts' => 4
                        ));

                        // Debug: Let's also try to get ALL services to see if any exist
                        $all_services = opengovui_get_posts_in_language('gov_service', array('numberposts' => -1));
                        
                        // Debug info (remove in production)
                        if (current_user_can('manage_options')) {
                            echo '<!-- Debug: Current language: ' . (function_exists('pll_current_language') ? pll_current_language() : 'no-polylang') . ' -->';
                            echo '<!-- Debug: Featured services found: ' . count($featured_services) . ' -->';
                            echo '<!-- Debug: All services found: ' . count($all_services) . ' -->';
                        }
                        
                        // If no featured services but we have services, use all services
                        if (!$featured_services && $all_services) {
                            $featured_services = array_slice($all_services, 0, 4);
                        }

                        if ($featured_services) {
                            foreach ($featured_services as $service) {
                                $service_icon = get_post_meta($service->ID, 'service_icon', true);
                                $service_url = get_post_meta($service->ID, 'service_url', true);
                                ?>
                                <a href="<?php echo get_permalink($service->ID); ?>" class="service-card">
                                    <div class="service-icon">
                                        <i class="<?php echo esc_attr($service_icon ?: 'fa-solid fa-file'); ?>"></i>
                                    </div>
                                    <h3><?php echo esc_html($service->post_title); ?></h3>
                                    <p><?php echo esc_html($service->post_excerpt); ?></p>
                                </a>
                                <?php
                            }
                        } else {
                            // Fallback to static content for i18n
                            ?>
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
                            <?php
                        }
                        ?>
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
                // Get service categories from WordPress
                $categories = opengovui_get_posts_in_language('service_category', array(
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));

                if ($categories) {
                    foreach ($categories as $category) {
                        $category_icon = get_post_meta($category->ID, 'category_icon', true);
                        $category_color = get_post_meta($category->ID, 'category_color', true);
                        ?>
                        <a href="<?php echo get_permalink($category->ID); ?>" class="topic-card" <?php if ($category_color): ?>style="border-color: <?php echo esc_attr($category_color); ?>"<?php endif; ?>>
                            <h3>
                                <i class="<?php echo esc_attr($category_icon ?: 'fa-solid fa-folder'); ?>"></i>
                                <span><?php echo esc_html($category->post_title); ?></span>
                            </h3>
                            <p><?php echo esc_html($category->post_excerpt); ?></p>
                        </a>
                        <?php
                    }
                } else {
                    // Fallback to static content for i18n
                    ?>
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
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section class="updates-section">
        <div class="container">
            <div class="section-header">
                <h2 data-i18n="updates.title">Government Updates</h2>
                <a href="<?php echo get_post_type_archive_link('gov_update'); ?>" class="view-all" data-i18n="updates.viewAll">View all updates</a>
            </div>
            <div class="updates-grid">
                <?php
                // Get latest government updates
                $updates = opengovui_get_posts_in_language('gov_update', array(
                    'numberposts' => 3,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($updates) {
                    foreach ($updates as $update) {
                        ?>
                        <article class="update-card">
                            <h3><a href="<?php echo get_permalink($update->ID); ?>"><?php echo esc_html($update->post_title); ?></a></h3>
                            <p class="update-excerpt"><?php echo esc_html($update->post_excerpt); ?></p>
                            <div class="update-meta">
                                <time datetime="<?php echo get_the_date('c', $update->ID); ?>"><?php echo get_the_date('', $update->ID); ?></time>
                                <a href="<?php echo get_permalink($update->ID); ?>" class="read-more" data-i18n="updates.readMore">Read more</a>
                            </div>
                        </article>
                        <?php
                    }
                } else {
                    echo '<p>No updates available at the moment.</p>';
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?> 