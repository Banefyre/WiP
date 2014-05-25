<section id="header">

    <div class="logo">
        <a href="wip.php"><img src="img/wip-logo.png" alt="Logo WIP" /></a>
    </div>
    <?php if (isset($_SESSION['data']))
    { ?>
    <div id="logout">
        <a href="logout.php"><img width="30px" src="img/logout.png" alt="Log out" /></a>
    </div>

    <div id="menu">
        <ul>
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

    <div id="addproject">
        <a class="btn" href="add_timeline.php">Add a project</a>
    </div>
    <?php } ?>
</section>
