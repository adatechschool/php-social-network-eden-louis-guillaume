<article>

<?php //Date de création du post ?>
    <h3>
        <time><?php echo $post['created'] ?></time>
    </h3>

<?php //Nom du créateur du post ?>
    <address>par <a href=<?php echo 'wall.php?user_id='.$post['author_id'];?> style="text-decoration: none;"><?php echo $post['author_name'] ?></address>

<?php //Contenu du post ?>
    <div>
        <p>
            <?php echo $post['content']?>
        </p>
    </div>

    <footer>
    <small>
    <a href=<?= "like.php?id=" . $post['post_id']; ?> style="text-decoration: none;">🤮 <?php echo $post['like_number']; ?></a>
</small>



                            
    <?php 
// Séparer les tags puis les mettre dans un tableau 
$str = $post['taglist'];
if ($str !== null && is_string($str)) {
    $delimiter = ",";
    $parts = explode($delimiter, $str);

    // Pour chaque tag il y a un # devant, ils sont séparés d'un espace et ils ont un lien cliquable
    if (!empty($parts)){
        foreach ($parts as $part) {
            echo "<a href='tags.php?tag_id=$part'>#$part</a> ";
        }
    }
}
 
?>

    </footer>
</article>