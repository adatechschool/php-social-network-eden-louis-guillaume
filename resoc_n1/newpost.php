<article class="message-section">
    <form class="message-form" action=<?= "wall.php?user_id=" . $userId ?> method="post">
        <label for="message" class="message-instructions">
            <?php
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            $listAuteurs = [];
            $laQuestionEnSql = "SELECT * FROM users";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            while ($user = $lesInformations->fetch_assoc()) {
                $listAuteurs[$user['id']] = $user['alias'];
            }

            $enCoursDeTraitement = isset($_POST['message']);
            if ($enCoursDeTraitement) {
                $authorId = $_SESSION['connected_id'];
                $postContent = $_POST['message'];
                $authorId = intval($mysqli->real_escape_string($authorId));
                $postContent = $mysqli->real_escape_string($postContent);
                $lInstructionSql = "INSERT INTO posts "
                    . "(id, user_id, content, created, parent_id) "
                    . "VALUES (NULL, "
                    . $_SESSION['connected_id'] . ", "
                    . "'" . $postContent . "', "
                    . "NOW(), "
                    . "NULL)";
                ;
                $ok = $mysqli->query($lInstructionSql);
                if (!$ok) {
                    echo " Impossible d'ajouter le message: " . $mysqli->error;
                } else {
                    echo " Message envoyé ! " . $_SESSION['connected_alias'];
                }
            }
            ?>
            Bienvenue sur votre mur, partagez ici ce que vous voulez !
        </label>
        <textarea name='message' class="text-area message-area" placeholder="Rédigez votre message ici"></textarea>
        <input type='submit' class="button-like send-button">
    </form>
</article>