<section id="header">

    <div class="logo">
        <a href="wip.php"><img src="img/wip-logo.png" alt="Logo WIP" /></a>
    </div>

    <div id="menu">
        <ul>
            <li><a id="new_project" href="add_timeline.php">Add project</a></li>
            <li class="categ-project">My projects</li>

            <?php
            $mysql = connect();
            $data = $_SESSION['data'];
            $id = $mysql->query("SELECT id FROM users WHERE login='".$data[0]."'");
            $id = $id->fetch_array();
            $query = $mysql->query("SELECT `timeline`.`id`, `timeline`.`name` FROM `timeline` INNER JOIN `timeline_user` ON `timeline`.`id` = `timeline_user`.`id_timeline` WHERE `timeline_user`.`id_user` = ".$id['id']);
            while ($query && ($res = $query->fetch_assoc()))
            {
                echo "<li><a href='show.php?id=".$res['id']."'>".$res['name']."</a><br/></li>";
            }
            ?>
        </ul>
    </div>
    <div class="content"></div>

</section>
