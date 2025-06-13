document.querySelectorAll('.td.right .delete').forEach(el => {
    el.addEventListener('click', () => {
        console.log(el);
        document.getElementById('product-delete').setAttribute('action', '/admin/products/' + el.querySelector('.delete').getAttribute('data-product-id') +
            '/delete');
        document.querySelector('.confirmation').style.display = 'flex';
    });
});

document.querySelector('.cancel').addEventListener('click', () => {
    document.querySelector('.confirmation').style.display = 'none';
});