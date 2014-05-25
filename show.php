<?php
include('php/header.php');
include('php/menu.php');

function init($date, $begin){
	$date = date_create_from_format("Y-m-d\TH:i:sO", $date);
	$begin = date_create_from_format("Y-m-d\TH:i:sO", $begin);
	$interval = date_diff($date,$begin)->format('%a');
	return ($interval);
}

function getFirst($commits)
{
	return ($commits[count($commits) - 1]['commit']['committer']['date']);
}

$mysql = connect();
$res = $mysql->query("SELECT author, name FROM timeline WHERE id = ".$_GET['id']);
$res = $res->fetch_array();
$collabo = $mysql->query("SELECT * FROM timeline_user WHERE id_timeline = ".$_GET['id']);
$collabo = $collabo->fetch_all();

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
			<img src="<?php echo $repo['owner']['avatar_url']; ?>" width="80px" alt="projectimg" />
			<h2 id="name"><?php echo $res['name']; ?></h2>
			<input type="hidden" id="oldname" value='<?php echo $res['name']; ?>' />
			<input type="hidden" id="author" value='<?php echo $repo['owner']['login']; ?>' />
			<p id="description"><?php echo $repo['description'];?></p>
		</div>

		<div id="project-numbers">

			<div class="p-number">
				<span>42</span>
				<p>Checkpoints</p>
			</div>

			<div class="p-number">
				<span><?php echo(count($collabo)); ?></span>
				<p>Collaborateurs</p>
			</div>

			<div class="p-number">
				<span><?php echo(count($commits)); ?></span>
				<p>Commits</p>
			</div>

		</div>
		<?php if ($res['author'] == $data[0])
		{?>
		<div id="project-edit">
			<a href="#">Edit this project</a>
		</div>
		<?php } ?>


	</section>


	<section id="timeline-container">
		<div id="timeline">
<?php
//echo $firstcommit;
		$i = 0;
		foreach ($commits as $commit)
		{
			$i++;
			//echo $commit['commit']['committer']['date'];
			if ($pos === ($scale * init($commit['commit']['committer']['date'], $firstcommit)))
			{
				if ($size <= 4)
					$size++;
			}
			else
				$size = 1;
			$pos = $scale * init($commit['commit']['committer']['date'], $firstcommit);
			echo '<div class="timeline-cp scale'. $size .'" id="'.$i.'" style="left : ' . $pos .'px"></div>';
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
	//echo init($commit['commit']['committer']['date'], $firstcommit);
	//echo "auteur du commit : ".$commit['commit']['committer']['name']."<br/>";
	//echo "date du commit : ".$commit['commit']['committer']['date']."<br/>";
	//echo "message : ".$commit['commit']['message']."<br/>";
	//echo "url du commit : ".$commit['html_url']."<br/>";
	echo "<br/>";

}*/

$scale * init($commit['commit']['committer']['date'], $firstcommit);

$i = 0;
while ($i < (count($commits) - 1))
{
	echo '<div id="group_'.$i.'">';
	if (init($commits[$i]['commit']['committer']['date'], $firstcommit) == init($commits[$i + 1]['commit']['committer']['date'], $firstcommit))
	{
	while (init($commits[$i]['commit']['committer']['date'], $firstcommit) == init($commits[$i + 1]['commit']['committer']['date'], $firstcommit))
	{
		echo "salut";
		$i++;
	}
	}
	else
		$i++;
	echo "</div>";
	//echo '<div class="timeline-cp scale'. $size .'" id="'.$i.'" style="left : ' . $pos .'px"></div>';
}



//print_r($commits);
?>
	</section>



<?php
include('php/footer.php');
?>
