<h2><?php echo $title ?> </h2>
<ul>
    <?php foreach($userslist as $user):?>
        <?php echo "<li> ".$user['id'].": ".$student['nom']." ".
        $student['prenom'].", ".$student['email']."";?>
    </li>
    <?php endforeach ?>
</ul>