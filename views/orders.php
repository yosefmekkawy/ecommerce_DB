
<?php

include_once '../Models/orderModel.php';

$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'desc' : 'asc';

$data = get_orders($order);
$employee_access = ['id','user','product','amount','address'];

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <br>
    <br>

    <form method="GET" action="" class="mb-5">
        <div class="input-group">
            <label class="input-group-text" for="order">Sort By ID</label>
            <select name="order" id="order" class="form-select" onchange="this.form.submit()">
                <option value="asc" <?php if($order == 'asc') echo 'selected'; ?>>Ascending</option>
                <option value="desc" <?php if($order == 'desc') echo 'selected'; ?>>Descending</option>
            </select>
        </div>
    </form>

    <?php if(isset($data) && sizeof($data) > 0) { ?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <td>ID</td>
            <td>User Name</td>
            <td>Product</td>
            <td>Quantity</td>
            <td>Address</td>
            <td>Control</td>
            </thead>
            <tbody>
            <?php
            foreach($data as $user){
                echo '<tr>';
                foreach($employee_access as $access){
                    echo '<td>'.$user[$access].'</td>';
                }
                echo '<td class="d-flex gap-2"><button class="btn btn-primary">Edit</button><button class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">Delete</button></td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    <?php } else {
        echo '<p class="alert alert-danger text-center m-3">There is no data</p>';
    }?>
</div>
</body>
</html>
