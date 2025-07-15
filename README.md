# OpenGovUI

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-2.1.0-green.svg)
![Static Template](https://img.shields.io/badge/static%20template-v1.2.0-blue.svg)
![WordPress CMS](https://img.shields.io/badge/wordpress%20cms-v2.1.0-green.svg)

<img width="1399" alt="image" src="https://github.com/user-attachments/assets/16597505-da85-4ffd-8ddc-6b598f2afa2b">

A 100% open source modern, accessible, and multilingual website template designed specifically for government portals. Available as both a **static HTML template** and a **full WordPress CMS solution** with advanced multilingual support.

[Live Demo](https://govui.openxs.org)

## 🚀 **Two Deployment Options**

### 📄 **Option 1: Static Template** *(Recommended for simple sites)*
Perfect for straightforward government portals that don't need content management.

- **✅ No server required** - Works with any web hosting
- **✅ Fast loading** - Pure HTML/CSS/JavaScript
- **✅ Easy deployment** - Just upload files
- **✅ No database needed**

### 🎛️ **Option 2: WordPress CMS** *(Recommended for dynamic content)*
Full content management system with advanced multilingual support and admin interface.

- **✅ Admin dashboard** - Manage content without coding
- **✅ Custom post types** - Services, Categories, Government Updates
- **✅ Polylang integration** - Professional multilingual support
- **✅ REST API** - Advanced integration capabilities
- **✅ Content population** - Automated content creation system
- **✅ Translation management** - Auto-translation capabilities

---

## 🌟 Features

### 📱 Responsive Design
- Mobile-first approach
- Fluid layouts that work across all device sizes
- Optimised navigation for both desktop and mobile users

### ♿ Accessibility
- Skip to main content functionality
- ARIA labels where necessary
- Semantic HTML structure
- Government accessibility standards compliant

### 🌐 Advanced Multilingual Support
- **Polylang Integration**: Professional WordPress multilingual plugin support
- **Language Syncing**: Automatic synchronization of meta fields across translations
- **Smart Language Detection**: Automatic language mapping and detection
- **Translation Management**: Built-in auto-translation capabilities
- **Content Synchronization**: Seamless content management across all languages
- Full support for **English (en_GB, en_US)**, **Sinhala (si_LK)**, and **Tamil (ta_LK)**

### 🎨 Design Features [[memory:3285333]]
- Clean, professional government aesthetic with rounded, easy-to-read fonts
- FontAwesome 6.5.1 icons (CDN hosted)
- Service cards with intuitive icons
- Grid-based layouts for services and topics
- Social media integration
- Custom color schemes for categories

### 🔧 WordPress CMS Advanced Features
- **Custom Post Types**: 
  - Government Services with rich metadata
  - Service Categories with icons and colors
  - Government Updates with featured content
- **Enhanced REST API**: Custom endpoints for all content types
- **Content Population System**: One-click content creation with sample data
- **Meta Field Management**: Service URLs, processing times, requirements, featured status
- **Admin Interface**: Custom admin pages for content management
- **Language-Aware Content**: All content respects current language context

---

## 🚀 **Quick Start - Static Template**

Perfect for simple government portals. No server or database required.

### Download Static Template
```bash
# Get the static template (v1.2.0)
git clone -b v1.2.0 https://github.com/pasan93/opengovui.git opengovui-static
cd opengovui-static
```

### Deploy
1. **Local Development:**
   ```bash
   python3 -m http.server 3000
   ```
   Open http://localhost:3000

2. **Production:** Upload files to any web hosting service

---

## 🎛️ **Quick Start - WordPress CMS**

Full content management system with advanced multilingual capabilities.

### Requirements
- **PHP 8.4+**
- **MariaDB/MySQL**
- **Web server** (Apache/Nginx) or PHP built-in server
- **Polylang Plugin** (for full multilingual support)

### Installation
```bash
# Get the WordPress version (v2.1.0)
git clone https://github.com/pasan93/opengovui.git opengovui-cms
cd opengovui-cms
```

### Setup WordPress
1. **Download WordPress Core:**
   ```bash
   curl -O https://wordpress.org/latest.tar.gz
   tar -xzf latest.tar.gz
   cp -r wordpress/* .
   rm -rf wordpress latest.tar.gz
   ```

2. **Setup Database:**
   ```bash
   mariadb -u root < setup_database.sql
   ```

3. **Start Server:**
   ```bash
   php -S localhost:8080
   ```

4. **Complete Installation:**
   - Open http://localhost:8080
   - Follow WordPress installation wizard
   - **Install Polylang Plugin** for multilingual support
   - Activate "OpenGovUI" theme
   - **Populate Content**: Use the built-in content population system
   - Start managing government services and content!

📚 **[View Full WordPress Setup Guide](WORDPRESS_SETUP_GUIDE.md)**

---

## 🔧 Structure

### Static Template Structure
```
opengovui-static/
├── index.html          # Main page
├── css/
│   └── styles.css      # Styling
├── js/
│   ├── i18n.js        # Internationalization
│   └── script.js      # Interactive features
└── images/
    └── govt-logo.png  # Government branding
```

### WordPress CMS Structure
```
opengovui-cms/
├── wp-content/
│   ├── themes/
│   │   └── opengovui/           # Custom government theme
│   │       ├── style.css        # Theme styles
│   │       ├── index.php        # Main template
│   │       ├── front-page.php   # Homepage template
│   │       ├── header.php       # Header template
│   │       ├── footer.php       # Footer template
│   │       ├── functions.php    # Theme functionality
│   │       ├── single-gov_service.php  # Service template
│   │       ├── js/
│   │       │   ├── multilingual.js     # Polylang integration
│   │       │   └── admin-auto-translate.js
│   │       └── includes/
│   │           ├── content-populator.php
│   │           └── translation-manager.php
│   ├── plugins/
│   │   └── polylang/           # Multilingual support
│   └── languages/              # Translation files
├── wp-config.php               # Database configuration
├── setup_database.sql          # Database setup
└── WORDPRESS_SETUP_GUIDE.md
```

---

## 📚 Key Components

### WordPress CMS Features (v2.1.0)

#### Custom Post Types & REST API
- **Government Services** (`/wp-json/wp/v2/gov_service`)
  - Service icons, URLs, processing times
  - Requirements and featured status
  - Full multilingual support
- **Service Categories** (`/wp-json/wp/v2/service_category`) 
  - Custom icons and color schemes
  - Multilingual category management
- **Government Updates** (`/wp-json/wp/v2/gov_update`)
  - Featured updates and announcements
  - Date-based sorting and archives

#### Enhanced API Endpoints
```
/wp-json/opengovui/v1/featured-services?lang=en  # Featured services
/wp-json/opengovui/v1/categories?lang=si         # Service categories  
/wp-json/opengovui/v1/updates?lang=ta           # Government updates
/wp-json/opengovui/v1/services?lang=en          # All services
```

#### Content Population System
- **One-Click Setup**: Automatically creates sample government content
- **Multilingual Content**: Creates content in English, Sinhala, and Tamil
- **Realistic Data**: Government services, categories, and updates
- **Admin Interface**: Easy-to-use content management dashboard

#### Polylang Integration
- **Advanced Language Management**: Professional multilingual plugin support
- **Meta Field Syncing**: Automatic synchronization of custom fields across languages
- **Language Detection**: Smart language mapping and detection
- **Translation Workflow**: Streamlined content translation process

### i18n Implementation (Static Template)
The template uses a straightforward i18n system:

1. **HTML Markup**: Uses `data-i18n` attributes for translatable content:
```html
<h1 data-i18n="hero.title">Access government services and information in one place</h1>
```

2. **Language Selection**: Simple language switcher in the header:
```html
<div class="language-selector">
    <a href="#" lang="si">සිංහල</a>
    <a href="#" lang="ta">தமிழ்</a>
    <a href="#" lang="en" class="active">English</a>
</div>
```

### Main Sections
- **Header** with Polylang language selector and search
- **Hero section** with featured services from WordPress
- **Topic categories** with dynamic icon navigation
- **Government updates** with content management
- **Footer** with important links and social media

---

## 🔄 Customisation

### WordPress CMS (Recommended)
- **Admin Dashboard**: Full WordPress interface for content management
- **Content Population**: Use the built-in system to create sample content
- **Service Management**: Add/edit services with icons, URLs, and metadata
- **Category Management**: Create categories with custom colors and icons
- **Update Publishing**: Manage government announcements and news
- **Multilingual Content**: Full translation support via Polylang
- **Custom Fields**: Rich metadata for all content types

### Static Template
- Edit the HTML directly to change content
- Update the `data-i18n` attributes and corresponding translation files
- Modify icons by changing FontAwesome classes
- Customize CSS for branding

### Styling
- WordPress version inherits all static template styling
- Edit theme's `style.css` for WordPress-specific customizations
- FontAwesome 6.5.1 included for comprehensive icon support
- Custom color schemes available for categories

---

## 🔌 Plugin Dependencies

### Required for Full Functionality
- **Polylang** (Free): Multilingual support
  - Language management and switching
  - Content translation workflow
  - Meta field synchronization

### Recommended
- **Classic Editor**: For traditional WordPress editing experience
- **Yoast SEO**: Enhanced SEO with multilingual support

---

## 📋 **Version History**

- **v2.1.0** - Enhanced WordPress CMS with Polylang Integration (Current)
  - Full Polylang multilingual plugin support
  - Advanced REST API endpoints
  - Content population system
  - Translation management capabilities
  - Enhanced admin interface
- **v2.0.0** - WordPress CMS Integration
- **v1.2.0** - Complete Static Template with Tamil translations  
- **v1.1.0** - Fira Sans typography update
- **v1.0.0** - Initial static template release

---

## 🚀 **API Documentation**

### REST API Endpoints

#### Custom OpenGovUI Endpoints
```bash
# Get featured services
GET /wp-json/opengovui/v1/featured-services?lang=en

# Get service categories  
GET /wp-json/opengovui/v1/categories?lang=si

# Get government updates
GET /wp-json/opengovui/v1/updates?lang=ta

# Get all services
GET /wp-json/opengovui/v1/services?lang=en&category=health
```

#### Standard WordPress Endpoints
```bash
# Government Services
GET /wp-json/wp/v2/gov_service

# Service Categories
GET /wp-json/wp/v2/service_category

# Government Updates  
GET /wp-json/wp/v2/gov_update
```

All endpoints support language parameters and return properly formatted content with metadata.

---

## 📄 Licence

This project is licensed under the MIT Licence - see the [LICENCE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Feel free to submit pull requests or open issues for any improvements.

## 📞 Support

For support, please open an issue in the [GitHub repository](https://github.com/pasan93/opengovui/issues).

---

Made with ❤️ in 🇱🇰 for better government services
