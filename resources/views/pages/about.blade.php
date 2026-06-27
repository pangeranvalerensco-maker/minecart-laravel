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
        <div class="dev-tribute"> <!-- Penghargaan untuk Penguji -->
            <p data-translate-key="dev-praise-1">DIVDIK BAIK</p>
            <p data-translate-key="dev-praise-2">DIVDIK GANTENG & CANTIK</p>
            <p data-translate-key="dev-praise-3">DIVDIK BAIK HATI</p>
        </div>

        <div class="thank-you-note"> <!-- Catatan terima kasih -->
            <p data-translate-key="thank-you-note-a"> Terima kasih kami ucapkan kepada Divisi Pendidikan yang dengan
                sabar mengajari dan menghadapi kami.</p>
            <p data-translate-key="thank-you-note-b"> Terkhusus juga Kepada Teh Mora Fidela, Instruktur terbaik
                kami.
            </p>
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
                    <h3 data-translate-key="contact-phone-title">Telepon</h3>
                    <p><a href="tel:+6282181296229">+62 821 8129 6229</a></p>
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
