
<?php
session_start();
include_once '../Models/usersModel.php';
include_once __DIR__ . '/../guard/check_user_login.php';
check_login();
$order = isset($_POST['order']) && $_POST['order'] == 'desc' ? 'desc' : 'asc';
$name = isset($_POST['name']) && $_POST['name'] ? "{$_POST['name']}" : '';
$type = isset($_POST['type']) && $_POST['type'] ? "{$_POST['type']}" : '';
$data = get_users($name,$order,$type);
$employee_access = ['id','username','email','phone','pass','type'];
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

    <form method="post" action="" class="row mb-4  justify-content-center flex-wrap gy-4 gx-2 ">

    <div class="col-6">
        <div class="input-group">
            <label class="input-group-text" for="order">Sort By ID</label>
            <select name="order" id="order" class="form-select" ">
            <option value="asc" <?php if($order == 'asc') echo 'selected'; ?>>Ascending</option>
            <option value="desc" <?php if($order == 'desc') echo 'selected'; ?>>Descending</option>
            </select>
        </div>
    </div>
<div class="col-6">
    <select name="type" id="" class="form-select">
        <option value="">Select Type</option>
        <option value="admin" <?php if(isset($type) && $type == 'admin') echo 'selected'; ?>>Admin</option>
        <option value="client" <?php if(isset($type) && $type == 'client') echo 'selected'; ?>>Client</option>
        <option value="employee" <?php if(isset($type) && $type == 'employee') echo 'selected'; ?>>Employee</option>
    </select>

</div>
        <div class="col-6">
            <div class="input-group">

                <span class="input-group-text">Name</span>
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" name="name" value="<?php if(isset($name)) echo $name; ?>">
            </div>
        </div>
        <div class="col-6">
            <input type="submit" class="btn btn-success w-100">
        </div>

    </form>


    <?php if(isset($data) && sizeof($data) > 0) { ?>
            <div class="row justify-content-center">
                <table class="table table-bordered table-striped table-hover col-12 text-center align-items-center">
                    <thead>
                    <td>ID</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Phone</td>
                    <td>Pass</td>
                    <td>Type</td>
                    <td>Control</td>
                    </thead>
                    <tbody>
                    <?php
                    foreach($data as $user){
                        echo '<tr>';
                        foreach($employee_access as $access){
                            echo '<td>'.$user[$access].'</td>';
                        }
                        echo '<td class="d-flex gap-2 justify-content-center"><button class="btn btn-primary">Edit</button><button class="btn btn-danger" onclick="this.parentElement.parentElement.remove()">Delete</button></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>

    <?php } else {
        echo '<p class="alert alert-danger text-center m-3">There is no data</p>';
    }?>
</div>
</body>
</html>
