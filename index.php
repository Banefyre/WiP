<!DOCTYPE html>
<html>
    <head>
    <title>WiP - Work in Progress</title>
    </head>
    <body>
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
    </body>
</html>
