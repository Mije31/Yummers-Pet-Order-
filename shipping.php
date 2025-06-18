<?php
session_start();
$order_id = $_SESSION['order_id'] ?? null;

if (!$order_id) {
    echo "No order found.";
    exit;
}

// Fetch and show tracking info based on this order ID
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shipment Tracker (TrackingMore)</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f2f2f2;
      padding: 40px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    .tracker-box {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 500px;
      width: 100%;
    }
    input, select, button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      background-color: #28a745;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #218838;
    }
    pre {
      background: #f0f0f0;
      padding: 10px;
      border-radius: 6px;
      overflow-x: auto;
    }
  </style>
</head>
<body>

  <div class="tracker-box">
    <h2>Track Your Shipment</h2>
    <input type="text" id="trackingNumber" placeholder="Enter Tracking Number">
    <select id="courierCode">
      <option value="ups">UPS</option>
      <option value="usps">USPS</option>
      <option value="fedex">FedEx</option>
      <option value="dhl">DHL</option>
      <!-- Add more from TrackingMore's courier list if needed -->
    </select>
    <button onclick="trackShipment()">Track</button>

    <h3>Result:</h3>
    <pre id="tracking-info">Tracking info will appear here...</pre>
  </div>

 <script>
function trackShipment() {
  const trackingNumber = document.getElementById('trackingNumber').value.trim();
  const courierCode = document.getElementById('courierCode').value.trim();

  if (!trackingNumber || !courierCode) {
    alert("Please enter both tracking number and courier.");
    return;
  }

  const apiKey = 'js34degy-hmqs-qp2s-pott-85wco0ek3z08';

  // Step 1: Register the tracking number
  fetch('https://api.trackingmore.com/v4/trackings/post', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Tracking-Api-Key': apiKey
    },
    body: JSON.stringify({
      tracking_number: trackingNumber,
      carrier_code: courierCode
    })
  })
  .then(res => res.json())
  .then(postResponse => {
    // Optional: show confirmation that it's registered
    console.log("Registered:", postResponse);

    // Step 2: Now retrieve the tracking details
    return fetch(`https://api.trackingmore.com/v4/trackings/${courierCode}/${trackingNumber}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Tracking-Api-Key': apiKey
      }
    });
  })
  .then(res => res.json())
  .then(data => {
    document.getElementById('tracking-info').textContent = JSON.stringify(data, null, 2);
  })
  .catch(err => {
    console.error("Error:", err);
    document.getElementById('tracking-info').textContent = 'Failed to fetch tracking info. Please check courier and tracking number.';
  });
}
</script>



</body>
</html>
