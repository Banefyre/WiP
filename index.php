<?php include('php/header.php'); ?>
<?php if (isset($_SESSION['data']))
        header('Location: wip.php'); ?>
        <h3>
            Login with your GitHub credentials
        </h3>
        <?php
        if (isset($_GET['msg']))
            echo "Bad Credentials";
        ?>
        <form action="php/auth.php" method="post">
            <input type="text" name="login" />
            <input type="password" name="password" />
            <input type="submit" />
        </form>
<?php include('php/footer.php'); ?>
