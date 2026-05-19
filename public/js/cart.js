

document.addEventListener('DOMContentLoaded', function () {

    const API_CART = '/Web_Tech_Project/public/api/cart_api.php';

    const addBtn = document.getElementById('addToCartBtn');
    if (addBtn) {
        addBtn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const stock = parseInt(this.dataset.stock);
            const qtyInput = document.getElementById('quantity');
            const qty = parseInt(qtyInput.value);
            const msgEl = document.getElementById('cartMessage');

            if (isNaN(qty) || qty < 1) {
                showMsg(msgEl, 'Please enter a valid quantity.', 'error');
                return;
            }
            if (qty > stock) {
                showMsg(msgEl, 'Not enough stock available.', 'error');
                return;
            }

            const data = new FormData();
            data.append('action', 'add');
            data.append('product_id', productId);
            data.append('quantity', qty);

            fetch(API_CART, { method: 'POST', body: data })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {
                        showMsg(msgEl, 'Added to cart!', 'success');
                        updateBadge(res.cart_count);
                    } else {
                        showMsg(msgEl, res.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.error('Cart error:', err);
                    showMsg(msgEl, 'Something went wrong.', 'error');
                });
        });
    }

    document.querySelectorAll('.qty-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const cartId = this.dataset.cartId;
            const action = this.dataset.action;
            const stock = parseInt(this.dataset.stock || 9999);
            const qtySpan = document.getElementById('qty-' + cartId);
            let qty = parseInt(qtySpan.textContent);

            if (action === 'increase') qty++;
            if (action === 'decrease') qty--;

            if (qty < 1) return;
            if (qty > stock) { alert('Cannot exceed available stock.'); return; }

            const data = new FormData();
            data.append('action', 'update');
            data.append('cart_id', cartId);
            data.append('quantity', qty);

            fetch(API_CART, { method: 'POST', body: data })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {
                        qtySpan.textContent = qty;
                        recalcSubtotal(cartId, qty);
                        recalcTotal();
                        updateBadge(res.cart_count);
                    }
                })
                .catch(function (err) { console.error('Update error:', err); });
        });
    });


    document.querySelectorAll('.remove-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const cartId = this.dataset.cartId;

            const data = new FormData();
            data.append('action', 'remove');
            data.append('cart_id', cartId);

            fetch(API_CART, { method: 'POST', body: data })
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (res.success) {

                        const row = document.getElementById('cart-row-' + cartId);
                        if (row) row.remove();

                        recalcTotal();
                        updateBadge(res.cart_count);

                        const remainingRows = document.querySelectorAll('#cartBody tr');
                        if (remainingRows.length === 0) {
                            document.querySelector('.cart-table').remove();

                            document.querySelector('.cart-summary').remove();

                            document.querySelector('.cart-container').innerHTML += `
                <div class="cart-empty">
                    <p>Your cart is empty.</p>
                    <a href="home.php" class="btn-primary">Continue Shopping</a>
                </div>
            `;
                        }
                    }
                })
                .catch(function (err) { console.error('Remove error:', err); });
        });
    });

    function updateBadge(count) {

    const badges = document.querySelectorAll('#cartBadge');

    badges.forEach(function (b) {
        b.textContent = count;
    });

    localStorage.setItem('cartCount', count);
}

    function recalcSubtotal(cartId, qty) {
        const subtotalEl = document.getElementById('subtotal-' + cartId);
        if (!subtotalEl) return;
        const price = parseFloat(subtotalEl.dataset.price);
        subtotalEl.textContent = '৳' + (price * qty).toFixed(2);
    }

    function recalcTotal() {
        let total = 0;
        document.querySelectorAll('[id^="subtotal-"]').forEach(function (el) {
            const val = parseFloat(el.textContent.replace('৳', '').replace(',', ''));
            if (!isNaN(val)) total += val;
        });
        const formatted = total.toFixed(2);
        const t1 = document.getElementById('cartTotal');
        const t2 = document.getElementById('cartGrandTotal');
        if (t1) t1.textContent = formatted;
        if (t2) t2.textContent = formatted;
    }

    function showMsg(el, text, type) {
        if (!el) return;
        el.textContent = text;
        el.className = type;
        el.style.display = 'block';
    }

});