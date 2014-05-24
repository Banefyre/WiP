<?php
include('php/header.php');
include('php/menu.php');

function init($date, $begin){
	$date = date_create_from_format("Y-m-d\TH:i:sO", $date);
	$begin = date_create_from_format("Y-m-d\TH:i:sO", $begin);
	$interval = date_diff($date,$begin)->format('%d');
	return ($interval);
}

function getFirst($commits)
{
	return ($commits[count($commits) - 1]['commit']['committer']['date']);
}

$mysql = connect();
$res = $mysql->query("SELECT author, name FROM timeline WHERE id = ".$_GET['id']);
$res = $res->fetch_array();

$data = $_SESSION['data'];

$client = new \Github\Client();
$client->authenticate($data[0], $data[1], Github\Client::AUTH_HTTP_PASSWORD);

$commits = $client->api('repo')->commits()->all($res['author'], $res['name'], array('sha' => 'master'));
$repo = $client->api('repo')->show($res['author'], $res['name']);
$firstcommit = getFirst($commits);
$scale = 150;
$pos = -1;
$size = 1;
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
<?php
//echo $firstcommit;

		foreach ($commits as $commit)
		{
			//echo $commit['commit']['committer']['date'];
			//echo "<br><br>";
			if ($pos === ($scale* init($commit['commit']['committer']['date'], $firstcommit)) && $size <= 4)
				$size++;
			else
				$size = 1;
			$pos = $scale * init($commit['commit']['committer']['date'], $firstcommit);
			echo '<div class="timeline-cp scale'. $size . '" id="cp' . $commit['sha'] . '" style="left : ' . $pos .'px"></div>';
			/*echo '<div class="timeline-cp focus-cp" id="cp3"></div>'*/
		}
?>
			</div>
	</section>


	<section id="infos">

		<div id="info-cp">

		<button id="left">l</button>
		<button id="right">r</button>
		</div>

<?php
//echo "Nb commit : ".count($commits)."<br />";

/*foreach ($commits as $commit)
{
	echo "auteur du commit : ".$commit['commit']['committer']['name']."<br/>";
	echo "date du commit : ".$commit['commit']['committer']['date']."<br/>";
	echo "message : ".$commit['commit']['message']."<br/>";
	echo "url du commit : ".$commit['html_url']."<br/>";
	echo "<br/>";

}*/

//print_r($commits);
?>

	</section>



<?php
include('php/footer.php');
?>
