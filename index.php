<?php
  include('php/header.php');
echo '<body id="login-body">';

 if (isset($_SESSION['data']))
        header('Location: wip.php'); ?>
        <div class="mini-form" id="login-form">
          <img src="img/logo.png" alt ="Logo WIP" />
          <h2>
              Work in Progress
          </h2>

          <?php
          if (isset($_GET['msg']))
              echo "Wrong login or password";
          ?>
          <form action="php/auth.php" method="post">
              <input type="text" name="login" />
              <input type="password" name="password" />
              <input type="submit" value="Log me" />
              <input style="float:right" type="submit" value="Register" />
          </form>
          <div style="clear:both"></div>
          <h3>Tip : you can use your GitHub account !</h3>
        </div>
<?php include('php/footer.php'); ?>
