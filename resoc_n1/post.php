<article>
    <h3>
        <time><?php echo $post['created'] ?></time>
    </h3>
    <address>par <?php echo $post['author_name'] ?></address>
    <div>
        <p><?php echo $post['content']?></p>
    </div>
    <footer>
        <small>♥ <?php echo $post['like_number'] ?> </small>
                            
        <?php 
            //jeux, culture, tech 
            $str = $post['taglist'];
            $delimiter = ",";
            $parts = explode($delimiter, $str);

            for ($i=0; $i<count($parts); $i++) {
                echo "<a href='tags.php?tag_id=$parts[$i]'>#" . $parts[$i] . ' ' . '</a>';
            }

        ?>
    </footer>
</article>