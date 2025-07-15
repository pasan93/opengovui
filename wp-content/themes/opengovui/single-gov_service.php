<?php
/**
 * Single Service Template - OpenGovUI
 */

get_header(); ?>

<main id="main-content" role="main">
    <?php while (have_posts()) : the_post(); ?>
        <article class="service-detail">
            <div class="container">
                <div class="service-header">
                    <div class="service-breadcrumb">
                        <a href="<?php echo home_url('/'); ?>">Home</a>
                        <span>/</span>
                        <a href="<?php echo get_post_type_archive_link('gov_service'); ?>">Services</a>
                        <span>/</span>
                        <span><?php the_title(); ?></span>
                    </div>
                    
                    <div class="service-hero">
                        <div class="service-icon-large">
                            <?php
                            $service_icon = get_post_meta(get_the_ID(), 'service_icon', true);
                            if ($service_icon) {
                                echo '<i class="' . esc_attr($service_icon) . '"></i>';
                            } else {
                                echo '<i class="fa-solid fa-file"></i>';
                            }
                            ?>
                        </div>
                        <div class="service-info">
                            <h1><?php the_title(); ?></h1>
                            <p class="service-excerpt"><?php the_excerpt(); ?></p>
                            
                            <div class="service-meta">
                                <?php
                                $processing_time = get_post_meta(get_the_ID(), 'service_processing_time', true);
                                $service_url = get_post_meta(get_the_ID(), 'service_url', true);
                                
                                if ($processing_time) {
                                    echo '<div class="meta-item">';
                                    echo '<i class="fa-solid fa-clock"></i>';
                                    echo '<span><strong>Processing Time:</strong> ' . esc_html($processing_time) . '</span>';
                                    echo '</div>';
                                }
                                
                                if ($service_url) {
                                    echo '<div class="meta-item">';
                                    echo '<a href="' . esc_url($service_url) . '" class="btn btn-primary">';
                                    echo '<i class="fa-solid fa-external-link-alt"></i> Apply Online';
                                    echo '</a>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="service-content">
                    <div class="content-main">
                        <div class="service-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                        $requirements = get_post_meta(get_the_ID(), 'service_requirements', true);
                        if ($requirements) {
                            ?>
                            <div class="service-requirements">
                                <h3><i class="fa-solid fa-list-check"></i> Requirements</h3>
                                <div class="requirements-content">
                                    <?php echo wpautop(esc_html($requirements)); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <div class="content-sidebar">
                        <div class="sidebar-card">
                            <h3>Need Help?</h3>
                            <p>Contact our support team for assistance with this service.</p>
                            <?php
                            $contact_page = get_page_by_path('contact');
                            $contact_url = $contact_page ? get_permalink($contact_page->ID) : '#';
                            ?>
                            <a href="<?php echo esc_url($contact_url); ?>" class="btn btn-outline">Contact Support</a>
                        </div>
                        
                        <div class="sidebar-card">
                            <h3>Related Services</h3>
                            <?php
                            // Get other services
                            $related_services = get_posts(array(
                                'post_type' => 'gov_service',
                                'numberposts' => 3,
                                'exclude' => array(get_the_ID()),
                                'meta_key' => 'featured',
                                'meta_value' => '1'
                            ));
                            
                            if ($related_services) {
                                echo '<ul class="related-services-list">';
                                foreach ($related_services as $service) {
                                    $icon = get_post_meta($service->ID, 'service_icon', true);
                                    echo '<li>';
                                    echo '<a href="' . get_permalink($service->ID) . '">';
                                    if ($icon) {
                                        echo '<i class="' . esc_attr($icon) . '"></i>';
                                    }
                                    echo esc_html($service->post_title);
                                    echo '</a>';
                                    echo '</li>';
                                }
                                echo '</ul>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="service-actions">
                    <?php if ($service_url) : ?>
                        <a href="<?php echo esc_url($service_url); ?>" class="btn btn-primary btn-large">
                            <i class="fa-solid fa-arrow-right"></i>
                            Start Application
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo get_post_type_archive_link('gov_service'); ?>" class="btn btn-outline">
                        <i class="fa-solid fa-arrow-left"></i>
                        Back to Services
                    </a>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<style>
.service-detail {
    padding: 2rem 0;
}

.service-breadcrumb {
    margin-bottom: 2rem;
    font-size: 0.9rem;
}

.service-breadcrumb a {
    color: #0073aa;
    text-decoration: none;
}

.service-breadcrumb span {
    margin: 0 0.5rem;
    color: #666;
}

.service-hero {
    display: flex;
    gap: 2rem;
    margin-bottom: 3rem;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.service-icon-large {
    flex-shrink: 0;
}

.service-icon-large i {
    font-size: 4rem;
    color: #0073aa;
}

.service-info h1 {
    margin: 0 0 1rem 0;
    color: #1e1e1e;
}

.service-excerpt {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 1.5rem;
}

.service-meta {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.meta-item i {
    color: #0073aa;
}

.service-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.service-requirements {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    border-radius: 4px;
}

.service-requirements h3 {
    margin: 0 0 1rem 0;
    color: #856404;
}

.service-requirements h3 i {
    margin-right: 0.5rem;
}

.sidebar-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.sidebar-card h3 {
    margin: 0 0 1rem 0;
    color: #1e1e1e;
}

.related-services-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.related-services-list li {
    margin-bottom: 0.75rem;
}

.related-services-list a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #0073aa;
    text-decoration: none;
    padding: 0.5rem;
    border-radius: 4px;
    transition: background-color 0.3s;
}

.related-services-list a:hover {
    background-color: #f0f8ff;
}

.service-actions {
    text-align: center;
    padding: 2rem 0;
    border-top: 1px solid #eee;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
    margin: 0 0.5rem;
}

.btn-primary {
    background: #0073aa;
    color: white;
    border: 2px solid #0073aa;
}

.btn-primary:hover {
    background: #005a87;
    border-color: #005a87;
}

.btn-outline {
    background: transparent;
    color: #0073aa;
    border: 2px solid #0073aa;
}

.btn-outline:hover {
    background: #0073aa;
    color: white;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .service-hero {
        flex-direction: column;
        text-align: center;
    }
    
    .service-content {
        grid-template-columns: 1fr;
    }
    
    .service-meta {
        justify-content: center;
    }
    
    .btn {
        margin: 0.5rem;
    }
}
</style>

<?php get_footer(); ?> 