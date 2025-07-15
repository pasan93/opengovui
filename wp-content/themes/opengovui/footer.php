<footer class="gov-footer">
    <div class="footer-main">
        <div class="container">
            <div class="footer-content">
                <!-- Services Section -->
                <div class="footer-section">
                    <h3 data-i18n="footer.services.title">Services</h3>
                    <ul>
                        <li><a href="#" data-i18n="footer.services.benefits">Benefits</a></li>
                        <li><a href="#" data-i18n="footer.services.births">Births, deaths, marriages</a></li>
                        <li><a href="#" data-i18n="footer.services.business">Business and self-employed</a></li>
                        <li><a href="#" data-i18n="footer.services.childcare">Childcare and parenting</a></li>
                        <li><a href="#" data-i18n="footer.services.citizenship">Citizenship and living abroad</a></li>
                        <li><a href="#" data-i18n="footer.services.crime">Crime, justice and the law</a></li>
                    </ul>
                </div>

                <!-- Government Activity -->
                <div class="footer-section">
                    <h3 data-i18n="footer.government.title">Government activity</h3>
                    <ul>
                        <?php
                        $about_page = get_page_by_path('about');
                        $about_url = $about_page ? get_permalink($about_page->ID) : '#';
                        ?>
                        <li><a href="<?php echo esc_url($about_url); ?>" data-i18n="footer.government.departments">Departments</a></li>
                        <li><a href="#" data-i18n="footer.government.news">News</a></li>
                        <li><a href="#" data-i18n="footer.government.guidance">Guidance and regulation</a></li>
                        <li><a href="#" data-i18n="footer.government.research">Research and statistics</a></li>
                        <li><a href="#" data-i18n="footer.government.consultations">Policy papers and consultations</a></li>
                        <li><a href="#" data-i18n="footer.government.transparency">Transparency</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div class="footer-section">
                    <h3 data-i18n="footer.support.title">Support links</h3>
                    <ul>
                        <?php
                        $contact_page = get_page_by_path('contact');
                        $contact_url = $contact_page ? get_permalink($contact_page->ID) : '#';
                        ?>
                        <li><a href="#" data-i18n="footer.support.help">Help</a></li>
                        <li><a href="#" data-i18n="footer.support.privacy">Privacy</a></li>
                        <li><a href="#" data-i18n="footer.support.cookies">Cookies</a></li>
                        <li><a href="#" data-i18n="footer.support.accessibility">Accessibility statement</a></li>
                        <li><a href="<?php echo esc_url($contact_url); ?>" data-i18n="footer.support.contact">Contact</a></li>
                        <li><a href="#" data-i18n="footer.support.terms">Terms and conditions</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-meta">
        <div class="container">
            <div class="footer-meta-content">
                <div class="footer-meta-left">
                    <div class="footer-logo">
                        <?php
                        $logo_url = get_template_directory_uri() . '/../../../images/govt-logo.png';
                        if (file_exists(get_template_directory() . '/../../../images/govt-logo.png')) {
                            ?>
                            <img src="<?php echo esc_url($logo_url); ?>" width="40" height="40" alt="Government Logo">
                            <?php
                        }
                        ?>
                        <div class="footer-logo-text">
                            <div class="logo-title" data-i18n="footer.meta.crown">Crown copyright</div>
                            <div class="logo-subtitle" data-i18n="footer.meta.govtName"><?php bloginfo('name'); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="footer-meta-right">
                    <div class="footer-license">
                        <p data-i18n="footer.meta.license">
                            All content is available under the 
                            <a href="#" data-i18n="footer.meta.licenseLink">Open Government Licence v3.0</a>, 
                            except where otherwise stated
                        </p>
                    </div>
                    
                    <div class="footer-social">
                        <span data-i18n="footer.meta.followUs">Follow us:</span>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook" data-i18n-aria="footer.social.facebook">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" aria-label="Twitter" data-i18n-aria="footer.social.twitter">
                                <i class="fa-brands fa-square-x-twitter"></i>
                            </a>
                            <a href="#" aria-label="LinkedIn" data-i18n-aria="footer.social.linkedin">
                                <i class="fa-brands fa-linkedin-in"></i>
                            </a>
                            <a href="#" aria-label="YouTube" data-i18n-aria="footer.social.youtube">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html> 