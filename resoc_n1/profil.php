<article class="profile-card">
    <?php
    $laQuestionEnSql = "
                SELECT users.*, 
                count(DISTINCT posts.id) as totalpost, 
                count(DISTINCT recieved.user_id) as totalrecieved, 
                count(DISTINCT followed_by.following_user_id) as followers
                FROM users 
                LEFT JOIN posts ON posts.user_id=users.id 
                LEFT JOIN likes as recieved ON recieved.post_id=posts.id 
                LEFT JOIN followers as followed_by ON followed_by.following_user_id=users.id 
                WHERE users.id = '$userId' 
                GROUP BY users.id
                ";
    $lesInformations = $mysqli->query($laQuestionEnSql);
    $user = $lesInformations->fetch_assoc();
    ?>
    <img class="profile-pic" src="./oldnerd.jpeg">
    <section class="profile-info-section">
        <h2 class="user-alias-heading">
            <?= $user['alias'] ?>
        </h2>
        <p class="user-email">
            <?= $user['email'] ?>
        </p>
        <p class="user-message-count">
            <?php if ($user['totalpost']) {
                echo $user['totalpost'] . " messages";
            } else {
                echo "0 messages";
            }
            ; ?>
        </p>

        <?php /*if ($user['followed_by']) {
            echo "<p class='user-followers-count'>" . $user['followed_by'] . " followers</p>";
        } else {
            echo "<p class='user-followers-count'>0 followers</p>";
        } ?>

        <?php if ($user['total_recieved']) {
            echo "<p class='user-likes-count'>🤮" . $user['totalrecieved'] . "reçus</p>";
        } else {
            echo "<p class='user-likes-count'>🤮 0</p>";
        } */?>

    </section>
    <?php
    if ($_SESSION['connected_id'] != $userId) {
        $isFollowingQuery = $mysqli->prepare('SELECT * FROM followers WHERE followed_user_id = ? AND following_user_id = ?');
        $isFollowingQuery->bind_param('ii', $userId, $_SESSION['connected_id']);
        $isFollowingQuery->execute();
        $result = $isFollowingQuery->get_result();

        if ($result->num_rows > 0) {
            // L'utilisateur est abonné, affichez le bouton "Se désabonner"
            echo "<a href='follow.php?followedid=$userId'><button id='newpost' class='unfollow-button' aria-label='ne plus suivre cet.te utilisateur.ice'>Se désabonner</button></a>";
        } else {
            // L'utilisateur n'est pas abonné, affichez le bouton "S'abonner"
            echo "<a href='follow.php?followedid=$userId'><button id='newpost' class='follow-button' aria-label='ne plus suivre cet.te utilisateur.ice'>S'abonner</button></a>";
        }
    } ?>

</article>