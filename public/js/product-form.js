document.addEventListener('DOMContentLoaded', () => {
    const preview = document.getElementById('preview');
    const imageInput = document.getElementById('image');
    const widget = document.getElementById('widget');
    const closeWidgetButton = widget ? widget.querySelector('.close') : null;

    if (preview && imageInput) {
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    }

    if (closeWidgetButton) {
        closeWidgetButton.addEventListener('click', () => {
            widget.style.display = 'none';
        });
    }
});