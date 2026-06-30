document.addEventListener('DOMContentLoaded', () => {
    // Guard: check if we are on the cart page
    const cartItemsContainer = document.getElementById('cart-items-container');
    if (!cartItemsContainer) return;

    // Helper to format currency to IDR style (e.g. 150.000)
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Handle button clicks
    cartItemsContainer.addEventListener('click', async (e) => {
        const button = e.target.closest('.qty-btn');
        if (!button) return;

        e.preventDefault();

        const productId = button.dataset.productId;
        const stock = parseInt(button.dataset.stock, 10);
        const isPlus = button.classList.contains('qty-plus');

        // Locate elements
        const qtySpan = document.getElementById(`quantity-${productId}`);
        if (!qtySpan) return;

        let currentQty = parseInt(qtySpan.textContent, 10);
        let targetQty = isPlus ? currentQty + 1 : currentQty - 1;

        // Validations before sending request
        if (targetQty < 1) {
            if (typeof showToast === 'function') {
                showToast("Jumlah barang minimal 1.", "warning");
            }
            return;
        }

        if (targetQty > stock) {
            if (typeof showToast === 'function') {
                showToast("Stok maksimum tercapai.", "warning");
            }
            return;
        }

        // Get update URL from parent form
        const form = button.closest('form');
        if (!form) return;
        const url = form.getAttribute('action');

        // Disable both control buttons for this product during AJAX call
        const productButtons = cartItemsContainer.querySelectorAll(`.qty-btn[data-product-id="${productId}"]`);
        productButtons.forEach(btn => btn.disabled = true);

        try {
            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

            const response = await fetch(url, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    quantity: targetQty
                })
            });

            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }

            const data = await response.json();

            if (data) {
                // Update quantity display
                qtySpan.textContent = data.quantity;

                // Update subtotal per item
                const subtotalSpan = document.getElementById(`subtotal-${productId}`);
                if (subtotalSpan) {
                    subtotalSpan.textContent = formatRupiah(data.item_subtotal);
                }

                // Update total items count in sidebar summary
                const totalItemsSpan = document.getElementById('total-items');
                if (totalItemsSpan) {
                    totalItemsSpan.textContent = data.cart_count;
                }

                // Update total items count in checkout button
                const totalItemsBtnSpan = document.getElementById('total-items-btn');
                if (totalItemsBtnSpan) {
                    totalItemsBtnSpan.textContent = data.cart_count;
                }

                // Update total price summaries
                const totalPriceSummarySpan = document.getElementById('total-price-summary');
                if (totalPriceSummarySpan) {
                    totalPriceSummarySpan.textContent = formatRupiah(data.cart_total);
                }

                const totalPriceSpan = document.getElementById('total-price');
                if (totalPriceSpan) {
                    totalPriceSpan.textContent = formatRupiah(data.cart_total);
                }

                // Update header badge
                const cartCounter = document.getElementById('cart-counter');
                if (cartCounter) {
                    cartCounter.textContent = data.cart_count;
                }

                // Update header preview title if present
                const cartPreviewTitle = document.getElementById('cart-preview-title');
                if (cartPreviewTitle) {
                    cartPreviewTitle.textContent = `Keranjang Belanja (${data.cart_count})`;
                }

                // Update hidden inputs for fallback forms
                const hiddenMinus = document.getElementById(`hidden-minus-${productId}`);
                if (hiddenMinus) {
                    hiddenMinus.value = data.quantity - 1;
                }
                const hiddenPlus = document.getElementById(`hidden-plus-${productId}`);
                if (hiddenPlus) {
                    hiddenPlus.value = data.quantity + 1;
                }

                // Update disable states of the current product buttons based on new quantity
                const minusBtn = cartItemsContainer.querySelector(`.qty-minus[data-product-id="${productId}"]`);
                if (minusBtn) {
                    minusBtn.disabled = (data.quantity <= 1);
                }

                const plusBtn = cartItemsContainer.querySelector(`.qty-plus[data-product-id="${productId}"]`);
                if (plusBtn) {
                    plusBtn.disabled = (data.quantity >= data.stock);
                }

                // Show toast notification
                if (typeof showToast === 'function') {
                    showToast(data.message, data.success ? 'success' : 'warning');
                }
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            if (typeof showToast === 'function') {
                showToast("Terjadi kesalahan saat memperbarui keranjang.", "error");
            }
            // Re-enable buttons on error using their previous states
            const minusBtn = cartItemsContainer.querySelector(`.qty-minus[data-product-id="${productId}"]`);
            if (minusBtn) {
                minusBtn.disabled = (currentQty <= 1);
            }
            const plusBtn = cartItemsContainer.querySelector(`.qty-plus[data-product-id="${productId}"]`);
            if (plusBtn) {
                plusBtn.disabled = (currentQty >= stock);
            }
        }
    });
});
