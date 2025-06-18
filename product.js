let exchangeRates = {};
let baseCurrency = 'GBP';


async function fetchRates() {
  const res = await fetch(`https://api.exchangerate-api.com/v4/latest/${baseCurrency}`);
  exchangeRates = await res.json();
}

async function convertProductPrices() {
  const selectedCurrency = document.getElementById('currency').value;

  if (!exchangeRates.rates || !exchangeRates.rates[selectedCurrency]) {
    await fetchRates();
  }

  const rate = exchangeRates.rates[selectedCurrency];
  const symbol = getSymbol(selectedCurrency);

  document.querySelectorAll('.product-price').forEach(el => {
    const gbp = parseFloat(el.dataset.gbp);
    const converted = (gbp * rate).toFixed(2);
    el.textContent = `${symbol}${converted}`;
  });
}

function getSymbol(code) {
  const map = {
    USD: '$',
    EUR: '€',
    GBP: '£',
    INR: '₹',
    JPY: '¥'
  };
  return map[code] || code + ' ';
}

// Remember last selected currency
document.getElementById('currency').addEventListener('change', () => {
  sessionStorage.setItem('currency', document.getElementById('currency').value);
});

window.addEventListener('load', () => {
  const saved = sessionStorage.getItem('currency');
  if (saved) {
    document.getElementById('currency').value = saved;
    convertProductPrices();
  }
});

function convertPrices() {
  const selectedCurrency = document.getElementById('currency').value;
  const url = new URL(window.location.href);
  url.searchParams.set('currency', selectedCurrency);
  window.location.href = url.toString(); // This will refresh the page with the new currency
}

document.addEventListener('DOMContentLoaded', () => {
  const cartForms = document.querySelectorAll('.add-to-cart-form');

  cartForms.forEach(form => {
    form.addEventListener('submit', async function (e) {
      e.preventDefault(); // Stop form from reloading page

      const formData = new FormData(this);

      try {
        const response = await fetch('add_to_cart.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.text();
       showCartPopup("Product added to cart!");

      } catch (error) {
        console.error('Error:', error);
        showCartPopup("Failed to add product to cart.");

      }
    });
  });
});

function showCartPopup(message = "Product added to cart!") {
  const popup = document.getElementById('cart-popup');
  popup.textContent = message;
  popup.classList.add('show');

  setTimeout(() => {
    popup.classList.remove('show');
  }, 3000); // Hide after 3 seconds
}
