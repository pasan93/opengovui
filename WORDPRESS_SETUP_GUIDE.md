# OpenGovUI WordPress Setup Guide

## 🚀 Quick Start

Your government portal is now ready to run with WordPress! Here's how to complete the setup:

## 📋 Prerequisites Completed ✅

- ✅ PHP 8.4.10 installed
- ✅ MariaDB installed and running  
- ✅ WordPress downloaded and configured
- ✅ Custom theme created with government portal design
- ✅ Custom post types for Services, Categories, and Updates
- ✅ REST API configured

## 🗄️ Database Setup

1. **Create the database** (run this command):
   ```bash
   mariadb -u root < setup_database.sql
   ```

2. **Alternative manual setup**:
   ```bash
   mariadb -u root
   CREATE DATABASE opengovui_wp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   exit
   ```

## 🌐 WordPress Installation

1. **Your WordPress is running at**: http://localhost:8080

2. **Complete WordPress setup**:
   - Open http://localhost:8080 in your browser
   - Follow the WordPress installation wizard
   - Use these database settings:
     - **Database Name**: `opengovui_wp`
     - **Username**: `root`
     - **Password**: (leave empty)
     - **Database Host**: `localhost`

3. **Create admin account** when prompted

## 🎨 Activate Custom Theme

1. **Go to WordPress Admin**: http://localhost:8080/wp-admin

2. **Navigate to**: Appearance > Themes

3. **Activate**: "OpenGovUI" theme

## 📝 Content Management

### Adding Government Services

1. **Go to**: Services > Add New
2. **Fill in**:
   - Title (e.g., "National ID Card")
   - Description
   - Service Icon (e.g., "fas fa-id-card")
   - Service URL
   - Requirements
   - Processing Time

### Adding Service Categories  

1. **Go to**: Categories > Add New
2. **Fill in**:
   - Title (e.g., "Health & Care")
   - Description
   - Category Icon (e.g., "fas fa-heart")
   - Category Color (color picker)

### Adding Government Updates

1. **Go to**: Updates > Add New  
2. **Fill in**:
   - Title
   - Content
   - Featured Image (optional)
   - Excerpt

## 🔌 API Endpoints

Your content is automatically available via REST API:

- **Services**: `http://localhost:8080/wp-json/wp/v2/gov_service`
- **Categories**: `http://localhost:8080/wp-json/wp/v2/service_category`
- **Updates**: `http://localhost:8080/wp-json/wp/v2/gov_update`

### Example API Response:
```json
{
  "id": 1,
  "title": {"rendered": "National ID Card"},
  "excerpt": {"rendered": "Apply for or renew your National Identity Card"},
  "service_icon": "fas fa-id-card",
  "service_url": "https://example.com/id-card",
  "service_requirements": "Birth certificate, proof of address",
  "service_processing_time": "2-3 weeks"
}
```

## 🌍 Multilingual Support

The theme includes:
- ✅ **English** support
- ✅ **Sinhala** (සිංහල) translations  
- ✅ **Tamil** (தமிழ்) translations

Language switching works with the existing i18n.js system.

## 🔄 Frontend Integration

### Option 1: WordPress Templates (Current)
- Content is dynamically loaded from WordPress
- Uses the custom theme templates
- Content managed through WordPress admin

### Option 2: Static Site + API (Advanced)
- Keep your original static site at `../opengovui/`
- Use the WordPress as a headless CMS
- Fetch content via REST API using `wp-api-integration.js`

### Example API Integration:
```javascript
// Fetch and display services
const services = await fetch('http://localhost:8080/wp-json/wp/v2/gov_service');
const servicesData = await services.json();

// Update your static site with dynamic content
servicesData.forEach(service => {
    // Update service cards with real data
});
```

## 📁 File Structure

```
opengovui-cms/
├── wp-content/
│   └── themes/
│       └── opengovui/           # Custom government theme
│           ├── style.css        # Theme info & main styles
│           ├── index.php        # Main template
│           ├── functions.php    # Custom post types & API
│           ├── css/            # Copied from original project
│           ├── js/             # Scripts + API integration
│           └── images/         # Government logos & assets
├── wp-config.php               # WordPress configuration
├── setup_database.sql          # Database setup script
└── WORDPRESS_SETUP_GUIDE.md   # This guide
```

## 🛠️ Management Workflow

### For Content Editors:
1. Login to WordPress admin
2. Add/edit Services, Categories, Updates
3. Changes appear instantly on frontend

### For Developers:
1. Edit theme files in `wp-content/themes/opengovui/`
2. Customize API endpoints in `functions.php`
3. Modify frontend in `index.php` or integrate with static site

## 🎯 Next Steps

1. **Complete WordPress installation** (5 minutes)
2. **Activate OpenGovUI theme**
3. **Add sample content** (services, categories, updates)
4. **Test the API endpoints**
5. **Customize as needed**

## 🆘 Troubleshooting

**Database connection issues?**
- Check MariaDB is running: `brew services start mariadb`
- Verify database exists: `mariadb -u root -e "SHOW DATABASES;"`

**Theme not appearing?**
- Check file permissions in `wp-content/themes/opengovui/`
- Ensure `style.css` has proper theme header

**API not working?**
- Go to Settings > Permalinks in WordPress admin
- Click "Save Changes" to refresh rewrite rules

## 📞 Support

- **WordPress Docs**: https://wordpress.org/support/
- **Government Portal Features**: Check the theme's `functions.php`
- **API Documentation**: Visit `/wp-json/` on your site

---

**🎉 Congratulations!** You now have a powerful, manageable government portal with WordPress backend and beautiful frontend! 