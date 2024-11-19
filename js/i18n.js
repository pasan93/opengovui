// i18n.js
class I18nManager {
    constructor() {
        this.currentLang = localStorage.getItem('preferred-language') || 'en';
        this.observers = new Set();
        
        // Embed translations directly
        this.translations = {
            en: {
                header: {
                    contact: "Contact",
                    login: "Login",
                    govtName: "Government of Norvalis"
                },
                search: {
                    placeholder: "Search",
                    button: "Search"
                },
                hero: {
                    title: "Access government services and information in one place",
                    subtitle: "Most requested services"
                },
                services: {
                    nationalId: {
                        title: "National ID",
                        description: "Apply for or renew your National Identity Card"
                    },
                    passport: {
                        title: "Passport",
                        description: "Apply for or renew your passport"
                    },
                    vehicleReg: {
                        title: "Vehicle Registration",
                        description: "Register or transfer vehicle ownership"
                    },
                    education: {
                        title: "Education",
                        description: "Access educational services"
                    }
                },
                categories: {
                    title: "Browse by category",
                    health: {
                        title: "Health & Care",
                        description: "Healthcare, insurance, elderly care"
                    },
                    business: {
                        title: "Business",
                        description: "Registration, licenses, taxes"
                    },
                    housing: {
                        title: "Housing",
                        description: "Property, utilities, local services"
                    },
                    immigration: {
                        title: "Immigration",
                        description: "Visas, citizenship, work permits"
                    }
                },
                updates: {
                    title: "Government Updates",
                    viewAll: "View all updates",
                    readMore: "Read more"
                },
                footer: {
                    quickLinks: {
                        title: "Quick Links",
                        aboutSL: "About Norvalis",
                        gazette: "Government Gazette",
                        parliament: "Parliament",
                        departments: "Departments"
                    },
                    help: {
                        title: "Help & Support",
                        contact: "Contact Us",
                        faq: "FAQs",
                        siteMap: "Site Map",
                        accessibility: "Accessibility"
                    },
                    legal: {
                        title: "Legal",
                        privacy: "Privacy Policy",
                        terms: "Terms of Use",
                        copyright: "Copyright",
                        disclaimer: "Disclaimer"
                    },
                    copyright: "© 2024 Government of Norvalis. All rights reserved."
                }
            },
            si: {
                header: {
                    contact: "අප අමතන්න",
                    login: "පිවිසෙන්න",
                    govtName: "නෝවාලිස් රජය"
                },
                search: {
                    placeholder: "සොයන්න",
                    button: "සොයන්න"
                },
                hero: {
                    title: "රාජ්‍ය සේවා සහ තොරතුරු එක තැනකින්",
                    subtitle: "ඉතාම ඉල්ලුම් කරන සේවාවන්"
                },
                services: {
                    nationalId: {
                        title: "ජාතික හැඳුනුම්පත",
                        description: "ජාතික හැඳුනුම්පත ලබා ගැනීම හෝ අලුත් කිරීම"
                    },
                    passport: {
                        title: "ගමන් බලපත්‍රය",
                        description: "ගමන් බලපත්‍රය ලබා ගැනීම හෝ අලුත් කිරීම"
                    },
                    vehicleReg: {
                        title: "වාහන ලියාපදිංචිය",
                        description: "වාහන ලියාපදිංචි කිරීම හෝ අයිතිය මාරු කිරීම"
                    },
                    education: {
                        title: "අධ්‍යාපනය",
                        description: "අධ්‍යාපන සේවා වෙත පිවිසෙන්න"
                    }
                },
                categories: {
                    title: "කාණ්ඩ අනුව බලන්න",
                    health: {
                        title: "සෞඛ්‍ය සහ සත්කාර",
                        description: "සෞඛ්‍ය සේවා, රක්ෂණ, වැඩිහිටි සත්කාර"
                    },
                    business: {
                        title: "ව්‍යාපාර",
                        description: "ලියාපදිංචිය, බලපත්‍ර, බදු"
                    },
                    housing: {
                        title: "නිවාස",
                        description: "දේපල, උපයෝගිතා, ප්‍රාදේශීය සේවා"
                    },
                    immigration: {
                        title: "ආගමන විගමන",
                        description: "වීසා, පුරවැසිභාවය, සේවා බලපත්‍ර"
                    }
                },
                updates: {
                    title: "රජයේ යාවත්කාලීන කිරීම්",
                    viewAll: "සියල්ල බලන්න",
                    readMore: "තව කියවන්න"
                },
                footer: {
                    quickLinks: {
                        title: "ඉක්මන් සබැඳි",
                        aboutSL: "නෝවාලිස් ගැන",
                        gazette: "රජයේ ගැසට්",
                        parliament: "පාර්ලිමේන්තුව",
                        departments: "දෙපාර්තමේන්තු"
                    },
                    help: {
                        title: "උදව් සහ සහාය",
                        contact: "අප අමතන්න",
                        faq: "නිති අසන පැන",
                        siteMap: "අඩවි සිතියම",
                        accessibility: "ප්‍රවේශ්‍යතාව"
                    },
                    legal: {
                        title: "නීතිමය",
                        privacy: "පෞද්ගලිකත්ව ප්‍රතිපත්තිය",
                        terms: "භාවිත කොන්දේසි",
                        copyright: "ප්‍රකාශන හිමිකම",
                        disclaimer: "වගකීම් ප්‍රතික්ෂේප කිරීම"
                    },
                    copyright: "© 2024 නෝවාලිස් රජය. සියලු හිමිකම් ඇවිරිණි."
                }
            },
            ta: {
                // Tamil translations would go here
                // Following the same structure as English and Sinhala
            }
        };
    }

