

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

