# OpenGovUI

![Licence](https://img.shields.io/badge/licence-MIT-blue.svg)
![Version](https://img.shields.io/badge/version-1.0.0-green.svg)

<img width="1399" alt="image" src="https://github.com/user-attachments/assets/16597505-da85-4ffd-8ddc-6b598f2afa2b">



A 100% open source modern, accessible, and multilingual website template designed specifically for government portals. Built with pure HTML, CSS, and JavaScript, this template provides a solid foundation for governments to quickly deploy citizen-centric service portals.

[Live Demo](https://pasan93.github.io/opengovui/)

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
- Support for multiple languages (currently implemented with English and Sinhala)
- Tamil language support coming soon to demonstrate multi-script capabilities
- Language switching functionality
- Uses `data-i18n` attributes for easy text replacement

### 🎨 Design Features
- Clean, professional government aesthetic
- FontAwesome 6.5.1 icons
- Service cards with intuitive icons
- Grid-based layouts for services and topics
- Social media integration

## 🚀 Quick Start

This is a static HTML template that requires no build process or dependencies. To use it:

1. Clone the repository:
```bash
git clone https://github.com/pasan93/opengovui.git
```

2. Open `index.html` in your browser

That's it! No build process or installation required.

## 🔧 Structure

```
opengovui/
├── index.html
├── css/
│   └── styles.css
├── js/
│   ├── i18n.js
│   └── script.js
└── images/
    └── sl-govt-logo.png
```

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

### Main Sections
- Header with language selector and search
- Hero section with featured services
- Topic categories with icon navigation
- Government updates section
- Footer with important links and social media

## 🔄 Customisation

### Changing Content
- Edit the HTML directly to change the content
- Update the `data-i18n` attributes and corresponding translation files for multilingual support
- Modify icons by changing FontAwesome classes

### Styling
- Edit `styles.css` to match your government's brand colours and styling preferences
- FontAwesome 6.5.1 is included for icons

## 📄 Licence

This project is licensed under the MIT Licence - see the [LICENCE](LICENCE) file for details.

## 🤝 Contributing

Contributions are welcome! Feel free to submit pull requests or open issues for any improvements.

## 📞 Support

For support, please open an issue in the [GitHub repository](https://github.com/pasan93/opengovui/issues).

---

Made with ❤️ for better government services
