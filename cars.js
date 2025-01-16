document.getElementById('carForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Get the input values
    const model = document.getElementById('carModel').value;
    const price = document.getElementById('carPrice').value;
    const location = document.getElementById('carLocation').value;

    // Create a new car listing
    const carList = document.getElementById('carList');
    const newCar = document.createElement('li');
    newCar.classList.add('car-item');

    newCar.innerHTML = `
<h3>${model}</h3>
<p>Price: $${price}</p>
<p>Location: ${location}</p>
`;

    // Append the new car to the car list
    carList.appendChild(newCar);

    // Clear the form inputs
    document.getElementById('carModel').value = '';
    document.getElementById('carPrice').value = '';
    document.getElementById('carLocation').value = '';
});