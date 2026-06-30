const fs = require('fs');
const path = require('path');

const cssPath = path.join(__dirname, 'public', 'css', 'style.css');
let css = fs.readFileSync(cssPath, 'utf8');

css = css.replace(
    /:root\s*\{[\s\S]*?--font-body:.*?; \n\}/,
    `:root { /* TEMA TERANG (Neo-Brutalism) */
    --body-bg: #dfdede;
    --header-top-bg: #ffffff;
    --header-main-bg: #ffffff;
    --card-bg: #ffffff;
    --section-bg: #e0dede;
    --hero-bg: #FFCC00;

    --heading-color: #000000;
    --text-color: #000000;
    --hero-text-color: #000000;
    --light-text-color: #ffffff;

    --accent-color: #00f2fe; 
    --accent-text-color: #000000;
    --subtle-border-color: #000000; 
    
    --font-heading: 'Outfit', 'Montserrat', sans-serif;
    --font-body: 'Inter', sans-serif;
    --brutal-border: 3px solid #000;
    --brutal-shadow: 4px 4px 0px 0px rgba(0,0,0,1);
}`
);

css = css.replace(
    /body\.dark-mode\s*\{[\s\S]*?--subtle-border-color:.*?; \n\}/,
    `body.dark-mode { /* TEMA GELAP (Neo-Brutalism) */
    --body-bg: #1e1e1e;
    --header-top-bg: #1e1e1e;
    --header-main-bg: #1e1e1e;
    --card-bg: #2a2a2a;
    --section-bg: #2a2a2a;
    --hero-bg: #111111;

    --heading-color: #ffffff;
    --text-color: #f5f5f5;
    --hero-text-color: #ffffff;
    --light-text-color: #ffffff;

    --accent-color: #ff3366; 
    --accent-text-color: #ffffff;
    --subtle-border-color: #ffffff;

    --brutal-border: 3px solid #fff;
    --brutal-shadow: 4px 4px 0px 0px rgba(255,255,255,1);
}`
);

css = css.replace(
    /body\s*\{[\s\S]*?min-height: 100vh; \n\}/,
    `body {
    background-color: var(--body-bg);
    background-image: radial-gradient(var(--subtle-border-color) 1.5px, transparent 1.5px);
    background-size: 20px 20px;
    color: var(--text-color);
    font-family: var(--font-body);
    font-weight: 500;
    line-height: 1.6; 
    transition: background-color 0.3s, color 0.3s;
    display: flex; 
    flex-direction: column; 
    min-height: 100vh; 
}`
);

css += `
/* NEO-BRUTALISM OVERRIDES */
.header-main {
    border-bottom: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    margin-bottom: 8px;
}
.header-top {
    border-bottom: var(--brutal-border) !important;
}
.ecom-search {
    border: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    border-radius: 0 !important;
    transition: transform 0.1s, box-shadow 0.1s !important;
}
.ecom-search:focus-within {
    transform: translate(3px, 3px);
    box-shadow: 1px 1px 0px 0px var(--subtle-border-color) !important;
}
.ecom-search button {
    border-left: var(--brutal-border) !important;
}
.account-dropdown-menu, .select-dropdown {
    border: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    border-radius: 0 !important;
}
.cart-preview {
    border: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    border-radius: 0 !important;
}
.v-divider {
    background: var(--subtle-border-color) !important;
    width: 3px !important;
}
.header-bottom {
    border-bottom: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
}
.ecom-cart .cart-counter {
    border: 2px solid var(--subtle-border-color) !important;
    border-radius: 0 !important;
    box-shadow: 2px 2px 0px 0px var(--subtle-border-color) !important;
    top: -8px;
    right: -12px;
}
.logo span {
    font-weight: 900 !important;
    letter-spacing: -1px;
    text-transform: uppercase;
}
.btn-outline, .buy-btn, .cta-button, .auth-button {
    border: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    border-radius: 0 !important;
    font-weight: 800 !important;
    text-transform: uppercase;
    transition: transform 0.1s, box-shadow 0.1s !important;
}
.btn-outline:active, .buy-btn:active, .cta-button:active, .auth-button:active {
    transform: translate(4px, 4px) !important;
    box-shadow: 0px 0px 0px 0px var(--subtle-border-color) !important;
}
.product-card {
    border: var(--brutal-border) !important;
    box-shadow: var(--brutal-shadow) !important;
    border-radius: 0 !important;
    transition: transform 0.1s, box-shadow 0.1s !important;
}
.product-card:hover {
    transform: translate(-4px, -4px) !important;
    box-shadow: 8px 8px 0px 0px var(--subtle-border-color) !important;
}
.header-main-nav a.active {
    border-bottom: var(--brutal-border) !important;
    font-weight: 800 !important;
}
.header-main-nav a {
    font-weight: 700;
}
`;

fs.writeFileSync(cssPath, css);
console.log("Updated CSS.");
