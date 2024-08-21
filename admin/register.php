<?php
include '../components/connection.php';

if (isset($_POST['register'])) {
    $id = unique_id();

    $name = $_POST['name'];
    htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $email = $_POST['email'];
    htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $cpass = sha1($_POST['cpassword']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../image/' . $image;

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
    $select_admin->execute([$email]);

    if ($select_admin->rowCount() > 0) {
        $warning_msg[] = "email already exist";
    } else {
        if ($pass != $cpass) {
            $warning_msg[] = "confirm password not matched";
        } else {
            $insert_admin = $conn->prepare("INSERT INTO `admin`(id, name, email, password, profile) VALUES(?, ?, ?, ?, ?)");
            $insert_admin->execute([$id, $name, $email, $cpass, $image]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $success_msg[] = "new admin registered successfully";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>TD_coffee admin panel - register page</title>
</head>

<body>
    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="POST" enctype="multipart/form-data">
                    <h3>register now</h3>


                    <div class="input-field">
                        <label>user name <sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter your username"
                            oninput="this.value.replace(/\s/g, '')">
                    </div>

                    <div class="input-field">
                        <label>user email <sup>*</sup></label>
                        <input type="email" name="email" maxlength="20" required placeholder="Enter your username"
                            oninput="this.value.replace(/\s/g, '')">
                    </div>

                    <div class="input-field">
                        <label>user password <sup>*</sup></label>
                        <input type="password" name="password" maxlength="20" required placeholder="Enter your password"
                            oninput="this.value.replace(/\s/g, '')">
                    </div>

                    <div class="input-field">
                        <label>confirm password <sup>*</sup></label>
                        <input type="password" name="cpassword" maxlength="20" required
                            placeholder="Confirm your password" oninput="this.value.replace(/\s/g, '')">
                    </div>

                    <div class="input-field">
                        <label>select profile<sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="register" class="btn">register now</button>
                    <p>already have an account? <a href="login.php">login now</a> </p>
                </form>
            </div>
        </section>
    </div>
    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- custom js link -->
    <script type="text/javascript" src="script.js"></script>

    <!-- alert -->
    <?php include '../components/alert.php'; ?>
</body>

</html>