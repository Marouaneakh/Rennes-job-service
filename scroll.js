// Get the sections to scroll to
const sections = {
  work: document.querySelector('.work-section'),
  about: document.querySelector('.about-section'),
  contact: document.querySelector('.contact-section')
};

// Add event listeners to the links
document.querySelector('#Work').addEventListener('click', function(event) {
  event.preventDefault();
  scrollToSection('work');
});

document.querySelector('#About').addEventListener('click', function(event) {
  event.preventDefault();
  scrollToSection('about');
});

document.querySelector('#Contact').addEventListener('click', function(event) {
  event.preventDefault();
  scrollToSection('contact');
});

// Scroll to the desired section
function scrollToSection(section) {
  const target = sections[section];
  if (target) {
    window.scrollTo({
      top: target.offsetTop,
      behavior: 'smooth'
    });
  }
}