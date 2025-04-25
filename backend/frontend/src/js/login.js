document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            try {
                const response = await apiClient.post('/auth/login', {
                    email,
                    password
                });
                
                // Store the token
                apiClient.setToken(response.token);
                
                // Redirect to dashboard or home page
                window.location.href = '/dashboard.html';
            } catch (error) {
                // Show error message
                const errorElement = document.getElementById('error');
                if (errorElement) {
                    errorElement.textContent = error.message;
                    errorElement.style.display = 'block';
                }
            }
        });
    }
}); 