    initialize() {
        // Set up language switcher listeners
        document.querySelectorAll('.language-selector a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const lang = e.target.getAttribute('lang');
                this.setLanguage(lang);
            });
        });

        // Initial translation
        this.translate(this.currentLang);
    }

    setLanguage(lang) {
        if (this.translations[lang]) {
            this.currentLang = lang;
            localStorage.setItem('preferred-language', lang);
            this.translate(lang);
            this.notifyObservers();
            this.updateDocumentLanguage(lang);
            this.updateLanguageSelectors(lang);
        }
    }

    getCurrentLanguage() {
        return this.currentLang;
    }

    translate(lang = this.currentLang) {
        document.body.classList.add('language-switching');
        
        const elements = document.querySelectorAll('[data-i18n]');
        elements.forEach(element => {
            const key = element.getAttribute('data-i18n');
            const translation = this.getTranslation(key, lang);
            
            if (translation) {
                if (element.tagName === 'INPUT' && element.getAttribute('placeholder') !== null) {
                    element.placeholder = translation;
                } else {
                    element.textContent = translation;
                }
            }
        });

        setTimeout(() => {
            document.body.classList.remove('language-switching');
        }, 200);
    }

    getTranslation(key, lang = this.currentLang) {
        try {
            return key.split('.').reduce((obj, k) => obj[k], this.translations[lang]) || key;
        } catch (e) {
            console.warn(`Translation missing for key: ${key} in language: ${lang}`);
            return key;
        }
    }

    updateDocumentLanguage(lang) {
        document.documentElement.lang = lang;
        document.documentElement.dir = ['ar', 'he', 'fa', 'ur'].includes(lang) ? 'rtl' : 'ltr';
    }

    updateLanguageSelectors(activeLang) {
        document.querySelectorAll('.language-selector a').forEach(link => {
            if (link.getAttribute('lang') === activeLang) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    subscribe(callback) {
        this.observers.add(callback);
    }

    unsubscribe(callback) {
        this.observers.delete(callback);
    }

    notifyObservers() {
        this.observers.forEach(callback => callback(this.currentLang));
    }
}

// Create and export a global instance
window.i18n = new I18nManager();