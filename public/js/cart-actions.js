document.addEventListener('DOMContentLoaded', () => {
    // Select all add-to-cart forms
    const forms = document.querySelectorAll('.js-add-to-cart-form');
    if (forms.length === 0) return;

    forms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            if (!button || button.disabled) return;

            const url = form.getAttribute('action');
            const originalText = button.textContent;

            // Get CSRF Token
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            // Disable button during in-flight request
            button.disabled = true;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (response.status === 400) {
                    const errorData = await response.json();
                    if (typeof showToast === 'function') {
                        showToast(errorData.message || 'Stok tidak cukup.', 'error');
                    }
                    button.disabled = false;
                    return;
                }

                if (response.status === 401) {
                    window.location.href = '/login';
                    return;
                }

                if (!response.ok) {
                    throw new Error('HTTP error ' + response.status);
                }

                const data = await response.json();

                if (data) {
                    // Update header badge count
                    const cartCounter = document.getElementById('cart-counter');
                    if (cartCounter) {
                        cartCounter.textContent = data.cart_count;
                        cartCounter.classList.add('visible');
                    }

                    // Update preview dropdown title if present
                    const cartPreviewTitle = document.getElementById('cart-preview-title');
                    if (cartPreviewTitle) {
                        cartPreviewTitle.textContent = `Keranjang Belanja (${data.cart_count})`;
                    }

                    // Show appropriate toast
                    if (typeof showToast === 'function') {
                        showToast(data.message, data.success ? 'success' : 'warning');
                    }

                    // Micro-interaction: Change button text to "Ditambahkan"
                    button.textContent = 'Ditambahkan';
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                    }, 1000);
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                if (typeof showToast === 'function') {
                    showToast('Terjadi kesalahan saat menambahkan ke keranjang.', 'error');
                }
                button.disabled = false;
            }
        });
    });
});
