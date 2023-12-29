    // Add an event listener to the dropdown
    document.getElementById('regionSelect').addEventListener('change', function () {
      // Get the selected value
      var selectedValue = this.value;

      // Get all cards
      var cards = document.querySelectorAll('.grid .card');

      // Loop through each card and toggle visibility based on the selected value
      cards.forEach(function (card) {
          var cardNumber = card.getAttribute('data-number');
          var cardNumber = card.getAttribute('data-number');

          if (selectedValue === '' || selectedValue === cardNumber) {
              card.style.display = 'block';
          } else {
              card.style.display = 'none';
          }
      });
  });