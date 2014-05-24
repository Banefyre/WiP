<?php
include('php/header.php');
include('php/menu.php');
$mysqli = connect();

$data = $_SESSION['data'];

$client = new \Github\Client();
$client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

if (isset($data[0]))
{
    $repositories = $client->api('user')->repositories($data[0]);
    ?>
    <div id="addtimeline">
      <h2>Ajouter votre timeline</h2>
      <input type="button" id="button_mine" value="..avec votre propre dépôt" />
      <input type="button" id="button_other" value="..avec un autre dépôt" /><br/>
      <div id="mine_fields">
      <select id="select_mine">
      <?php
      foreach ($repositories as $repo)
          echo "<option value='".$repo['name']."'>".$repo['name']."</option>";
      ?>
      </select>
      <input type="text" id="private_repo" placeholder="Ou avec un dépôt privé" />
      </div>
      <div id="other_fields">
      <input type="text" id="login_repo" placeholder="Entrez le pseudo Github de la personne" />
      <input type="button" id="ok" value="ok" />
      <br/>
      <select id="select_other">
      </select>
      </div>
      <input type="button" id="return" value="Retour" />
      <input type="submit" id="create" value="Créer" />
    </div>
    <?php
}
include('php/footer.php');
?>
