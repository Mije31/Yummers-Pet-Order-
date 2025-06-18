// Add this JavaScript to implement dark mode functionality

document.addEventListener('DOMContentLoaded', () => {
    // Check for saved user preference
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    // Apply dark mode if previously selected
    if (isDarkMode) {
      document.body.classList.add('dark-mode');
      updateDarkModeIcon(true);
    }
    
    // Add dark mode toggle button to header if not already present
    if (!document.querySelector('.dark-mode-toggle')) {
      addDarkModeToggle();
    }
  });
  
  // Function to add dark mode toggle button
  function addDarkModeToggle() {
    const userActionsDiv = document.querySelector('.user-actions');
    
    if (userActionsDiv) {
      // Create toggle button
      const toggleButton = document.createElement('button');
      toggleButton.className = 'dark-mode-toggle';
      toggleButton.title = 'Toggle Dark Mode';
      
      // Determine which icon to show based on current mode
      const isDark = document.body.classList.contains('dark-mode');
      toggleButton.innerHTML = isDark ? 
        '<i class="fas fa-sun"></i>' : 
        '<i class="fas fa-moon"></i>';
      
      // Add click event handler
      toggleButton.addEventListener('click', toggleDarkMode);
      
      // Add button to header
      userActionsDiv.appendChild(toggleButton);
    }
  }
  
  // Function to toggle dark mode
  function toggleDarkMode() {
    // Toggle dark mode class
    document.body.classList.toggle('dark-mode');
    
    // Save user preference
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
    
    // Update icon
    updateDarkModeIcon(isDarkMode);
  }
  
  // Update icon based on dark mode state
  function updateDarkModeIcon(isDark) {
    const toggleBtn = document.querySelector('.dark-mode-toggle');
    if (toggleBtn) {
      toggleBtn.innerHTML = isDark ? 
        '<i class="fas fa-sun"></i>' : 
        '<i class="fas fa-moon"></i>';
    }
  }

