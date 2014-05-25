<?php
include('php/header.php');
echo "<body>";
include('php/menu.php');
$mysqli = connect();

$data = $_SESSION['data'];

$client = new \Github\Client();
$client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

if (isset($data[0]))
{
    $repositories = $client->api('user')->repositories($data[0]);
    ?>
    <div class="mini-form" id="addtimeline">
      <h2>Add your timeline</h2>
      <input type="button" id="button_mine" value="Use your own repository" />
      <input type="button" id="button_other" value="Use someone's else" /><br/>
      <div id="mine_fields">
      <select id="select_mine">
      <?php
      foreach ($repositories as $repo)
          echo "<option value='".$repo['name']."'>".$repo['name']."</option>";
      ?>
      </select>
      <input type="text" id="private_repo" placeholder="Use a private repository" />
      </div>
      <div id="other_fields">
      <input type="text" id="login_repo" placeholder="Enter someone's else account" />
      <input type="button" id="ok" value="ok" />
      <br/>
      <select id="select_other">
      </select>
      </div>
      <input type="button" id="return" value="Cancel" />
      <input type="submit" id="create" value="Create" />
    </div>
    <?php
}
include('php/footer.php');
?>
