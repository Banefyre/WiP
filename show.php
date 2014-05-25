<?php
include('php/header.php');
echo "<body>";
include('php/menu.php');

function init($date, $begin){
	$date = date_create_from_format("Y-m-d\TH:i:sO", $date)->format("Y-m-d");
	$begin = date_create_from_format("Y-m-d\TH:i:sO", $begin)->format("Y-m-d");
	$date = date_create_from_format("Y-m-d", $date);
	$begin = date_create_from_format("Y-m-d", $begin);
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
$scale = 100;

?>

	<section id="project-info">

		<div id="project-name">
			<img src="<?php echo $repo['owner']['avatar_url']; ?>" width="80px" alt="projectimg" />
			<h2 id="name"><?php echo $res['name']; ?></h2>
			<input type="hidden" id="oldname" value='<?php echo $res['name']; ?>' />
			<input type="hidden" id="author" value='<?php echo $repo['owner']['login']; ?>' />
			<p id="description">Created by : <?php echo $repo['description'];?></p>
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
		$i = 0;
		$j = 0;
		while ($i < count($commits) - 1)
		{
			echo '<div class="timeline-group scale1" id="group_'.$j.'" style="left : ' . $scale * init($commits[$i]['commit']['committer']['date'], $firstcommit) .'px">';

			if (init($commits[$i]['commit']['committer']['date'], $firstcommit) == init($commits[$i + 1]['commit']['committer']['date'], $firstcommit))
			{
				while ($i < count($commits) - 1 && init($commits[$i]['commit']['committer']['date'], $firstcommit) == init($commits[$i + 1]['commit']['committer']['date'], $firstcommit))
				{
					echo '<div id="cp_'.$i.'" author="'.$res['author'].'" repo="'.$res['name'].'" commit_author="'.$commits[$i]["commit"]["committer"]["name"].'" full_date="'.$commits[$i]['commit']['committer']['date'].'" sha="'.$commits[$i]['sha'].'" date="'.date_create_from_format("Y-m-d\TH:i:sO", $commits[$i]['commit']['committer']['date'])->format("Y-m-d").'"></div>';
					$i++;
				}
				echo '<div id="cp_'.$i.'" author="'.$res['author'].'" repo="'.$res['name'].'" commit_author="'.$commits[$i]["commit"]["committer"]["name"].'" full_date="'.$commits[$i]['commit']['committer']['date'].'" sha="'.$commits[$i]['sha'].'" date="'.date_create_from_format("Y-m-d\TH:i:sO", $commits[$i]['commit']['committer']['date'])->format("Y-m-d").'"></div>';
			}
			else
				echo '<div id="cp_'.$i.'" author="'.$res['author'].'" repo="'.$res['name'].'" commit_author="'.$commits[$i]["commit"]["committer"]["name"].'" full_date="'.$commits[$i]['commit']['committer']['date'].'" sha="'.$commits[$i]['sha'].'" date="'.date_create_from_format("Y-m-d\TH:i:sO", $commits[$i]['commit']['committer']['date'])->format("Y-m-d").'"></div>';
			$i++;
			$j++;
			echo "</div>";
		}
?>
			</div>
	</section>


	<section id="infos">

		<div id="infos-content">
			<div id="infos-cp">
				<h4>Checkpoint name</h4>
				<p>
					<span>Date of creation :</span> 13/37/2014<br />
					<span>Type of Checkpoint :</span> GitHub Commit<br />
					<span>Description :</span><br />
					Lorem ipsum cacawete toussa toussa maggle.
				</p>
			</div>
			<div id="list-cp">
			</div>
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

/*$i = 0;
$j = 0;
$size = 1;
while ($i < count($commits) - 1)
{
	echo $commits[$i]['commit']['committer']['date']."<br>";
	$i++;
}*/



//print_r($commits);
?>
	</section>



<?php
include('php/footer.php');
?>
