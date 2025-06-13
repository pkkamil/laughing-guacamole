document.addEventListener('DOMContentLoaded', () => {
    if (typeof window.PRODUCT_DATA === 'undefined') {
        console.error('Błąd: Obiekt konfiguracyjny window.PRODUCT_DATA nie został znaleziony.');
        return;
    }

    const { productId, stock, isUserLoggedIn } = window.PRODUCT_DATA;

    const form = document.querySelector('.product__content__informations form');
    if (!form) return; 

    const quantityInput = form.querySelector('#items');
    const addToCartBtn = form.querySelector('button[type="submit"]');
    const buyNowBtn = form.querySelector('.buy_now');

    const widget = document.querySelector('.widget-product');
    const widgetIcon = widget.querySelector('.widget__upper .icon');
    const widgetStatus = widget.querySelector('.widget__upper .status');
    const widgetCloseBtn = widget.querySelector('span.close');
    const dimmer = document.querySelector('.dimmer-widget');

    const updateQuantity = (newValue) => {
        let value = parseInt(newValue, 10);
        if (isNaN(value) || value < 1) {
            value = 1;
        }
        if (value > stock) {
            value = stock;
        }
        quantityInput.value = value;
    };

    form.addEventListener('click', (e) => {
        let currentValue = parseInt(quantityInput.value, 10);
        if (e.target.matches('.fa-plus')) {
            updateQuantity(currentValue + 1);
        } else if (e.target.matches('.fa-minus')) {
            updateQuantity(currentValue - 1);
        }
    });

    quantityInput.addEventListener('change', () => updateQuantity(quantityInput.value));
    quantityInput.addEventListener('input', () => updateQuantity(quantityInput.value));

    const showWidget = (type, message) => {
        widgetIcon.className = 'fas icon'; 
        switch (type) {
            case 'success':
            case 200:
                widgetIcon.classList.add('fa-check');
                break;
            case 'warning':
                widgetIcon.classList.add('fa-info-circle');
                break;
            case 'error':
            case 'tryAgain':
                widgetIcon.classList.add('fa-exclamation-triangle');
                break;
        }
        widgetStatus.textContent = message;

        if (window.innerWidth <= 768) {
            dimmer.style.display = 'block';
        }
        widget.style.display = 'block';
        addToCartBtn.disabled = true;
        buyNowBtn.style.pointerEvents = 'none';
    };

    const hideWidget = () => {
        widget.style.display = 'none';
        dimmer.style.display = 'none';
        addToCartBtn.disabled = false;
        buyNowBtn.style.pointerEvents = 'auto';
    };

    widgetCloseBtn.addEventListener('click', hideWidget);

    if (window.innerWidth <= 768) {
        document.addEventListener('mouseup', (e) => {
            if (widget.style.display === 'block' && !widget.contains(e.target)) {
                hideWidget();
            }
        });
    }

    const handleAddToCart = (shouldRedirect = false) => {
        if (!isUserLoggedIn) {
            window.location.href = '/login';
            return;
        }

        $.ajax('/cart/addToCart', {
            type: 'POST',
            data: {
                productId: productId,
                quantity: parseInt(quantityInput.value, 10) || 1,
            },
            success: (data) => {
                if (data.status === 200 || data.status === 'success') {
                    if (shouldRedirect) {
                        window.location.href = '/order';
                    } else {
                        showWidget('success', data.message || 'Dodano produkt do koszyka');
                    }
                } else {
                    showWidget(data.status, data.message || 'Wystąpił nieznany błąd.');
                }
            },
            error: () => {
                showWidget('error', 'Wystąpił błąd sieci. Spróbuj ponownie później.');
            }
        });
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        handleAddToCart(false); 
    });

    buyNowBtn.addEventListener('click', (e) => {
        e.preventDefault();
        handleAddToCart(true);
    });
});