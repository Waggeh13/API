<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chef Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        select,
        button {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        #orderTable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        #orderTable th, #orderTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #orderTable th {
            background-color: #f2f2f2;
        }

        #output {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chef Order</h1>
        <form id="requestForm">
            <label for="product">Product:</label>
            <select id="product" name="product">
                <option value="Potato">Potato</option>
                <option value="Tomato">Tomato</option>
                <option value="Carrot">Carrot</option>
                <option value="Onion">Onion</option>
                <option value="Cabbage">Cabbage</option>
                <option value="Broccoli">Broccoli</option>
            
            </select>
            <button type="submit">Send Request</button>
        </form>
        <table id="orderTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="orderBody">
                <!-- Order items will be inserted here dynamically -->
            </tbody>
        </table>
        <div id="output"></div>
    </div>

    <script>
        const requestForm = document.getElementById('requestForm');
        const outputDiv = document.getElementById('output');
        const orderTable = document.getElementById('orderBody');

        requestForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            const product = document.getElementById('product').value;

            try {
                const response = await fetch('get_product.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ product })
                });

                const data = await response.json();
                if (data.success) {
                    appendOrderItem(data.order);
                    outputDiv.innerText = data.message;
                } else {
                    outputDiv.innerText = data.error;
                }
            } catch (error) {
                console.error('Error sending request:', error);
            }
        });

        function appendOrderItem(order) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${order.product}</td>
                <td>${order.quantity}</td>
                <td>${order.price}</td>
            `;
            orderTable.appendChild(row);
        }
    </script>
</body>
</html>
