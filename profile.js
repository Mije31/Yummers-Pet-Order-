
document.addEventListener('DOMContentLoaded', () => {
    const editButton = document.querySelector('.edit-button');
    const form = document.querySelector('form'); 
    const detailsSections = document.querySelectorAll('.details-section');
    const mainContent = document.getElementById('main-contents');
    const cancelButton = form.querySelector('.cancel-button');
    const settingsTab = document.getElementById('settings-tab');
    const settingsSection = document.getElementById('settings-section');

    // Move the form inside the mainContent if it exists
    if (mainContent && form && !mainContent.contains(form)) {
        mainContent.appendChild(form);
    }

    // Hide all forms initially
    if (form) form.style.display = 'none';
    if (settingsSection) settingsSection.style.display = 'none';

    // Edit profile info
    if (editButton) {
        editButton.addEventListener('click', (e) => {
            e.preventDefault();
            detailsSections.forEach(section => section.style.display = 'none');
            if (form) form.style.display = 'block';
            if (settingsSection) settingsSection.style.display = 'none';
        });
    }

    // Cancel edit
    if (cancelButton) {
        cancelButton.addEventListener('click', (e) => {
            e.preventDefault();
            detailsSections.forEach(section => section.style.display = 'block');
            if (form) form.style.display = 'none';
            if (settingsSection) settingsSection.style.display = 'none';
        });
    }

    // Show settings form
    if (settingsTab) {
        settingsTab.addEventListener('click', (e) => {
            e.preventDefault();
            detailsSections.forEach(section => section.style.display = 'none');
            if (form) form.style.display = 'none';
            if (settingsSection) settingsSection.style.display = 'block';
        });
    }
});

