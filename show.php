<?php
include('php/header.php');
include('php/menu.php');

$mysql = connect();
$res = $mysql->query("SELECT author, name FROM timeline WHERE id = ".$_GET['id']);
$res = $res->fetch_array();

$data = $_SESSION['data'];

$client = new \Github\Client();
$client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

$commits = $client->api('repo')->commits()->all($res['author'], $res['name'], array('sha' => 'master'));

echo "Nb commit : ".count($commits)."<br />";

foreach ($commits as $commit)
{
    echo "auteur du commit : ".$commit['commit']['committer']['name']."<br/>";
    echo "date du commit : ".$commit['commit']['committer']['date']."<br/>";
    echo "message : ".$commit['commit']['message']."<br/>";
    echo "url du commit : ".$commit['html_url']."<br/>";
    echo "<br/>";

}

print_r($commits);



?>



<?php
include('php/footer.php');
?>
