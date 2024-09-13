<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$dbName = "prod_manage";
$conn = new mysqli($hostName, $userName, $password, $dbName);
// if ($conn == TRUE) {
//     echo "Good";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>
        table {
            width: 100%;
            border-collapse: collapse
        }

        tr,
        td,
        th {
            border: 1px solid;

        }

        th,
        td {
            padding: 1rem;
        }
    </style>

</head>

<body>

    <div class="container">
        <a href="../index.php" class="btn btn-primary my-4">back</a>
        <table>
            <thead>
                <tr>
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_query = "SELECT * FROM product";
                $select_result = $conn->query($select_query);
                $datas = mysqli_fetch_all($select_result, MYSQLI_ASSOC);
                $i = 0;
                foreach ($datas as $data):
                ?>
                    <tr>
                        <th><?= $i++ ?></th>
                        <th><?= $data['name'] ?></th>

                        <th>
                            <form action="">
                                <!-- Use data attributes to store item ID and quantity -->
                                <input type="hidden" class="itemId" value="<?= $data['id'] ?>"> <!-- ID of the item -->
                                <input type="button" value="+" onclick="changeValue(this, 1)">
                                <input type="text" class="quantity" disabled value="<?= $data['quantity'] ?>">
                                <input type="button" value="-" onclick="changeValue(this, -1)">
                            </form>
                        </th>
                        <th><?= $data['price'] ?></th>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>

    </div>





    <script>
        const changeValue = (button, delta) => {
            let form = button.parentElement;
            let quantity = parseInt(form.querySelector('.quantity').value);
            let itemId = form.querySelector('.itemId').value;
            let changedValue = quantity + delta;
            // console.log(changedValue);
            form.querySelector('.quantity').value = changedValue;
            updateQnty(changedValue, itemId)
        }
        const updateQnty = (cQuantity, itemId) => {
            fetch(`/php-exp/api-handeling/api/updatequantity.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        quantity: cQuantity,
                        id: itemId
                    })
                }).then(Response => Response.json())
                .then(data => console.log(data))
                .catch(error => console.error('Error:',
                    error))
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>

</html>