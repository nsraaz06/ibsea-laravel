document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('billing-toggle');
    const prices = document.querySelectorAll('.price');

    toggle.addEventListener('change', () => {
        prices.forEach(price => {
            // Skip the "Free" tier if it's set to $0
            if (price.innerText === '$0' || price.innerText === '0') return;

            const monthlyValue = price.getAttribute('data-monthly');
            const yearlyValue = price.getAttribute('data-yearly');

            if (toggle.checked) {
                // Show Yearly Price
                price.innerText = yearlyValue;
            } else {
                // Show Monthly Price
                price.innerText = monthlyValue;
            }
        });
    });
});