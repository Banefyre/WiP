<div style="width:100%; height:50px; background-color:#EEEEEE">
    <span>
    WiP - Work in Progress
    </span>
    <div style="float:right">
    <a href="add_timeline.php"><input type="submit" value="Add project"/></a><br/>
    <?php
    $mysql = connect();
    $data = $_SESSION['data'];
    $id = $mysql->query("SELECT id FROM users WHERE login='".$data[0]."'");
    $id = $id->fetch_array();
    $query = $mysql->query("SELECT `timeline`.`id`, `timeline`.`name` FROM `timeline` INNER JOIN `timeline_user` ON `timeline`.`id` = `timeline_user`.`id_timeline` WHERE `timeline_user`.`id_user` = ".$id['id']);
    while ($query && ($res = $query->fetch_assoc()))
    {
        echo "<a href='show.php?id=".$res['id']."'>".$res['name']."</a><br/>";
    }
    ?>
</div>
</div>
