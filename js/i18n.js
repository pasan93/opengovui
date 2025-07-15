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
                    services: {
                        title: "Services",
                        benefits: "Benefits",
                        births: "Births, deaths, marriages",
                        business: "Business and self-employed",
                        childcare: "Childcare and parenting",
                        citizenship: "Citizenship and living abroad",
                        crime: "Crime, justice and the law"
                    },
                    government: {
                        title: "Government activity",
                        departments: "Departments",
                        news: "News",
                        guidance: "Guidance and regulation",
                        research: "Research and statistics",
                        consultations: "Policy papers and consultations",
                        transparency: "Transparency"
                    },
                    support: {
                        title: "Support links",
                        help: "Help",
                        privacy: "Privacy",
                        cookies: "Cookies",
                        accessibility: "Accessibility statement",
                        contact: "Contact",
                        terms: "Terms and conditions"
                    },
                    meta: {
                        crown: "Crown copyright",
                        govtName: "Government of Norvalis",
                        license: "All content is available under the",
                        licenseLink: "Open Government Licence v3.0",
                        followUs: "Follow us:"
                    },
                    social: {
                        facebook: "Follow us on Facebook",
                        twitter: "Follow us on Twitter",
                        linkedin: "Follow us on LinkedIn",
                        youtube: "Follow us on YouTube"
                    }
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
                    services: {
                        title: "සේවා",
                        benefits: "ප්‍රතිලාභ",
                        births: "උපත්, මරණ, විවාහ",
                        business: "ව්‍යාපාර සහ ස්වයං-රැකියාව",
                        childcare: "ළමා රැකවරණය සහ පෙර දරුවන්",
                        citizenship: "පුරවැසිභාවය සහ විදේශ ජීවත්වීම",
                        crime: "අපරාධ, යුක්තිය සහ නීතිය"
                    },
                    government: {
                        title: "රාජ්‍ය ක්‍රියාකාරකම්",
                        departments: "දෙපාර්තමේන්තු",
                        news: "ප්‍රවෘත්ති",
                        guidance: "මාර්ගෝපදේශ සහ නියාමනය",
                        research: "පර්යේෂණ සහ සංඛ්‍යාලේඛන",
                        consultations: "ප්‍රතිපත්ති පත්‍ර සහ උපදේශන",
                        transparency: "විනිවිද දැකීම"
                    },
                    support: {
                        title: "සහාය සබැඳි",
                        help: "උදව්",
                        privacy: "පෞද්ගලිකත්වය",
                        cookies: "කුකීස්",
                        accessibility: "ප්‍රවේශ්‍යතා ප්‍රකාශනය",
                        contact: "අමතන්න",
                        terms: "නියම සහ කොන්දේසි"
                    },
                    meta: {
                        crown: "ක්‍රම ප්‍රකාශන හිමිකම",
                        govtName: "නෝවාලිස් රජය",
                        license: "සියලු අන්තර්ගතයන් ලබා ගත හැක්කේ",
                        licenseLink: "විවෘත රාජ්‍ය බලපත්‍රය v3.0",
                        followUs: "අපව අනුගමනය කරන්න:"
                    },
                    social: {
                        facebook: "ෆේස්බුක් හි අපව අනුගමනය කරන්න",
                        twitter: "ට්විටර් හි අපව අනුගමනය කරන්න",
                        linkedin: "ලින්ක්ඩ්ඉන් හි අපව අනුගමනය කරන්න",
                        youtube: "යූ ටියුබ් හි අපව අනුගමනය කරන්න"
                    }
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
                    services: {
                        title: "சேவைகள்",
                        benefits: "நன்மைகள்",
                        births: "பிறப்பு, இறப்பு, திருமணம்",
                        business: "வணிகம் மற்றும் சுயதொழில்",
                        childcare: "குழந்தை பராமரிப்பு மற்றும் பெற்றோர்மை",
                        citizenship: "குடியுரிமை மற்றும் வெளிநாட்டில் வாழ்தல்",
                        crime: "குற்றம், நீதி மற்றும் சட்டம்"
                    },
                    government: {
                        title: "அரசு செயல்பாடு",
                        departments: "துறைகள்",
                        news: "செய்திகள்",
                        guidance: "வழிகாட்டுதல் மற்றும் ஒழுங்குமுறை",
                        research: "ஆராய்ச்சி மற்றும் புள்ளிவிவரங்கள்",
                        consultations: "கொள்கை ஆவணங்கள் மற்றும் ஆலோசனைகள்",
                        transparency: "வெளிப்படைத்தன்மை"
                    },
                    support: {
                        title: "ஆதரவு இணைப்புகள்",
                        help: "உதவி",
                        privacy: "தனியுரிமை",
                        cookies: "குக்கீகள்",
                        accessibility: "அணுகல்தன்மை அறிக்கை",
                        contact: "தொடர்பு",
                        terms: "விதிமுறைகள் மற்றும் நிபந்தனைகள்"
                    },
                    meta: {
                        crown: "கிரீடம் பதிப்புரிமை",
                        govtName: "நோர்வாலிஸ் அரசு",
                        license: "அனைத்து உள்ளடக்கமும் கிடைக்கும்",
                        licenseLink: "திறந்த அரசு உரிமம் v3.0",
                        followUs: "எங்களைப் பின்தொடரவும்:"
                    },
                    social: {
                        facebook: "Facebook இல் எங்களைப் பின்தொடரவும்",
                        twitter: "Twitter இல் எங்களைப் பின்தொடரவும்",
                        linkedin: "LinkedIn இல் எங்களைப் பின்தொடரவும்",
                        youtube: "YouTube இல் எங்களைப் பின்தொடரவும்"
                    }
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