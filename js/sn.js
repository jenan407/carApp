document.addEventListener('DOMContentLoaded', function() {
  
    const signupForm = document.getElementById('signupForm');
    if (signupForm) {
        const passwordInput = document.getElementById('password');

        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const passwordStrengthText = this.nextElementSibling; 

                if (passwordStrengthText) {
                    if (password.length < 6) {
                        passwordStrengthText.textContent = 'Must be at least 6 characters.';
                        passwordStrengthText.style.color = 'red';
                    } else {
                        passwordStrengthText.textContent = 'Password strength: Good'; 
                        passwordStrengthText.style.color = 'green';
                    }
                }
            });
        }

   
        signupForm.addEventListener('submit', function(event) {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
       
            if (!nameInput.value.trim()) {
                alert('Please enter your full name.');
                event.preventDefault();
            }
            if (!emailInput.value.trim()) {
                alert('Please enter your email address.');
                event.preventDefault();
            }
            if (passwordInput && passwordInput.value.length < 6) {
                alert('Password must be at least 6 characters.');
                event.preventDefault();
            }
        });
    }

 
    const verificationForm = document.getElementById('verificationForm');
    if (verificationForm) {
        const verificationCodeInput = document.getElementById('verification_code');

        if (verificationCodeInput) {
            verificationCodeInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); 
                if (this.value.length > 4) {
                    this.value = this.value.slice(0, 4); 
                }
            });
        }

        verificationForm.addEventListener('submit', function(event) {
            const verificationCodeInput = document.getElementById('verification_code');
            if (verificationCodeInput.value.length !== 4 || !/^\d+$/.test(verificationCodeInput.value)) {
                alert('Please enter the 4-digit verification code.');
                event.preventDefault();
            }
        });
    }
});