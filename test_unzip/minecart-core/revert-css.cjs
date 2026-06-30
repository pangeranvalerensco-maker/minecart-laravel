const fs = require('fs');
const path = require('path');

const cssPath = path.join(__dirname, 'public', 'css', 'style.css');
let css = fs.readFileSync(cssPath, 'utf8');

css = css.replace(
    /:root\s*\{[\s\S]*?--font-body:.*?; \n\}/,
    `:root { /* TEMA TERANG ("Overworld") */
    --body-bg: #F5F5F5; /* Warna latar belakang */
    --header-top-bg: #2D3748; /* Warna latar belakang header atas */
    --header-main-bg: #FFFFFF; /* Warna latar belakang header utama */
    --card-bg: #FFFFFF; /* Warna latar belakang kartu produk */
    --section-bg: #e0dede; /* Warna latar belakang section */
    --hero-bg: #1A202C; /* Warna latar belakang hero section */

    --heading-color: #222222; /* Warna teks judul */
    --text-color: #404040; /* Warna teks umum */
    --hero-text-color: #FFFFFF; /* Warna teks hero section */
    --light-text-color: #F5F5F5; /* Warna teks terang untuk kontras di atas latar belakang gelap */

    --accent-color: #3DCEC4;/* Aksen Diamond */
    --accent-text-color: #181A1B;/* Teks di atas aksen */
    --subtle-border-color: #EAEAEA; /* Warna border halus untuk elemen seperti dropdown, tombol, dll. */

    --font-heading: 'Press Start 2P', cursive; /* Font untuk heading */
    --font-body: 'Inter', sans-serif; /* Font untuk teks umum */
}`
);

css = css.replace(
    /body\.dark-mode\s*\{[\s\S]*?--subtle-border-color:.*?; \n\}/,
    `body.dark-mode { /* TEMA GELAP ("Cave/Mining") */
    --body-bg: #181A1B; /* Warna latar belakang untuk mode gelap */
    --header-top-bg: #101112; /* Warna latar belakang header atas */
    --header-main-bg: #242628; /* Warna latar belakang header utama */
    --card-bg: #3A3D41; /* Warna latar belakang kartu produk */
    --section-bg: #242628; /* Warna latar belakang section */
    --hero-bg: #101112; /* Warna latar belakang hero section */

    --heading-color: #FFFFFF; /* Warna teks judul untuk mode gelap */
    --text-color: #D1D5DB; /* Warna teks umum untuk mode gelap */
    --hero-text-color: #FFFFFF; /* Warna teks hero section untuk mode gelap */
    --light-text-color: #ffffff; /* Warna teks terang untuk kontras di atas latar belakang gelap */

    --accent-color: #45E8DA; /* Warna Khas Diamond Minecraft */
    --accent-text-color: #181A1B; /* Counter untuk teks di accent(jika sebagai background), jika kurang kelihatan*/
    --subtle-border-color: #4B5563; /* Warna border halus untuk elemen seperti dropdown, tombol, dll. */
}`
);

css = css.replace(
    /body\s*\{[\s\S]*?min-height: 100vh; \n\}/,
    `body {
    background-color: var(--body-bg);
    color: var(--text-color);
    font-family: var(--font-body);
    line-height: 1.6; 
    transition: background-color 0.3s, color 0.3s; /* Transisi halus saat tema berubah */
    display: flex; 
    flex-direction: column; /* Membuat elemen di dalamnya (header, main, footer) menumpuk ke bawah */
    min-height: 100vh; /* Mengatur tinggi minimal body adalah 100% tinggi layar */
}`
);

// Remove brutalism block at the end
const brutalIdx = css.indexOf('/* NEO-BRUTALISM OVERRIDES */');
if (brutalIdx !== -1) {
    css = css.substring(0, brutalIdx);
}

fs.writeFileSync(cssPath, css);
console.log("Reverted CSS.");
