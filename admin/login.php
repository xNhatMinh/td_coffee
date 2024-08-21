<?php
include '../components/connection.php';

if (isset($_POST['login'])) {
    session_start();

    $email = $_POST['email'];
    htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $pass = sha1($_POST['password']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ? AND password=?");
    $select_admin->execute([$email, $pass]);

    if ($select_admin->rowCount() > 0) {
        $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin['id'];
        header('location:dashboard.php');
    } else {
        $warning_msg[] = "incorrect email or password";
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
                    <h3>login now</h3>

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
                    <button type="login" name="login" class="btn">login now</button>
                    <p>Don't have an account yet? <a href="register.php">register now</a> </p>
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