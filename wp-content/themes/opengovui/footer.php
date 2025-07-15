<footer class="gov-footer">
    <div class="container">
        <div class="footer-sections">
            <div class="footer-primary">
                <div class="footer-brand">
                    <?php
                    $logo_url = get_template_directory_uri() . '/../../../images/govt-logo.png';
                    if (file_exists(get_template_directory() . '/../../../images/govt-logo.png')) {
                        ?>
                        <img src="<?php echo esc_url($logo_url); ?>" width="50" height="50" alt="<?php bloginfo('name'); ?> Logo">
                        <?php
                    }
                    ?>
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
                        <?php
                        // Get About page
                        $about_page = get_page_by_path('about');
                        $about_url = $about_page ? get_permalink($about_page->ID) : '#';
                        ?>
                        <li><a href="<?php echo esc_url($about_url); ?>" data-i18n="footer.quickLinks.aboutSL">About Norvalis</a></li>
                        <li><a href="#" data-i18n="footer.quickLinks.gazette">Government Gazette</a></li>
                        <li><a href="#" data-i18n="footer.quickLinks.parliament">Parliament</a></li>
                        <li><a href="<?php echo get_post_type_archive_link('service_category'); ?>" data-i18n="footer.quickLinks.departments">Departments</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 data-i18n="footer.help.title">Help & Support</h4>
                    <ul>
                        <?php
                        // Get Contact page
                        $contact_page = get_page_by_path('contact');
                        $contact_url = $contact_page ? get_permalink($contact_page->ID) : '#';
                        ?>
                        <li><a href="<?php echo esc_url($contact_url); ?>" data-i18n="footer.help.contact">Contact Us</a></li>
                        <li><a href="#" data-i18n="footer.help.faq">FAQs</a></li>
                        <li><a href="<?php echo home_url('/sitemap'); ?>" data-i18n="footer.help.siteMap">Site Map</a></li>
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
            <p data-i18n="footer.copyright">© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html> 