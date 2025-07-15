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
                header: {
                    contact: "தொடர்பு கொள்ளுங்கள்",
                    login: "உள்நுழைய",
                    govtName: "நோர்வாலிஸ் அரசு"
                },
                search: {
                    placeholder: "தேடுங்கள்",
                    button: "தேடுங்கள்"
                },
                hero: {
                    title: "அரசு சேவைகள் மற்றும் தகவல்களை ஒரே இடத்தில் அணுகவும்",
                    subtitle: "மிகவும் கேட்கப்படும் சேவைகள்"
                },
                services: {
                    nationalId: {
                        title: "தேசிய அடையாள அட்டை",
                        description: "தேசிய அடையாள அட்டைக்கு விண்ணப்பிக்கவும் அல்லது புதுப்பிக்கவும்"
                    },
                    passport: {
                        title: "கடவுச்சீட்டு",
                        description: "கடவுச்சீட்டுக்கு விண்ணப்பிக்கவும் அல்லது புதுப்பிக்கவும்"
                    },
                    vehicleReg: {
                        title: "வாகன பதிவு",
                        description: "வாகனம் பதிவு செய்யவும் அல்லது உரிமையை மாற்றவும்"
                    },
                    education: {
                        title: "கல்வி",
                        description: "கல்வி சேவைகளை அணுகவும்"
                    }
                },
                categories: {
                    title: "வகைப்படுத்தி பார்வையிடவும்",
                    health: {
                        title: "சுகாதாரம் மற்றும் பராமரிப்பு",
                        description: "சுகாதார சேவைகள், காப்பீடு, முதியோர் பராமரிப்பு"
                    },
                    business: {
                        title: "வணிகம்",
                        description: "பதிவு, உரிமங்கள், வரிகள்"
                    },
                    housing: {
                        title: "வீட்டு வசதி",
                        description: "சொத்து, பயன்பாடுகள், உள்ளூர் சேவைகள்"
                    },
                    immigration: {
                        title: "குடியேற்றம்",
                        description: "விசாக்கள், குடியுரிமை, வேலை அனுமதிகள்"
                    }
                },
                updates: {
                    title: "அரசு புதுப்பிப்புகள்",
                    viewAll: "அனைத்தையும் பார்க்கவும்",
                    readMore: "மேலும் படிக்கவும்"
                },
                footer: {
                    quickLinks: {
                        title: "விரைவு இணைப்புகள்",
                        aboutSL: "நோர்வாலிஸ் பற்றி",
                        gazette: "அரசு வர்த்தமானி",
                        parliament: "நாடாளுமன்றம்",
                        departments: "துறைகள்"
                    },
                    help: {
                        title: "உதவி மற்றும் ஆதரவு",
                        contact: "எங்களை தொடர்பு கொள்ளுங்கள்",
                        faq: "அடிக்கடி கேட்கப்படும் கேள்விகள்",
                        siteMap: "தள வரைபடம்",
                        accessibility: "அணுகல்தன்மை"
                    },
                    legal: {
                        title: "சட்டபூர்வமான",
                        privacy: "தனியுரிமை கொள்கை",
                        terms: "பயன்பாட்டு விதிமுறைகள்",
                        copyright: "பதிப்புரிமை",
                        disclaimer: "மறுப்பு"
                    },
                    copyright: "© 2024 நோர்வாலிஸ் அரசு. அனைத்து உரிமைகளும் பாதுகாக்கப்பட்டவை."
                }
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