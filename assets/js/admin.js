// assets/js/admin.js
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview functionality
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    if (imageInput && imagePreview) {
        // Show existing image on load if src is set and not empty
        if (imagePreview.src && !imagePreview.src.endsWith('#') && imagePreview.getAttribute('src') !== '') {
            imagePreview.style.display = 'block';
        }

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.setAttribute('src', e.target.result);
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                imagePreview.setAttribute('src', '');
            }
        });
    }
});
