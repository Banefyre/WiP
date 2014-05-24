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
$repo = $client->api('repo')->show($res['author'], $res['name']);

?>

	<section id="project-info">

		<div id="project-name">
			<img src="img/project-img.png" alt="projectimg" />
			<h2><?php echo $res['name']; ?></h2>
			<p><?php echo $repo['description'];?></p>
		</div>

		<div id="project-numbers">

			<div class="p-number">
				<span>42</span>
				<p>Checkpoints</p>
			</div>

			<div class="p-number">
				<span>5</span>
				<p>Collaborateurs</p>
			</div>

			<div class="p-number">
				<span><?php echo(count($commits)); ?></span>
				<p>Commits</p>
			</div>

		</div>

		<div id="project-edit">
			<a href="#edit">Edit this project</a>
		</div>


	</section>


	<section id="timeline-container">
		<div id="timeline">
			<div class="timeline-cp" id="cp1"></div>
			<div class="timeline-cp" id="cp2"></div>
			<div class="timeline-cp focus-cp" id="cp3"></div>
			<div class="timeline-cp" id="cp4"></div>

		</div>

	</section>


	<section id="infos">

		<div id="info-cp">

		</div>

        <?php
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

	</section>



<?php
include('php/footer.php');
?>
