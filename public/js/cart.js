function updateQuantity(id, quantity) {
    if (quantity < 1) quantity = 1;

    fetch('/cart/updateQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `cartItemId=${id}&quantity=${quantity}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                refreshCart();
            } else {
                alert(data.errors || 'Failed to update quantity.');
            }
        });
}

function increment(id) {
    const input = document.getElementById('items-' + id);
    let quantity = parseInt(input.value) || 1;
    quantity++;
    input.value = quantity;
    updateQuantity(id, quantity);
}

function decrement(id) {
    const input = document.getElementById('items-' + id);
    let quantity = parseInt(input.value) || 1;
    if (quantity > 1) quantity--;
    input.value = quantity;
    updateQuantity(id, quantity);
}

function handleInput(id) {
    const input = document.getElementById('items-' + id);
    let quantity = parseInt(input.value) || 1;
    if (quantity < 1) quantity = 1;
    updateQuantity(id, quantity);
}

function refreshCart() {
    fetch('/cart/cartItems')
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.status === 'success') renderCart(data.cartItems);
            } catch (e) {
                console.error('Invalid JSON:', text);
            }
        });
}

function renderCart(items) {
    if (!items || items.length === 0) {
        location.reload();
    }

    const cartContent = document.querySelector('.cart__content.not-empty');
    const table = cartContent.querySelector('.table');
    const summary = cartContent.querySelector('.cart__content__summary');

    let html = `
        <div class="th">Produkt</div>
        <div class="th">Ilość</div>
        <div class="th price">Wartość</div>
    `;

    let total = 0;

    items.forEach(item => {
        total += item.price * item.quantity;
        html += `
            <div class="td imgname">
                <a href="${item.link}">
                    <img src="${item.image}" alt="">
                </a>
                <span>
                    <a href="${item.link}">${item.name}</a>
                </span>
            </div>
            <div class="td quantity">
                <label class="product__content__informations__items">
                    <i class="fas fa-minus" onclick="decrement('${item.id}')"></i>
                    <input
                        type="number"
                        name="items"
                        id="items-${item.id}"
                        data-cart-item-id="${item.id}"
                        value="${item.quantity}"
                        min="1"
                        oninput="handleInput('${item.id}')"
                        onchange="handleInput('${item.id}')">
                    <i class="fas fa-plus" onclick="increment('${item.id}')"></i>
                </label>
                <span class="trash-action"><i class="far fa-trash-alt trash" data-cart-item-id="${item.id}"></i></span>
            </div>
            <div class="td price">${(item.price * item.quantity).toFixed(2)} <span class="grey">zł</span></div>
        `;
    });

    table.innerHTML = html;
    summary.querySelector('.price').innerHTML = `${total.toFixed(2)} <p class="grey">zł</p>`;

    attachTrashEvents();
}

function attachTrashEvents() {
    document.querySelectorAll('.trash-action').forEach(icon => {
        icon.onclick = () => {
            const id = icon.querySelector('.trash').dataset.cartItemId;
            fetch('/cart/removeFromCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `cartItemId=${id}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        refreshCart();
                    } else {
                        alert(data.errors || 'Failed to remove the product.');
                    }
                });
        };
    });
}

// Attach trash events on page load
attachTrashEvents();