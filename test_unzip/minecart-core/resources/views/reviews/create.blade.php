@extends('layouts.app')

@section('title', 'Beri Ulasan')

@section('content')
<main>
    <div class="container page-title" style="margin-top: 2rem;">
        <h1 data-translate-key="review-page-title">Beri Ulasan Produk</h1>
    </div>

    <section style="padding-bottom: 3rem;">
        <div class="container" style="max-width: 600px; margin: 0 auto;">
            <div style="background-color: var(--card-bg); border: 1px solid var(--subtle-border-color); border-radius: 8px; padding: 20px;">
                <div style="display: flex; gap: 15px; margin-bottom: 20px; border-bottom: 1px solid var(--subtle-border-color); padding-bottom: 15px;">
                    <img src="{{ $orderItem->product->image_url }}" alt="product" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid var(--subtle-border-color);">
                    <div>
                        <h2 style="font-size: 1.2rem; margin: 0 0 5px 0;">{{ $orderItem->product_name }}</h2>
                        <div style="font-size: 0.9rem; color: #666;"><span data-translate-key="review-order-label">Pesanan: #</span>{{ str_pad($orderItem->order_id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>

                <form action="{{ route('reviews.store', $orderItem) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 500; margin-bottom: 10px;" data-translate-key="review-rating-label">Penilaian Anda (Bintang)</label>
                        <div class="star-rating" style="display: flex; gap: 5px; font-size: 2rem; color: #ccc; cursor: pointer;">
                            <span data-value="1">★</span>
                            <span data-value="2">★</span>
                            <span data-value="3">★</span>
                            <span data-value="4">★</span>
                            <span data-value="5">★</span>
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}" required>
                        @error('rating') <div style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="comment" style="display: block; font-weight: 500; margin-bottom: 8px;" data-translate-key="review-comment-label">Komentar (Opsional)</label>
                        <textarea name="comment" id="comment" rows="4" style="width: 100%; padding: 10px; border: 1px solid var(--subtle-border-color); border-radius: 4px; font-family: inherit; resize: vertical;" placeholder="Bagaimana kualitas produk ini?" data-translate-key="review-comment-placeholder">{{ old('comment') }}</textarea>
                        @error('comment') <div style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="image" style="display: block; font-weight: 500; margin-bottom: 8px;" data-translate-key="review-photo-label">Foto Produk (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid var(--subtle-border-color); border-radius: 4px;">
                        @error('image') <div style="color: red; font-size: 0.8rem; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('account.orders') }}" class="primary-btn" style="background: var(--subtle-border-color); color: var(--text-color); border: none; text-decoration: none; padding: 10px 15px; text-align: center;" data-translate-key="review-cancel-btn">Batal</a>
                        <button type="submit" class="primary-btn" style="flex: 1;" data-translate-key="review-submit-btn">Kirim Ulasan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating span');
        const ratingInput = document.getElementById('rating-input');
        
        function updateStars(value) {
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= value) {
                    star.style.color = '#f4a261'; // Active color
                } else {
                    star.style.color = '#ccc'; // Inactive color
                }
            });
        }
        
        // Initial setup
        updateStars(ratingInput.value);
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                updateStars(value);
            });
            
            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                updateStars(value);
            });
        });
        
        document.querySelector('.star-rating').addEventListener('mouseout', function() {
            updateStars(ratingInput.value);
        });
    });
</script>
@endsection
