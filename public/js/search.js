
const API_SEARCH = '/Web_Tech_Project/public/api/search_api.php';

document.addEventListener('DOMContentLoaded', function () {

    const searchInput    = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const genderFilter   = document.getElementById('genderFilter');
    const productGrid    = document.getElementById('productGrid');

    loadCategories();

    if (searchInput)    searchInput.addEventListener('input', debounce(doSearch, 400));
    if (categoryFilter) categoryFilter.addEventListener('change', doSearch);
    if (genderFilter)   genderFilter.addEventListener('change', doSearch);

    function loadCategories() {
        if (!categoryFilter) return;
        fetch(API_SEARCH + '?action=categories')
            .then(r => r.json())
            .then(data => {
                if (!data.categories) return;
                data.categories.forEach(function (cat) {
                    const opt = document.createElement('option');
                    opt.value       = cat.id;
                    opt.textContent = cat.name;
                    categoryFilter.appendChild(opt);
                });
            });
    }

    function doSearch() {
        const q        = searchInput    ? searchInput.value.trim() : '';
        const category = categoryFilter ? categoryFilter.value      : '';
        const gender   = genderFilter   ? genderFilter.value        : '';

        const url = `${API_SEARCH}?q=${encodeURIComponent(q)}&category=${encodeURIComponent(category)}&gender=${encodeURIComponent(gender)}`;

        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.success) renderProducts(data.products);
            });
    }

    function renderProducts(products) {
        if (!productGrid) return;

        if (products.length === 0) {
            productGrid.innerHTML = '<p style="text-align:center;color:#637794;padding:40px">No products found.</p>';
            return;
        }

        productGrid.innerHTML = products.map(function (p) {
            return `
                <a href="product_page.php?id=${p.id}" style="text-decoration:none;color:inherit;">
                    <div class="product-card">
                        <img src="../public/uploads/products/${safe(p.image_path)}"
                             alt="${safe(p.name)}">
                        <div class="product-card-info">
                            <p class="card-meta">${safe(p.gender)} — ${safe(p.category_name)}</p>
                            <p class="card-name">${safe(p.name)}</p>
                            <p class="card-price">৳${parseFloat(p.price).toFixed(2)}</p>
                        </div>
                    </div>
                </a>
            `;
        }).join('');
    }

    function debounce(fn, delay) {
        let timer;
        return function () {
            clearTimeout(timer);
            timer = setTimeout(fn, delay);
        };
    }
    function safe(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }
});