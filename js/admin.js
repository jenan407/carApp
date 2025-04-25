document.addEventListener('DOMContentLoaded', function() {
    
    const removeButtons = document.querySelectorAll('.remove-image-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to remove this image?')) {
                event.preventDefault(); 
            }
        });
    });


});