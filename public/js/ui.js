// =================================================================================
// == MineCart UI Script (Sprint 1)
// =================================================================================

const translations = {
    id: {
        'page-title-home': 'MineCart - Beranda',
        'hero-title': 'Koleksi Terbaru Musim Ini',
        'hero-subtitle': 'Temukan gaya terbaik Anda dengan produk pilihan berkualitas tinggi.',
        'hero-cta': 'Lihat Semua Produk',
        'featured-title': 'Produk Rekomendasi',
        'recommended-title': 'Rekomendasi',
        'see-more-btn': 'Lihat Lainnya',
        'buy-button': 'Tambah ke Keranjang',
        'follow-us-title': 'Ikuti Kami di',
        'about-us-title': 'Tentang Kami',
        'help-title': 'Bantuan',
        'login': 'Masuk',
        'register': 'Daftar',
        'search-title': 'Cari di MineCart...',
        'cart-title': 'Keranjang Belanja',
        'home-title': 'Beranda',
        'all-products-title': 'Semua Produk',
        'cart-link-title': 'Lihat Keranjang Belanja',
        'theme-toggle-title': 'Ubah Tema',
        'loading-product': 'Memuat...',
        'loading-description': 'Deskripsi produk sedang dimuat...',
        'my-account': 'Akun Saya',
        'logout': 'Keluar',
        'select-lang': 'Ganti Bahasa',
        'search-btn': 'Cari',
        'cs-title': 'Customer Service',
        'cs-welcome': 'Selamat datang di MineCart Web! Temukan berbagai produk berkualitas tinggi dengan harga terbaik.',
        'footer-title': '© 2025 MineCart. Dibuat oleh Pangeran Valerensco Rivaldi Hutabarat. Semua hak cipta dilindungi.'
    },
    en: {
        'page-title-home': 'MineCart - Homepage',
        'hero-title': 'This Season\'s Newest Collection',
        'hero-subtitle': 'Find your best style with high-quality selected products.',
        'hero-cta': 'Shop All Products',
        'featured-title': 'Recommended Products',
        'recommended-title': 'Recommended',
        'see-more-btn': 'See More',
        'buy-button': 'Add to Cart',
        'follow-us-title': 'Follow Us On',
        'about-us-title': 'About Us',
        'help-title': 'Help',
        'login': 'Login',
        'register': 'Register',
        'search-title': 'Search in MineCart...',
        'cart-title': 'Shopping Cart',
        'home-title': 'Home Page',
        'all-products-title': 'All Products',
        'cart-link-title': 'View Shopping Cart',
        'theme-toggle-title': 'Change Theme',
        'loading-product': 'Loading...',
        'loading-description': 'Product description is loading...',
        'my-account': 'My Account',
        'logout': 'Logout',
        'select-lang': 'Change Language',
        'search-btn': 'Search',
        'cs-title': 'Welcome!!',
        'cs-welcome': 'Welcome to MineCart Web! Discover a wide range of high-quality products at the best prices.',
        'footer-title': '© 2025 MineCart. Created by Pangeran Valerensco Rivaldi Hutabarat. All rights reserved.'
    }
};

let currentLang = localStorage.getItem('userLanguage') || 'id';

// --- FUNGSI TEMA ---
function applyTheme(theme) {
    const body = document.body;
    const themeIcon = document.getElementById('theme-icon');
    const cartIcon = document.getElementById('cart-icon-img');
    const sunIconPath = window.minecartAssets?.logoTerang || '/assets/logo-terang.png';
    const moonIconPath = window.minecartAssets?.logoGelap || '/assets/logo-gelap.png';
    const cartLightPath = window.minecartAssets?.cartGelap || '/assets/logo-keranjang-gelap.png';
    const cartDarkPath = window.minecartAssets?.cartTerang || '/assets/logo-keranjang-terang.png';

    if (theme === 'dark') {
        body.classList.add('dark-mode');
        if (themeIcon) themeIcon.src = sunIconPath;
        if (cartIcon) cartIcon.src = cartDarkPath;
    } else {
        body.classList.remove('dark-mode');
        if (cartIcon) cartIcon.src = cartLightPath;
        if (themeIcon) themeIcon.src = moonIconPath;
    }
}

