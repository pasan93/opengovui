<?php
/**
 * Content Populator for OpenGovUI
 * Creates all services, categories, and content from frontend in WordPress
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class OpenGovUI_Content_Populator {
    
    public function __construct() {
        add_action('wp_loaded', array($this, 'maybe_populate_content'));
        add_action('wp_ajax_populate_content', array($this, 'ajax_populate_content'));
        add_action('wp_ajax_nopriv_populate_content', array($this, 'ajax_populate_content'));
    }
    
    public function maybe_populate_content() {
        // Only run if requested via admin or AJAX
        if (isset($_GET['populate_opengovui_content']) && current_user_can('manage_options')) {
            $this->populate_all_content();
            wp_redirect(admin_url('admin.php?page=opengovui-content&populated=1'));
            exit;
        }
    }
    
    public function ajax_populate_content() {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized');
        }
        
        $result = $this->populate_all_content();
        wp_send_json_success($result);
    }
    
    public function populate_all_content() {
        $results = array();
        
        // Create categories first
        $results['categories'] = $this->create_service_categories();
        
        // Create services
        $results['services'] = $this->create_government_services();
        
        // Create government updates
        $results['updates'] = $this->create_government_updates();
        
        // Create pages
        $results['pages'] = $this->create_main_pages();
        
        return $results;
    }
    
    private function create_service_categories() {
        $categories = array(
            array(
                'title' => array(
                    'en' => 'Health & Care',
                    'si' => 'සෞඛ්‍ය හා සත්කාර',
                    'ta' => 'சுகாதாரம் மற்றும் பராமரிப்பு'
                ),
                'description' => array(
                    'en' => 'Healthcare, insurance, elderly care',
                    'si' => 'සෞඛ්‍ය සේවා, රක්ෂණ, වැඩිහිටි සත්කාර',
                    'ta' => 'சுகாதாரம், காப்பீடு, முதியோர் பராமரிப்பு'
                ),
                'icon' => 'fa-solid fa-heart-pulse',
                'color' => '#e74c3c',
                'slug' => 'health-care'
            ),
            array(
                'title' => array(
                    'en' => 'Business',
                    'si' => 'ව්‍යාපාර',
                    'ta' => 'வணிகம்'
                ),
                'description' => array(
                    'en' => 'Registration, licenses, taxes',
                    'si' => 'ලියාපදිංචිය, බලපත්‍ර, බදු',
                    'ta' => 'பதிவு, உரிமங்கள், வரிகள்'
                ),
                'icon' => 'fa-solid fa-briefcase',
                'color' => '#3498db',
                'slug' => 'business'
            ),
            array(
                'title' => array(
                    'en' => 'Housing',
                    'si' => 'නිවාස',
                    'ta' => 'வீட்டுவசதி'
                ),
                'description' => array(
                    'en' => 'Property, utilities, local services',
                    'si' => 'දේපල, උපයෝගිතා, ප්‍රාදේශීය සේවා',
                    'ta' => 'சொத்து, பயன்பாடுகள், உள்ளூர் சேவைகள்'
                ),
                'icon' => 'fa-solid fa-house',
                'color' => '#2ecc71',
                'slug' => 'housing'
            ),
            array(
                'title' => array(
                    'en' => 'Immigration',
                    'si' => 'ගමනාගමනය',
                    'ta' => 'குடியுரிமை'
                ),
                'description' => array(
                    'en' => 'Visas, citizenship, work permits',
                    'si' => 'වීසා, පුරවැසිභාවය, වැඩ බලපත්‍ර',
                    'ta' => 'விசாக்கள், குடியுரிமை, வேலை அனுமதிகள்'
                ),
                'icon' => 'fa-solid fa-plane',
                'color' => '#9b59b6',
                'slug' => 'immigration'
            )
        );
        
        $created_categories = array();
        
        foreach ($categories as $category) {
            $created_categories[$category['slug']] = $this->create_multilingual_post(
                'service_category',
                $category['title'],
                $category['description'],
                array(
                    'category_icon' => $category['icon'],
                    'category_color' => $category['color']
                ),
                $category['slug']
            );
        }
        
        return $created_categories;
    }
    
    private function create_government_services() {
        $services = array(
            array(
                'title' => array(
                    'en' => 'National ID',
                    'si' => 'ජාතික හැදුනුම්පත',
                    'ta' => 'தேசிய அடையாள அட்டை'
                ),
                'description' => array(
                    'en' => 'Apply for or renew your National Identity Card',
                    'si' => 'ඔබගේ ජාතික හැදුනුම්පත සඳහා අයදුම් කරන්න හෝ අලුත් කරන්න',
                    'ta' => 'உங்கள் தேசிய அடையாள அட்டைக்கு விண்ணப்பிக்கவும் அல்லது புதுப்பிக்கவும்'
                ),
                'content' => array(
                    'en' => '<h2>National Identity Card Services</h2>
                    <p>Apply for a new National ID or renew your existing card through our online portal.</p>
                    <h3>Required Documents</h3>
                    <ul>
                        <li>Birth Certificate</li>
                        <li>Two passport-sized photographs</li>
                        <li>Proof of address</li>
                    </ul>
                    <h3>Processing Time</h3>
                    <p>Standard processing: 2-3 weeks<br>Express processing: 1 week (additional fee applies)</p>',
                    'si' => '<h2>ජාතික හැදුනුම්පත් සේවා</h2>
                    <p>අපගේ අන්තර්ජාල ද්වාර හරහා නව ජාතික හැදුනුම්පතක් සඳහා අයදුම් කරන්න හෝ පවතින කාඩ්පත අලුත් කරන්න.</p>
                    <h3>අවශ්‍ය ලියකියවිලි</h3>
                    <ul>
                        <li>උප්පැන්න සහතිකය</li>
                        <li>ගමන් බලපත්‍ර ප්‍රමාණයේ ඡායාරූප දෙකක්</li>
                        <li>ලිපින සාක්ෂිය</li>
                    </ul>
                    <h3>සැකසීමේ කාලය</h3>
                    <p>සම්මත සැකසීම: සති 2-3<br>වේගවත් සැකසීම: සතියක් (අමතර ගාස්තුවක් අදාළ වේ)</p>',
                    'ta' => '<h2>தேசிய அடையாள அட்டை சேவைகள்</h2>
                    <p>எங்கள் ஆன்லைன் போர்ட்டல் மூலம் புதிய தேசிய அடையாள அட்டைக்கு விண்ணப்பிக்கவும் அல்லது உங்கள் தற்போதைய அட்டையை புதுப்பிக்கவும்.</p>
                    <h3>தேவையான ஆவணங்கள்</h3>
                    <ul>
                        <li>பிறப்பு சான்றிதழ்</li>
                        <li>இரண்டு பாஸ்போர்ட் அளவு புகைப்படங்கள்</li>
                        <li>முகவரி சான்று</li>
                    </ul>
                    <h3>செயலாக்க நேரம்</h3>
                    <p>நிலையான செயலாக்கம்: 2-3 வாரங்கள்<br>விரைவு செயலாக்கம்: 1 வாரம் (கூடுதல் கட்டணம் பொருந்தும்)</p>'
                ),
                'icon' => 'fa-solid fa-id-card',
                'url' => '/services/national-id',
                'requirements' => 'Birth certificate, photographs, proof of address',
                'processing_time' => '2-3 weeks',
                'featured' => true,
                'slug' => 'national-id'
            ),
            array(
                'title' => array(
                    'en' => 'Passport',
                    'si' => 'ගමන් බලපත්‍රය',
                    'ta' => 'கடவுச்சீட்டு'
                ),
                'description' => array(
                    'en' => 'Apply for or renew your passport',
                    'si' => 'ඔබගේ ගමන් බලපත්‍රය සඳහා අයදුම් කරන්න හෝ අලුත් කරන්න',
                    'ta' => 'உங்கள் கடவுச்சீட்டுக்கு விண்ணப்பிக்கவும் அல்லது புதுப்பிக்கவும்'
                ),
                'content' => array(
                    'en' => '<h2>Passport Services</h2>
                    <p>Apply for a new passport or renew your existing passport for international travel.</p>
                    <h3>Required Documents</h3>
                    <ul>
                        <li>National Identity Card</li>
                        <li>Birth Certificate</li>
                        <li>Two passport-sized photographs</li>
                        <li>Previous passport (for renewals)</li>
                    </ul>
                    <h3>Processing Time</h3>
                    <p>Standard processing: 3-4 weeks<br>Express processing: 1-2 weeks (additional fee applies)</p>',
                    'si' => '<h2>ගමන් බලපත්‍ර සේවා</h2>
                    <p>ජාත්‍යන්තර සංචාරය සඳහා නව ගමන් බලපත්‍රයක් සඳහා අයදුම් කරන්න හෝ ඔබගේ පවතින ගමන් බලපත්‍රය අලුත් කරන්න.</p>
                    <h3>අවශ්‍ය ලියකියවිලි</h3>
                    <ul>
                        <li>ජාතික හැදුනුම්පත</li>
                        <li>උප්පැන්න සහතිකය</li>
                        <li>ගමන් බලපත්‍ර ප්‍රමාණයේ ඡායාරූප දෙකක්</li>
                        <li>පෙර ගමන් බලපත්‍රය (අලුත් කිරීම් සඳහා)</li>
                    </ul>
                    <h3>සැකසීමේ කාලය</h3>
                    <p>සම්මත සැකසීම: සති 3-4<br>වේගවත් සැකසීම: සති 1-2 (අමතර ගාස්තුවක් අදාළ වේ)</p>',
                    'ta' => '<h2>கடவுச்சீட்டு சேவைகள்</h2>
                    <p>சர்வதேச பயணத்திற்காக புதிய கடவுச்சீட்டுக்கு விண்ணப்பிக்கவும் அல்லது உங்கள் தற்போதைய கடவுச்சீட்டை புதுப்பிக்கவும்.</p>
                    <h3>தேவையான ஆவணங்கள்</h3>
                    <ul>
                        <li>தேசிய அடையாள அட்டை</li>
                        <li>பிறப்பு சான்றிதழ்</li>
                        <li>இரண்டு பாஸ்போர்ட் அளவு புகைப்படங்கள்</li>
                        <li>முந்தைய கடவுச்சீட்டு (புதுப்பிப்புகளுக்கு)</li>
                    </ul>
                    <h3>செயலாக்க நேரம்</h3>
                    <p>நிலையான செயலாக்கம்: 3-4 வாரங்கள்<br>விரைவு செயலாக்கம்: 1-2 வாரங்கள் (கூடுதல் கட்டணம் பொருந்தும்)</p>'
                ),
                'icon' => 'fa-solid fa-passport',
                'url' => '/services/passport',
                'requirements' => 'National ID, birth certificate, photographs',
                'processing_time' => '3-4 weeks',
                'featured' => true,
                'slug' => 'passport'
            ),
            array(
                'title' => array(
                    'en' => 'Vehicle Registration',
                    'si' => 'වාහන ලියාපදිංචිය',
                    'ta' => 'வாகன பதிவு'
                ),
                'description' => array(
                    'en' => 'Register or transfer vehicle ownership',
                    'si' => 'වාහන හිමිකම ලියාපදිංචි කරන්න හෝ මාරු කරන්න',
                    'ta' => 'வாகன உரிமையை பதிவு செய்யவும் அல்லது மாற்றவும்'
                ),
                'content' => array(
                    'en' => '<h2>Vehicle Registration Services</h2>
                    <p>Register new vehicles or transfer ownership of existing vehicles.</p>
                    <h3>Required Documents</h3>
                    <ul>
                        <li>Vehicle import permit</li>
                        <li>Insurance certificate</li>
                        <li>Technical inspection report</li>
                        <li>National Identity Card</li>
                    </ul>
                    <h3>Processing Time</h3>
                    <p>Standard processing: 1-2 weeks</p>',
                    'si' => '<h2>වාහන ලියාපදිංචි සේවා</h2>
                    <p>නව වාහන ලියාපදිංචි කරන්න හෝ පවතින වාහනවල හිමිකම මාරු කරන්න.</p>
                    <h3>අවශ්‍ය ලියකියවිලි</h3>
                    <ul>
                        <li>වාහන ආනයන බලපත්‍රය</li>
                        <li>රක්ෂණ සහතිකය</li>
                        <li>තාක්ෂණික පරීක්ෂණ වාර්තාව</li>
                        <li>ජාතික හැදුනුම්පත</li>
                    </ul>
                    <h3>සැකසීමේ කාලය</h3>
                    <p>සම්මත සැකසීම: සති 1-2</p>',
                    'ta' => '<h2>வாகன பதிவு சேவைகள்</h2>
                    <p>புதிய வாகனங்களை பதிவு செய்யவும் அல்லது தற்போதுள்ள வாகனங்களின் உரிமையை மாற்றவும்.</p>
                    <h3>தேவையான ஆவணங்கள்</h3>
                    <ul>
                        <li>வாகன இறக்குமதி அனுமதி</li>
                        <li>காப்பீட்டு சான்றிதழ்</li>
                        <li>தொழில்நுட்ப ஆய்வு அறிக்கை</li>
                        <li>தேசிய அடையாள அட்டை</li>
                    </ul>
                    <h3>செயலாக்க நேரம்</h3>
                    <p>நிலையான செயலாக்கம்: 1-2 வாரங்கள்</p>'
                ),
                'icon' => 'fa-solid fa-car',
                'url' => '/services/vehicle-registration',
                'requirements' => 'Import permit, insurance, inspection report, National ID',
                'processing_time' => '1-2 weeks',
                'featured' => true,
                'slug' => 'vehicle-registration'
            ),
            array(
                'title' => array(
                    'en' => 'Education',
                    'si' => 'අධ්‍යාපනය',
                    'ta' => 'கல்வி'
                ),
                'description' => array(
                    'en' => 'Access educational services',
                    'si' => 'අධ්‍යාපන සේවා වලට ප්‍රවේශය',
                    'ta' => 'கல்வி சேவைகளை அணுகவும்'
                ),
                'content' => array(
                    'en' => '<h2>Education Services</h2>
                    <p>Access various educational services including school admissions, scholarships, and certificate verification.</p>
                    <h3>Available Services</h3>
                    <ul>
                        <li>School admissions</li>
                        <li>Scholarship applications</li>
                        <li>Certificate verification</li>
                        <li>Educational transcripts</li>
                    </ul>',
                    'si' => '<h2>අධ්‍යාපන සේවා</h2>
                    <p>පාසල් ප්‍රවේශ, ශිෂ්‍යත්ව සහ සහතික සත්‍යාපන ඇතුළු විවිධ අධ්‍යාපන සේවා වලට ප්‍රවේශ වන්න.</p>
                    <h3>ලබා ගත හැකි සේවා</h3>
                    <ul>
                        <li>පාසල් ප්‍රවේශ</li>
                        <li>ශිෂ්‍යත්ව අයදුම්</li>
                        <li>සහතික සත්‍යාපනය</li>
                        <li>අධ්‍යාපන ප්‍රතිලේඛන</li>
                    </ul>',
                    'ta' => '<h2>கல்வி சேவைகள்</h2>
                    <p>பள்ளி சேர்க்கை, உதவித்தொகை மற்றும் சான்றிதழ் சரிபார்ப்பு உட்பட பல்வேறு கல்வி சேவைகளை அணுகவும்.</p>
                    <h3>கிடைக்கும் சேவைகள்</h3>
                    <ul>
                        <li>பள்ளி சேர்க்கை</li>
                        <li>உதவித்தொகை விண்ணப்பங்கள்</li>
                        <li>சான்றிதழ் சரிபார்ப்பு</li>
                        <li>கல்வி பதிவுகள்</li>
                    </ul>'
                ),
                'icon' => 'fa-solid fa-graduation-cap',
                'url' => '/services/education',
                'requirements' => 'Varies by service',
                'processing_time' => 'Varies by service',
                'featured' => true,
                'slug' => 'education'
            )
        );
        
        $created_services = array();
        
        foreach ($services as $service) {
            $created_services[$service['slug']] = $this->create_multilingual_post(
                'gov_service',
                $service['title'],
                $service['description'],
                array(
                    'service_icon' => $service['icon'],
                    'service_url' => $service['url'],
                    'service_requirements' => $service['requirements'],
                    'service_processing_time' => $service['processing_time'],
                    'featured' => $service['featured'] ? '1' : '0'
                ),
                $service['slug'],
                $service['content']
            );
        }
        
        return $created_services;
    }
    
    private function create_government_updates() {
        $updates = array(
            array(
                'title' => array(
                    'en' => 'New Online Portal Launch',
                    'si' => 'නව අන්තර්ජාල ද්වාර ආරම්භය',
                    'ta' => 'புதிய ஆன்லைன் போர்ட்டல் தொடக்கம்'
                ),
                'description' => array(
                    'en' => 'Government launches new digital portal for improved citizen services',
                    'si' => 'වැඩිදියුණු කළ පුරවැසි සේවා සඳහා රජය නව ඩිජිටල් ද්වාරයක් ආරම්භ කරයි',
                    'ta' => 'மேம்பட்ட குடிமக்கள் சேவைகளுக்காக அரசாங்கம் புதிய டிஜிட்டல் போர்ட்டலை அறிமுகப்படுத்துகிறது'
                ),
                'content' => array(
                    'en' => '<p>The Government of Norvalis is pleased to announce the launch of our new digital portal, designed to provide citizens with easier access to government services.</p><p>The portal features improved user interface, faster processing times, and enhanced security measures.</p>',
                    'si' => '<p>නෝවාලිස් රජය පුරවැසියන්ට රජයේ සේවා වලට පහසුවෙන් ප්‍රවේශ වීමට සැලසුම් කර ඇති අපගේ නව ඩිජිටල් ද්වාරය ආරම්භ කිරීම ගැන සතුටින් දන්වයි.</p><p>ද්වාරයේ වැඩිදියුණු කළ පරිශීලක අතුරුමුખය, වේගවත් සැකසීමේ කාලය සහ වැඩිදියුණු කළ ආරක්ෂක ක්‍රම ඇතුළත් වේ.</p>',
                    'ta' => '<p>குடிமக்களுக்கு அரசாங்க சேவைகளுக்காக எளிதாக அணுக வடிவமைக்கப்பட்ட எங்கள் புதிய டிஜிட்டல் போர்ட்டலின் தொடக்கத்தை நோர்வாலிஸ் அரசாங்கம் மகிழ்ச்சியுடன் அறிவிக்கிறது.</p><p>போர்ட்டல் மேம்பட்ட பயனர் இடைமுகம், வேகமான செயலாக்க நேரங்கள் மற்றும் மேம்பட்ட பாதுகாப்பு நடவடிக்கைகளைக் கொண்டுள்ளது.</p>'
                ),
                'slug' => 'new-online-portal-launch'
            ),
            array(
                'title' => array(
                    'en' => 'Digital ID Cards Available',
                    'si' => 'ඩිජිටල් හැදුනුම්පත් ලබා ගත හැක',
                    'ta' => 'டிஜிட்டல் அடையாள அட்டைகள் கிடைக்கின்றன'
                ),
                'description' => array(
                    'en' => 'Citizens can now apply for digital versions of their National ID cards',
                    'si' => 'පුරවැසියන්ට දැන් ඔවුන්ගේ ජාතික හැදුනුම්පත්වල ඩිජිටල් අනුවාද සඳහා අයදුම් කළ හැකිය',
                    'ta' => 'குடிமக்கள் இப்போது தங்கள் தேசிய அடையாள அட்டைகளின் டிஜிட்டல் பதிப்புகளுக்கு விண்ணப்பிக்கலாம்'
                ),
                'content' => array(
                    'en' => '<p>Starting this month, citizens can apply for secure digital versions of their National Identity Cards through our online portal.</p><p>Digital IDs offer the same legal validity as physical cards while providing enhanced convenience and security.</p>',
                    'si' => '<p>මෙම මාසයේ සිට, පුරවැසියන්ට අපගේ අන්තර්ජාල ද්වාරය හරහා ඔවුන්ගේ ජාතික හැදුනුම්පත්වල ආරක්ෂිත ඩිජිටල් අනුවාද සඳහා අයදුම් කළ හැකිය.</p><p>ඩිජිටල් හැදුනුම්පත් භෞතික කාඩ්පත් හා සමාන නීතිමය වලංගුභාවයක් ලබා දෙන අතර වැඩිදියුණු කළ පහසුව සහ ආරක්ෂාව සපයයි.</p>',
                    'ta' => '<p>இந்த மாதம் தொடங்கி, குடிமக்கள் எங்கள் ஆன்லைன் போர்ட்டல் மூலம் தங்கள் தேசிய அடையாள அட்டைகளின் பாதுகாப்பான டிஜிட்டல் பதிப்புகளுக்கு விண்ணப்பிக்கலாம்.</p><p>டிஜிட்டல் ஐடிகள் இயற்பியல் அட்டைகளின் அதே சட்ட செல்லுபடியாகும் தன்மையை வழங்குகின்றன, அதே நேரத்தில் மேம்பட்ட வசதி மற்றும் பாதுகாப்பை வழங்குகின்றன.</p>'
                ),
                'slug' => 'digital-id-cards-available'
            )
        );
        
        $created_updates = array();
        
        foreach ($updates as $update) {
            $created_updates[$update['slug']] = $this->create_multilingual_post(
                'gov_update',
                $update['title'],
                $update['description'],
                array(),
                $update['slug'],
                $update['content']
            );
        }
        
        return $created_updates;
    }
    
    private function create_main_pages() {
        $pages = array(
            array(
                'title' => array(
                    'en' => 'About Norvalis',
                    'si' => 'නෝවාලිස් ගැන',
                    'ta' => 'நோர்வாலிஸ் பற்றி'
                ),
                'content' => array(
                    'en' => '<h1>About the Government of Norvalis</h1><p>Welcome to the official government portal of Norvalis. We are committed to providing transparent, efficient, and accessible services to all citizens.</p>',
                    'si' => '<h1>නෝවාලිස් රජය ගැන</h1><p>නෝවාලිස් හි නිල රජයේ ද්වාරයට සාදරයෙන් පිළිගනිමු. සියලුම පුරවැසියන්ට විනිවිද පෙනෙන, කාර්යක්ෂම සහ ප්‍රවේශ විය හැකි සේවා සැපයීමට අපි කැපවී සිටිමු.</p>',
                    'ta' => '<h1>நோர்வாலிஸ் அரசாங்கம் பற்றி</h1><p>நோர்வாலிஸின் அதிகாரப்பூர்வ அரசாங்க போர்ட்டலில் உங்களை வரவேற்கிறோம். அனைத்து குடிமக்களுக்கும் வெளிப்படையான, திறமையான மற்றும் அணுகக்கூடிய சேவைகளை வழங்க நாங்கள் உறுதிபூண்டுள்ளோம்.</p>'
                ),
                'slug' => 'about'
            ),
            array(
                'title' => array(
                    'en' => 'Contact Us',
                    'si' => 'අප අමතන්න',
                    'ta' => 'எங்களை தொடர்பு கொள்ளுங்கள்'
                ),
                'content' => array(
                    'en' => '<h1>Contact Information</h1><p>Get in touch with government departments and services.</p><h2>General Information</h2><p>Phone: +94 11 123 4567<br>Email: info@gov.nv</p>',
                    'si' => '<h1>සම්බන්ධතා තොරතුරු</h1><p>රාජ්‍ය දෙපාර්තමේන්තු සහ සේවා සමඟ සම්බන්ධ වන්න.</p><h2>සාමාන්‍ය තොරතුරු</h2><p>දුරකථනය: +94 11 123 4567<br>විද්‍යුත් තැපෑල: info@gov.nv</p>',
                    'ta' => '<h1>தொடர்பு தகவல்</h1><p>அரசாங்க துறைகள் மற்றும் சேவைகளுடன் தொடர்பு கொள்ளுங்கள்.</p><h2>பொது தகவல்</h2><p>தொலைபேசி: +94 11 123 4567<br>மின்னஞ்சல்: info@gov.nv</p>'
                ),
                'slug' => 'contact'
            )
        );
        
        $created_pages = array();
        
        foreach ($pages as $page) {
            $created_pages[$page['slug']] = $this->create_multilingual_post(
                'page',
                $page['title'],
                array(),
                array(),
                $page['slug'],
                $page['content']
            );
        }
        
        return $created_pages;
    }
    
    private function create_multilingual_post($post_type, $titles, $excerpts = array(), $meta = array(), $slug = '', $contents = array()) {
        $created_posts = array();
        $languages = array('en', 'si', 'ta');
        $post_ids = array();
        
        foreach ($languages as $lang) {
            $post_data = array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'post_title' => $titles[$lang],
                'post_name' => $slug . ($lang !== 'en' ? '-' . $lang : ''),
                'post_content' => isset($contents[$lang]) ? $contents[$lang] : '',
                'post_excerpt' => isset($excerpts[$lang]) ? $excerpts[$lang] : ''
            );
            
            // Check if post already exists
            $existing_post = get_page_by_path($post_data['post_name'], OBJECT, $post_type);
            if ($existing_post) {
                $post_id = $existing_post->ID;
                wp_update_post(array_merge($post_data, array('ID' => $post_id)));
            } else {
                $post_id = wp_insert_post($post_data);
            }
            
            if ($post_id && !is_wp_error($post_id)) {
                // Add meta fields
                foreach ($meta as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                }
                
                // Set language if Polylang is active
                if (function_exists('pll_set_post_language')) {
                    pll_set_post_language($post_id, $lang);
                }
                
                $post_ids[$lang] = $post_id;
                $created_posts[$lang] = $post_id;
            }
        }
        
        // Link translations if Polylang is active
        if (function_exists('pll_save_post_translations') && count($post_ids) > 1) {
            pll_save_post_translations($post_ids);
        }
        
        return $created_posts;
    }
}

new OpenGovUI_Content_Populator();

?> 