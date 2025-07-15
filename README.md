# OpenGovUI

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-2.0.0-green.svg)
![Static Template](https://img.shields.io/badge/static%20template-v1.2.0-blue.svg)
![WordPress CMS](https://img.shields.io/badge/wordpress%20cms-v2.0.0-green.svg)

<img width="1399" alt="image" src="https://github.com/user-attachments/assets/16597505-da85-4ffd-8ddc-6b598f2afa2b">

A 100% open source modern, accessible, and multilingual website template designed specifically for government portals. Available as both a **static HTML template** and a **full WordPress CMS solution**.

[Live Demo](https://govui.openxs.org)

## 🚀 **Two Deployment Options**

### 📄 **Option 1: Static Template** *(Recommended for simple sites)*
Perfect for straightforward government portals that don't need content management.

- **✅ No server required** - Works with any web hosting
- **✅ Fast loading** - Pure HTML/CSS/JavaScript
- **✅ Easy deployment** - Just upload files
- **✅ No database needed**

### 🎛️ **Option 2: WordPress CMS** *(Recommended for dynamic content)*
Full content management system with admin interface for managing services, categories, and updates.

- **✅ Admin dashboard** - Manage content without coding
- **✅ Custom post types** - Services, Categories, Government Updates
- **✅ REST API** - Integrate with other systems
- **✅ User management** - Multiple admin users

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

### 🌐 Internationalisation (i18n)
- Support for multiple languages (English, Sinhala, Tamil)
- Language switching functionality
- Uses `data-i18n` attributes for easy text replacement

### 🎨 Design Features
- Clean, professional government aesthetic [[memory:3285333]]
- FontAwesome 6.5.1 icons (CDN hosted)
- Service cards with intuitive icons
- Grid-based layouts for services and topics
- Social media integration

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

Full content management system with admin interface.

### Requirements
- PHP 8.4+
- MariaDB/MySQL
- Web server (Apache/Nginx) or PHP built-in server

### Installation
```bash
# Get the WordPress version (v2.0.0)
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
   - Activate "OpenGovUI" theme
   - Start adding government services and content!

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
│   └── themes/
│       └── opengovui/     # Custom government theme
│           ├── style.css
│           ├── index.php
│           └── functions.php
├── wp-config.php          # Database configuration
├── setup_database.sql     # Database setup
└── WORDPRESS_SETUP_GUIDE.md
```

---

## 📚 Key Components

### i18n Implementation
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

### WordPress CMS Features (v2.0.0+)
- **Custom Post Types**: Services, Categories, Government Updates
- **REST API Endpoints**: 
  - `/wp-json/wp/v2/gov_service` - Government services
  - `/wp-json/wp/v2/service_category` - Service categories  
  - `/wp-json/wp/v2/gov_update` - Government updates
- **Admin Interface**: Full WordPress dashboard for content management
- **Custom Meta Fields**: Service icons, URLs, processing times, category colors

### Main Sections
- Header with language selector and search
- Hero section with featured services
- Topic categories with icon navigation
- Government updates section
- Footer with important links and social media

---

## 🔄 Customisation

### Changing Content

**Static Template:**
- Edit the HTML directly to change content
- Update the `data-i18n` attributes and corresponding translation files
- Modify icons by changing FontAwesome classes

**WordPress CMS:**
- Use the WordPress admin dashboard
- Add/edit Services, Categories, and Updates
- Upload images and manage media
- Customize through the theme customizer

### Styling
- Edit `css/styles.css` to match your government's brand colours
- FontAwesome 6.5.1 is included for icons (CDN hosted)
- WordPress version inherits all static template styling

---

## 📋 **Version History**

- **v2.0.0** - WordPress CMS Integration (Current)
- **v1.2.0** - Complete Static Template with Tamil translations  
- **v1.1.0** - Fira Sans typography update
- **v1.0.0** - Initial static template release

---

## 📄 Licence

This project is licensed under the MIT Licence - see the [LICENCE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! Feel free to submit pull requests or open issues for any improvements.

## 📞 Support

For support, please open an issue in the [GitHub repository](https://github.com/pasan93/opengovui/issues).

---

Made with ❤️ in 🇱🇰 for better government services
