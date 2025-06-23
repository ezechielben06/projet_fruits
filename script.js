
// Toggle between Login and Registration forms
const loginToggle = document.getElementById('login-toggle');
const registerToggle = document.getElementById('register-toggle');
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');

loginToggle.addEventListener('click', () => {
    loginForm.classList.add('active');
    registerForm.classList.remove('active');
    loginToggle.classList.add('active');
    registerToggle.classList.remove('active');
});

registerToggle.addEventListener('click', () => {
    registerForm.classList.add('active');
    loginForm.classList.remove('active');
    registerToggle.classList.add('active');
    loginToggle.classList.remove('active');
});
// Mise à jour automatique de l'année
document.addEventListener('DOMContentLoaded', function() {
    // Met à jour l'année du copyright
    document.getElementById('current-year').textContent = new Date().getFullYear();
    
    // Animation au survol des liens sociaux
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', () => {
            link.querySelector('i').style.transform = 'translateY(-3px)';
            link.querySelector('.social-name').style.opacity = '1';
        });
        link.addEventListener('mouseleave', () => {
            link.querySelector('i').style.transform = 'translateY(0)';
            link.querySelector('.social-name').style.opacity = '0';
        });
    });
    
    // Ici vous pourriez ajouter d'autres fonctionnalités dynamiques
    // Par exemple, charger la version depuis une API
    // fetch('/api/version').then(...);
});