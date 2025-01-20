<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Car Selling Website</title>
    <style>
        /* Basic styling for the profile page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        h2 {
            color: #444;
            margin-bottom: 15px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        section {
            margin-bottom: 30px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }

        .highlight {
            color: #000;
            font-weight: bold;
        }

        .car-listing {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        img {
            width: 50%;
            height: 60%
        }

        a {
            text-decoration: none
        }

        .logout {
            background-color: red;
            position: absolute;
            width: 90px;
            top: 3%;
            left: 90%;
            color: white
        }

        .logout:hover {
            background-color: darkred;
        }

        a {
            text-decoration: none;
            color: BLACK
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h1>User Profile</h1>
        <button class="logout">
            <a href="logout.php">Logout</a>
        </button>

        <!-- Car Listings Section -->
        <section>
            <h2>Your Cars for Sale</h2>
            <div class="car-listing">
                <form action="profiledetails.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="carname" placeholder="Car Name" required>
                    <input type="number" name="carprice" placeholder="Car Price" required>
                    <input type="text" name="carcolor" placeholder="Car Color" required>
                    <input type="number" name="caryear" placeholder="Car Year" required>
                    <input type="text" name="carmodel" placeholder="Car Model" required>
                    <label for="carimage">Car Image:</label>
                    <input type="file" name="carimage" accept="image/*"><br>
                    <button type="submit">Add Listing</button>
                </form>
                <a href="viewbooking">View Booked cars</a>
                <br>
                <a href="bookcar">Book cars</a>
            </div>
        </section>

        <!-- Transaction History Section -->
        <section>
            <h2>Your Transaction History</h2>
            <div class="transaction-history">
                <p>View past transactions here...</p>
            </div>
        </section>

        <!-- Update Profile Button -->
    </div>
    <script>
        let chr = new XMLHttpRequest();
        chr.open('GET', 'transactions.php', true);

        chr.onload = function () {
            if (chr.status === 200) {
                try {
                    // Assuming the response is in JSON format
                    let transactions = JSON.parse(chr.responseText);
                    console.log('Response received:', transactions);

                    // Assuming each transaction is an object, loop through the response to build HTML
                    let transactionHtml = '';
                    transactions.forEach(transaction => {
                        transactionHtml += `
                    <a href="edit.php/${transaction.id}">
                    <div class="transaction">
                    <p>Name: ${transaction.car_name}</p>
                    <img src=uploads/${transaction.car_image} >
                        <p>Car-Color: ${transaction.car_color}</p>
                        <p>Car-Model: ${transaction.car_model}</p>
                        <p>Date: ${transaction.createdAt}</p>
                        <p>Price:${transaction.car_price}</p>

                        <hr>
                    </div></a>
                `;
                    });

                    // Update the DOM with the generated HTML
                    document.querySelector('.transaction-history').innerHTML = transactionHtml;
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            } else {
                console.error('Error:', chr.status, chr.statusText);
            }
        };

        chr.onerror = function () {
            console.error('Network Error');
        };

        chr.send();


    </script>
</body>

</html>