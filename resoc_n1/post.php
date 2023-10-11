<article class="post-card">
    <header class="post-infos-section">
        <img class="profile-pic" src="./oldnerd.jpeg">
        <div class="post-author-date">
            <h2 class="user-alias-heading">
                <a href=<?= 'wall.php?user_id=' . $post['author_id'] ?>>
                    <?php echo $post['author_name'] ?></a>
            </h2>
            <time class="post-date">
                <?php echo $post['created'] ?>
            </time>
        </div>
        <button class="follow-button">Suivre</button>
    </header>
    <section class="post-content">
        <p>
            <?php echo $post['content'] ?>
        </p>
    </section>
    <footer class="post-footer">
        <a href=<?= "like.php?id=" . $post['post_id']; ?> style="text-decoration: none;">
            <button class="like-button">
                🤮
                <?= $post['like_number'] ?>
            </button>

        </a>
        <ul class="taglist">
            <?php $str = $post['taglist'];
            if ($str !== null && is_string($str)) {
                $delimiter = ",";
                $parts = explode($delimiter, $str);
                if (!empty($parts)) {
                    foreach ($parts as $part) {
                        echo "<a href='' class='taglist-element'>#" . $part . "</a>";
                    }
                }
            } ?>
        </ul>
    </footer>
</article>