function initializeThemeToggle() {
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    if (!themeToggleBtn) return;
    
    themeToggleBtn.addEventListener('click', () => {
        const currentTheme = localStorage.getItem('theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    });
}

// --- FUNGSI CAROUSEL ---
function initializeCarousel() {
    const carouselContainer = document.querySelector('.carousel-container');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const heroSection = document.querySelector('.hero');
    if (!carouselContainer || !prevBtn || !nextBtn || !heroSection) return;

    const slides = document.querySelectorAll('.carousel-slide');
    const slideCount = slides.length;
    let currentIndex = 0;
    let slideInterval;

    function goToSlide(index) {
        carouselContainer.classList.remove('slide-1', 'slide-2', 'slide-3');
        carouselContainer.classList.add(`slide-${index + 1}`);
        currentIndex = index;
    }

    function nextSlide() {
        let nextIndex = (currentIndex + 1) % slideCount;
        goToSlide(nextIndex);
    }
    function prevSlide() {
        let prevIndex = (currentIndex - 1 + slideCount) % slideCount;
        goToSlide(prevIndex);
    }
    function startSlideShow() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }
    function stopSlideShow() {
        clearInterval(slideInterval);
    }
    
    nextBtn.addEventListener('click', () => {
        nextSlide();
        startSlideShow();
    });
    prevBtn.addEventListener('click', () => {
        prevSlide();
        startSlideShow();
    });

    heroSection.addEventListener('mouseenter', stopSlideShow);
    heroSection.addEventListener('mouseleave', startSlideShow);

    goToSlide(0);
    startSlideShow();
}

// --- FUNGSI HAMBURGER ---
function initializeHamburgerMenu() {
    const hamburgerBtn = document.querySelector('.hamburger-btn');
    const mainNav = document.querySelector('.header-main-nav');
    if (hamburgerBtn && mainNav) {
        hamburgerBtn.addEventListener('click', () => {
            mainNav.classList.toggle('is-active');
        });
    }
}

// --- FUNGSI BAHASA ---
function translateUI(lang) {
    document.querySelectorAll('[data-translate-key]').forEach(element => {
        const key = element.getAttribute('data-translate-key');
        if (translations[lang] && translations[lang][key]) {
            const translatedText = translations[lang][key];
            if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
                element.placeholder = translatedText;
            } else if (element.hasAttribute('title')) {
                element.title = translatedText;
            } else {
                element.textContent = translatedText;
            }
        }
    });

    const selectedLangText = document.getElementById('selected-lang-text');
    if (selectedLangText) {
        selectedLangText.textContent = lang === 'en' ? 'English' : 'Bahasa Indonesia';
    }

    const mobileLangLink = document.querySelector('#mobile-lang-switcher a');
    if (mobileLangLink) {
        mobileLangLink.textContent = lang === 'en' ? 'Bahasa Indonesia' : 'English';
    }

    // Terjemahan nama dan deskripsi produk di semua kartu produk dinamis
    document.querySelectorAll('.product-card').forEach(card => {
        const titleEl = card.querySelector('[data-title-id]');
        const descEl = card.querySelector('[data-description-id]');

        if (titleEl && titleEl.dataset.titleId && titleEl.dataset.titleEn) {
            titleEl.textContent = lang === 'id' ? titleEl.dataset.titleId : titleEl.dataset.titleEn;
        }
        if (descEl && descEl.dataset.descriptionId && descEl.dataset.descriptionEn) {
            descEl.textContent = lang === 'id' ? descEl.dataset.descriptionId : descEl.dataset.descriptionEn;
        }
    });

    document.title = translations[lang]['page-title-home'] || 'MineCart';
}

function initializeLanguageDropdown() {
    const customSelect = document.querySelector('.custom-select');
    if (!customSelect) return;

    const selectButton = customSelect.querySelector('.select-button');
    const dropdown = customSelect.querySelector('.select-dropdown');

    selectButton.addEventListener('click', () => {
        dropdown.classList.toggle('show');
        const isExpanded = dropdown.classList.contains('show');
        selectButton.setAttribute('aria-expanded', isExpanded);
    });

    dropdown.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            const selectedValue = e.target.dataset.value;
            currentLang = selectedValue;
            localStorage.setItem('userLanguage', currentLang);
            translateUI(currentLang);
            dropdown.classList.remove('show');
            selectButton.setAttribute('aria-expanded', 'false');
        }
    });

    window.addEventListener('click', (e) => {
        if (!customSelect.contains(e.target)) {
            dropdown.classList.remove('show');
            selectButton.setAttribute('aria-expanded', 'false');
        }
    });

    const mobileLangSwitcher = document.getElementById('mobile-lang-switcher');
    if (mobileLangSwitcher) {
        mobileLangSwitcher.addEventListener('click', (e) => {
            e.preventDefault();
            currentLang = currentLang === 'en' ? 'id' : 'en';
            localStorage.setItem('userLanguage', currentLang);
            translateUI(currentLang);
        });
    }
}

// --- FUNGSI CUSTOMER SERVICE POPUP ---
function initializeCSPopup() {
    const popup = document.getElementById('cs-popup');
    if (!popup) return;

    const hasBeenClosed = localStorage.getItem('cs_popup_closed') === 'true';

    if (!hasBeenClosed) {
        popup.classList.remove('hidden-element');
        setTimeout(() => {
            popup.classList.add('is-active');
        }, 2000);
    }

    const closeBtn = popup.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            popup.classList.remove('is-active');
            localStorage.setItem('cs_popup_closed', 'true');
        });
    }
}

// --- FUNGSI TOAST ---
function showToast(messageKey, type = 'success', data = {}) {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    let message = translations[currentLang][messageKey] || messageKey;

    for (const key in data) {
        if (data.hasOwnProperty(key)) {
            const placeholder = new RegExp(`{{${key}}}`, 'g');
            message = message.replace(placeholder, data[key]);
        }
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// --- INITIALIZATION ---
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);
    translateUI(currentLang);

    initializeCarousel();
    initializeHamburgerMenu();
    initializeThemeToggle();
    initializeLanguageDropdown();
    initializeCSPopup();
});
