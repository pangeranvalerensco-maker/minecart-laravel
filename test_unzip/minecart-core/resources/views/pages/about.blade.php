@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<main>
    <div class="container page-content"> <!-- Kontainer untuk konten halaman -->
        <h1 class="page-title" data-translate-key="about-us-title">Tentang Kami</h1>

        <div class="about-layout"> <!-- Layout untuk halaman tentang kami -->
            <div class="about-text-content"> <!-- Konten teks tentang kami -->
                <h2 data-translate-key="about-welcome-title">Selamat Datang di MineCart!</h2>
                <p data-translate-key="about-p1">
                    MineCart lahir dari kecintaan kami terhadap dunia MineCraft dan keinginan untuk menyediakan
                    produk-produk berkualitas bagi para gamer dan penggemar budaya pop. Kami percaya bahwa setiap
                    orang berhak mengekspresikan gayanya, dan kami di sini untuk membantu mewujudkannya.
                </p>
                <h3 data-translate-key="about-mission-title">Misi Kami</h3>
                <p data-translate-key="about-p2">
                    Misi kami adalah menjadi "peti harta karun" utama Anda untuk semua kebutuhan gaya hidup modern.
                    Kami memilih setiap item dengan cermat, memastikan Anda mendapatkan produk terbaik yang unik dan
                    berkarakter. Selamat menelusuri dan "Craft Your Style!"
                </p>
            </div>

            <div class="about-media-content"> <!-- Konten media tentang kami -->
                <figure class="about-image"> <!-- Gambar tentang kami -->
                    <img src="{{ asset('assets/minecart-hq.png') }}" alt="Kantor Pusat MineCart">
                    <figcaption data-translate-key="about-hq-title">MineCart HQ</figcaption>
                </figure>
            </div>
        </div>
        <div class="developer-bio" style="margin-top: 40px; padding: 30px; background: var(--card-bg); border-radius: 12px; border: 1px solid var(--subtle-border-color); box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; flex-wrap: wrap; gap: 20px; align-items: center;">
            <div style="flex-shrink: 0; width: 120px; height: 120px; background-color: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; overflow: hidden;">
                <img src="{{ asset('assets/logo-github.jpg') }}" alt="Pangeran Valerensco" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="flex-grow: 1; min-width: 300px;">
                <h3 style="margin-top: 0; color: var(--heading-color); font-size: 1.5rem;" data-translate-key="dev-name">Dibuat oleh: Pangeran Valerensco Rivaldi Hutabarat</h3>
                <p style="color: var(--primary-color); font-weight: 500; font-size: 0.95rem; margin-bottom: 10px; margin-top: -5px;" data-translate-key="dev-university">Mahasiswa S1 Informatika Universitas Nasional Pasim Bandung</p>
                <p style="color: var(--text-color); font-size: 1.05rem; line-height: 1.6; margin-bottom: 15px;" data-translate-key="dev-bio">
                    Saya adalah seorang mahasiswa jurusan Teknik Informatika yang bersemangat dalam pengembangan web dan rekayasa perangkat lunak. 
                    Proyek <strong>MineCart</strong> ini saya bangun sebagai portofolio untuk menunjukkan kemampuan saya dalam merancang aplikasi e-commerce modern 
                    menggunakan Laravel, dari manajemen database, integrasi sistem pembayaran, hingga desain antarmuka yang dinamis.
                </p>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <a href="https://github.com/pangeranvalerensco-maker" target="_blank" class="btn primary-btn" style="padding: 8px 15px; font-size: 0.9rem;">GitHub</a>
                    <a href="https://www.linkedin.com/in/pangeran-valerensco-rivaldi-hutabarat-b4b01337b/" target="_blank" class="btn secondary-btn" style="padding: 8px 15px; font-size: 0.9rem;">LinkedIn</a>
                    <div style="border-left: 1px solid var(--subtle-border-color); height: 24px; margin: 0 5px;"></div>
                    <a href="https://www.instagram.com/varelrivaldi_hutabarat/" target="_blank" title="Instagram"><img src="{{ asset('assets/logo-instagram.webp') }}" alt="Instagram" style="width: 24px; height: 24px; border-radius: 50%;"></a>
                    <a href="https://www.facebook.com/varel.rival.9" target="_blank" title="Facebook"><img src="{{ asset('assets/logo-facebook.webp') }}" alt="Facebook" style="width: 24px; height: 24px; border-radius: 50%;"></a>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-section"> <!-- Bagian kontak -->
        <div class="container">
            <h2 data-translate-key="contact-title">Hubungi Kami</h2>
            <div class="contact-grid"> <!-- Grid untuk menampilkan informasi kontak -->
                <div class="contact-item">
                    <img src="{{ asset('assets/logo-email.png') }}" alt="Email Icon">
                    <h3 data-translate-key="contact-email-title">Email</h3>
                    <p><a href="mailto:pangeranvalerensco@gmail.com">pangeranvalerensco@gmail.com</a></p>
                </div>
                <div class="contact-item">
                    <img src="{{ asset('assets/logo-telepon.png') }}" alt="Phone Icon">
                    <h3 data-translate-key="contact-phone-title">Telepon / WhatsApp</h3>
                    <p><a href="https://wa.me/6282275065026" target="_blank">+62 822 7506 5026</a></p>
                </div>
                <div class="contact-item">
                    <img src="{{ asset('assets/logo-lokasi.webp') }}" alt="Location Icon">
                    <h3 data-translate-key="contact-location-title">Lokasi</h3>
                    <p><a href="#" data-translate-key="contact-location-detail">Bandung, Jawa Barat</a></p>
                </div>
                <div class="contact-item">
                    <img src="{{ asset('assets/logo-instagram.webp') }}" alt="Instagram Icon">
                    <h3 data-translate-key="contact-instagram-title">Instagram</h3>
                    <p><a href="https://www.instagram.com/varelrivaldi_hutabarat/"
                            target="_blank">varelrivaldi_hutabarat</a></p>
                </div>
                <div class="contact-item">
                    <img src="{{ asset('assets/logo-facebook.webp') }}" alt="Facebook Icon">
                    <h3 data-translate-key="contact-facebook-title">Facebook</h3>
                    <p><a href="https://www.facebook.com/varel.rival.9" target="_blank">Varel Hutabarat</a></p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
