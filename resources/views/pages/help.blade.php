@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')
<main>
    <div class="container page-content"> <!-- Kontainer utama untuk konten halaman Bantuan -->
        <h1 class="page-title" data-translate-key="help-title">Pusat Bantuan</h1>

        <div class="faq-container"> <!-- Kontainer untuk daftar FAQ -->
            <details class="faq-item"> <!-- Setiap item FAQ menggunakan elemen details -->
                <summary class="faq-question" data-translate-key="help-q-features">Apa saja fitur utama di website
                    ini?</summary>
                <div class="faq-answer"> <!-- Jawaban untuk setiap pertanyaan dengan class faq-answer -->
                    <div>
                        <ol>
                            <li data-translate-key="help-a-features-1">Pencarian Produk: Pengguna dapat mencari
                                produk berdasarkan nama, kategori, atau deskripsi.</li>
                            <li data-translate-key="help-a-features-2">Keranjang Belanja Dinamis: Keranjang belanja
                                yang terpisah untuk setiap pengguna, disimpan di Local Storage.</li>
                            <li data-translate-key="help-a-features-3">Checkout & Simulasi Stok: Alur checkout
                                lengkap dengan simulasi pengurangan stok produk.</li>
                            <li data-translate-key="help-a-features-4">Tema Gelap & Terang: Pengguna dapat mengganti
                                tema website untuk kenyamanan visual.</li>
                            <li data-translate-key="help-a-features-5">Multi-Bahasa: Website mendukung dua bahasa
                                (Indonesia & Inggris) yang dapat diganti.</li>
                        </ol>
                    </div>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q-tags">Elemen HTML5 apa saja yang digunakan
                    di proyek ini?</summary>
                <div class="faq-answer">
                    <div>
                        <ol>
                            <li data-translate-key="help-a-tags-1">Struktur Semantik: Penggunaan &lt;header&gt;,
                                &lt;main&gt;, &lt;footer&gt;, &lt;nav&gt;, &lt;section&gt;, dan &lt;article&gt;
                                untuk membangun layout yang bermakna.</li>
                            <li data-translate-key="help-a-tags-2">Multimedia: Implementasi &lt;video&gt; dan
                                &lt;audio&gt; di halaman Bantuan, serta &lt;figure&gt; dan &lt;figcaption&gt; untuk
                                gambar dengan keterangan.</li>
                            <li data-translate-key="help-a-tags-3">Daftar: Penggunaan &lt;ul&gt; untuk daftar tidak
                                berurutan dan &lt;ol&gt; untuk daftar langkah-langkah yang berurutan.</li>
                            <li data-translate-key="help-a-tags-4">Formulir Interaktif: Penggunaan &lt;form&gt;,
                                &lt;input&gt; dengan berbagai tipe, dan &lt;details&gt; &amp; &lt;summary&gt; untuk FAQ
                                accordion.</li>
                        </ol>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q1">Bagaimana cara memesan produk?</summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a1">Anda dapat memesan produk dengan menekan tombol "Tambah ke
                            Keranjang", lalu melanjutkan ke halaman keranjang untuk menyelesaikan proses checkout.
                        </p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q-order-flow">Bagaimana alur pemesanan di
                    MineCart?</summary>
                <div class="faq-answer">
                    <div>
                        <ol>
                            <li data-translate-key="help-a-order-flow-step1">Pilih produk yang Anda inginkan dan
                                klik tombol "Tambah ke Keranjang".</li>
                            <li data-translate-key="help-a-order-flow-step2">Setelah selesai, masuk ke halaman
                                Keranjang Belanja melalui ikon di kanan atas.</li>
                            <li data-translate-key="help-a-order-flow-step3">Periksa kembali item Anda, lalu klik
                                tombol "Checkout".</li>
                            <li data-translate-key="help-a-order-flow-step4">Isi informasi pengiriman dan selesaikan
                                pembayaran.</li>
                        </ol>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q2">Apa saja metode pembayaran yang diterima?
                </summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a2">Saat ini, proyek ini adalah simulasi front-end dan tidak
                            memproses pembayaran sungguhan. Semua fitur checkout hanya untuk tujuan demonstrasi.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q3">Berapa lama waktu pengiriman?</summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a3">Karena ini adalah website simulasi, tidak ada pengiriman
                            fisik yang terjadi. Namun, kami memastikan pengalaman berbelanja virtual Anda secepat
                            mungkin!</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q4">Bagaimana cara mengembalikan produk?
                </summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a4">Proses pengembalian produk saat ini tidak dapat dilakukan
                            karena website ini merupakan simulasi untuk proyek. Namun, kami selalu memastikan data
                            produk yang ditampilkan akurat.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q5">Apakah semua produk ready stock?
                </summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a5">Ya, semua produk yang ditampilkan di website ini dianggap
                            ready stock. Jumlah stok yang tertera pada setiap halaman produk adalah angka simulasi
                            dan akan berkurang setiap kali ada transaksi pembelian.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q6">Bagaimana cara mengubah data akun saya?
                </summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a6">Fitur untuk mengubah data akun seperti password atau alamat
                            akan tersedia di halaman "Akun Saya" yang saat ini sedang dalam pengembangan untuk
                            proyek ini.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q7">Ke mana saja jangkauan pengiriman
                    MineCart?</summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a7">Jangkauan pengiriman kami seluas imajinasi Anda! Sebagai
                            platform simulasi, kami dapat "mengirim" ke lokasi mana pun di dunia virtual. Tidak ada
                            biaya ongkos kirim yang akan dikenakan.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q8">Bagaimana jika saya butuh bantuan lebih
                    lanjut?</summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a8">Jika pertanyaan Anda tidak terjawab di sini, jangan ragu
                            untuk mengunjungi halaman "Tentang Kami" untuk mempelajari lebih lanjut tentang proyek
                            ini atau hubungi kami melalui media sosial yang tertera di bagian atas halaman.</p>
                    </div>
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q9">Mengapa ada fitur tema gelap/terang?
                </summary>
                <div class="faq-answer">
                    <div>
                        <p data-translate-key="help-a9">Kami menyediakan fitur tema gelap dan terang untuk
                            memberikan kenyamanan visual maksimal bagi Anda. Fitur ini dibuat menggunakan CSS
                            Variables dan JavaScript untuk menunjukkan salah satu komponen wajib dalam proyek ini.
                        </p>
                    </div>
                </div>
            </details>
            <details class="faq-item"> 
                <summary class="faq-question" data-translate-key="help-q-video">Apakah ada video perkenalan
                    MineCart?</summary>
                <div class="faq-answer">
                    <div>
                        <video autoplay muted loop class="video-controls"> <!-- Video perkenalan MineCart -->
                            <source src="{{ asset('assets/video-minecart-hq.mp4') }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                    </div>
                </div>
            </details>

            <details class="faq-item">
                <summary class="faq-question" data-translate-key="help-q-audio">Apakah MineCart memiliki jingle?
                </summary>
                <div class="faq-answer">
                    <div>
                        <audio controls class="audio-controls"> <!-- Audio jingle MineCart -->
                            <source src="{{ asset('assets/minecart-sound.m4a') }}" type="audio/mpeg">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                </div>
            </details>
        </div>
    </div>
</main>
@endsection
