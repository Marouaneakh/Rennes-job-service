// Get all form elements
const forms = document.querySelectorAll('form');

// Add an event listener to each form
forms.forEach(form => {
  form.addEventListener('submit', function(event) {
    // Prevent the form from submitting normally
    event.preventDefault();

    // Check if running on file protocol (Common Error)
    if (window.location.protocol === 'file:') {
        alert("STOP! You are opening this file directly.\n\nYou must use XAMPP.\n1. Open browser.\n2. Type: http://localhost/projet 01/projet kaml.html");
        return;
    }

    // Create FormData object to capture all fields automatically
    const formData = new FormData(form);

    // Send data to PHP
    fetch('server.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text()) // Get raw text first to debug errors
    .then(text => {
      try {
        const data = JSON.parse(text); // Try to parse JSON
        if (data.status === 'success') {
          window.location.href = 'thankyou.html';
        } else {
          alert('Error: ' + data.message);
        }
      } catch (e) {
        // If PHP returns an error (like a warning), show it to the user
        console.error('Server Error:', text);
        alert('Server Error (Not JSON): ' + text.substring(0, 200));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      if(confirm('Request Failed: Could not connect to "server.php".\n\n1. Did you rename the PHP file to "server.php"?\n2. Is XAMPP running?\n\nClick OK to go to the Thank You page anyway.')) {
        window.location.href = 'thankyou.html';
      }
    });
  });
});

// --- Menu and Modal Logic ---

const menuBtn = document.getElementById('menu-btn');
const dropdownMenu = document.getElementById('dropdown-menu');
const authModal = document.getElementById('auth-modal');
const reportModal = document.getElementById('report-modal');
const closeBtns = document.querySelectorAll('.close-btn');

// Toggle Menu
menuBtn.addEventListener('click', () => {
    dropdownMenu.classList.toggle('show');
});

// Open Modals
document.getElementById('signin-link').addEventListener('click', (e) => {
    e.preventDefault();
    dropdownMenu.classList.remove('show');
    authModal.style.display = 'flex';
    document.getElementById('signin-container').style.display = 'block';
    document.getElementById('login-container').style.display = 'none';
});

document.getElementById('login-link').addEventListener('click', (e) => {
    e.preventDefault();
    dropdownMenu.classList.remove('show');
    authModal.style.display = 'flex';
    document.getElementById('signin-container').style.display = 'none';
    document.getElementById('login-container').style.display = 'block';
});

document.getElementById('report-link').addEventListener('click', (e) => {
    e.preventDefault();
    dropdownMenu.classList.remove('show');
    reportModal.style.display = 'flex';
});

// Switch between Sign In and Log In
document.getElementById('switch-to-login').addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('signin-container').style.display = 'none';
    document.getElementById('login-container').style.display = 'block';
});
document.getElementById('switch-to-signin').addEventListener('click', (e) => {
    e.preventDefault();
    document.getElementById('login-container').style.display = 'none';
    document.getElementById('signin-container').style.display = 'block';
});

// Close Modals
closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        authModal.style.display = 'none';
        reportModal.style.display = 'none';
    });
});

window.addEventListener('click', (e) => {
    if (e.target == authModal) authModal.style.display = 'none';
    if (e.target == reportModal) reportModal.style.display = 'none';
});