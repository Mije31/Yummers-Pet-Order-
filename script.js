// function showForm(formId) {
//   document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
//   document.getElementById(formId).classList.add("active"); 
// }

function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
    }
// Function to show my pet categories form
    function showForm(formId) {
      document.querySelectorAll(".pet-categories").forEach(form => form.classList.remove("active"));
      document.getElementById(formId).classList.add("active"); 
  }

 /* Set the width of the side navigation to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

/* Set the width of the side navigation to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

document.addEventListener("DOMContentLoaded", function() {

});

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Get DOM elements
  const menutoggle = document.getElementById('menutoggle');
  const closebtn = document.getElementById('closebtn');
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');

  //Function to open the sidebar
  function opneSidebar() {
    sidebar.classList.add('open');
    menutoggle.classList.add('active');
    overlay.classList.add('active');
  }

  //Function to close the sidebar
  function closeSidebar() {
    sidebar.classList.remove('open');
    menutoggle.classList.remove('active');
    overlay.classList.remove('active');
  }

  // show sidebar when shop is clicked
  menutoggle.addEventListener('click', function() {
    if (sidebar.classList.contains('open')) {
      closeSidebar();
    } else {
      opneSidebar();
    }
  });

  // close sidebar when close button is clicked
  closebtn.addEventListener('click', closeSidebar);

  // close sidebar when overlay is clicked
  overlay.addEventListener('click', closeSidebar);

  // close sidebar by pressing escape key
  document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && sidebar.classList.contains('open')) {
      closeSidebar();
    }
  });


});

//dark mode

document.addEventListener('DOMContentLoaded', function() {
  const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
  
  // Function to switch theme
  function switchTheme(e) {
    if (e.target.checked) {
      document.documentElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.setAttribute('data-theme', 'light');
      localStorage.setItem('theme', 'light');
    }
  }
  
  // Event listener for toggle switch
  toggleSwitch.addEventListener('change', switchTheme, false);
  
  // Check for saved theme preference
  const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
  
  if (currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    if (currentTheme === 'dark') {
      toggleSwitch.checked = true;
    }
  }
});

//tracking form
// Sample tracking data - in a real app, this would come from a server
const trackingData = {
  "PT12345678": {
      trackingNumber: "PT12345678",
      deliveryDate: "April 24, 2025",
      status: "In Transit",
      statusClass: "status-transit",
      timeline: [
          {
              date: "April 21, 2025 - 9:30 AM",
              title: "Package in transit",
              description: "Your package is on its way to the delivery address"
          },
          {
              date: "April 20, 2025 - 3:45 PM",
              title: "Arrived at sorting facility",
              description: "London Distribution Center"
          },
          {
              date: "April 19, 2025 - 10:15 AM",
              title: "Package picked up",
              description: "Carrier has picked up the package"
          },
          {
              date: "April 18, 2025 - 5:20 PM",
              title: "Shipping label created",
              description: "Sender prepared the package for shipment"
          }
      ]
  },
  "PT87654321": {
      trackingNumber: "PT87654321",
      deliveryDate: "April 20, 2025",
      status: "Delivered",
      statusClass: "status-delivered",
      timeline: [
          {
              date: "April 20, 2025 - 2:15 PM",
              title: "Package delivered",
              description: "Delivered to front door"
          },
          {
              date: "April 20, 2025 - 8:30 AM",
              title: "Out for delivery",
              description: "Package is out for delivery today"
          },
          {
              date: "April 19, 2025 - 5:45 PM",
              title: "Arrived at local facility",
              description: "London Distribution Center"
          },
          {
              date: "April 18, 2025 - 11:20 AM",
              title: "Package picked up",
              description: "Carrier has picked up the package"
          },
          {
              date: "April 17, 2025 - 3:10 PM",
              title: "Shipping label created",
              description: "Sender prepared the package for shipment"
          }
      ]
  },
  "PT23456789": {
      trackingNumber: "PT23456789",
      deliveryDate: "April 26, 2025",
      status: "Processing",
      statusClass: "status-pending",
      timeline: [
          {
              date: "April 21, 2025 - 1:30 PM",
              title: "Order processed",
              description: "Your order has been processed and is being prepared for shipment"
          },
          {
              date: "April 20, 2025 - 10:45 AM",
              title: "Payment confirmed",
              description: "Your payment has been confirmed"
          },
          {
              date: "April 20, 2025 - 9:15 AM",
              title: "Order placed",
              description: "Order has been received"
          }
      ]
  }
};

// DOM References
const trackingNumberInput = document.getElementById('tracking-number');
const trackBtn = document.getElementById('track-btn');
const trackingResults = document.getElementById('tracking-results');
const resultTrackingNumber = document.getElementById('result-tracking-number');
const resultDeliveryDate = document.getElementById('result-delivery-date');
const resultStatus = document.getElementById('result-status');
const loginLink = document.getElementById('login-link');
const homeLink = document.getElementById('home-link');
const trackingSection = document.getElementById('tracking-section');
const loginSection = document.getElementById('login-section');
const recentShipments = document.getElementById('recent-shipments');
const shipmentCards = document.querySelectorAll('.shipment-card');

// Track Button Event Listener
trackBtn.addEventListener('click', function() {
  const trackingNumber = trackingNumberInput.value.trim();
  if (!trackingNumber) {
      alert('Please enter a tracking number');
      return;
  }

  // Check if tracking number exists in our data
  if (trackingData[trackingNumber]) {
      const data = trackingData[trackingNumber];
      displayTrackingResults(data);
  } else {
      alert('Tracking number not found. Please try again.');
  }
});

// Display tracking results function
function displayTrackingResults(data) {
  resultTrackingNumber.textContent = data.trackingNumber;
  resultDeliveryDate.textContent = data.deliveryDate;
  resultStatus.textContent = data.status;
  
  // Reset status classes
  resultStatus.classList.remove('status-transit', 'status-delivered', 'status-pending');
  resultStatus.classList.add(data.statusClass);
  
  // Clear previous timeline items
  const timelineContainer = document.querySelector('.timeline');
  const timelineLine = document.querySelector('.timeline-line');
  timelineContainer.innerHTML = '';
  timelineContainer.appendChild(timelineLine);
  
  // Add new timeline items
  data.timeline.forEach(item => {
      const timelineItem = document.createElement('div');
      timelineItem.className = 'timeline-item';
      
      timelineItem.innerHTML = `
          <div class="timeline-point active"></div>
          <div class="timeline-date">${item.date}</div>
          <div class="timeline-title">${item.title}</div>
          <div class="timeline-desc">${item.description}</div>
      `;
      
      timelineContainer.appendChild(timelineItem);
  });
  
  // Show tracking results
  trackingResults.style.display = 'block';
  
  // Scroll to results
  trackingResults.scrollIntoView({ behavior: 'smooth' });
}

// Navigation Event Listeners
loginLink.addEventListener('click', function(e) {
  e.preventDefault();
  trackingSection.style.display = 'none';
  recentShipments.style.display = 'none';
  loginSection.style.display = 'block';
});

homeLink.addEventListener('click', function(e) {
  e.preventDefault();
  trackingSection.style.display = 'block';
  recentShipments.style.display = 'block';
  loginSection.style.display = 'none';
  trackingResults.style.display = 'none';
});

// Shipment Card Event Listeners
shipmentCards.forEach(card => {
  card.addEventListener('click', function() {
      const trackingId = this.querySelector('.shipment-id').textContent;
      trackingNumberInput.value = trackingId;
      trackBtn.click();
  });
});














