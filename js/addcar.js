document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');

    if (imageUpload && imagePreview) {
        imageUpload.addEventListener('change', function() {
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.classList.add('image-preview');
                        previewDiv.innerHTML = `<img src="${e.target.result}" alt="Preview">`;

                        const removeButton = document.createElement('button');
                        removeButton.textContent = 'Remove';
                        removeButton.classList.add('remove-image-button');
                        removeButton.addEventListener('click', function() {
                            previewDiv.remove();
                        
                        });

                        previewDiv.appendChild(removeButton);
                        imagePreview.appendChild(previewDiv);
                    }
                    reader.readAsDataURL(file);
                }
            }
            imageUpload.value = '';
        });
    }
});
