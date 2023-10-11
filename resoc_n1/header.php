<header>
    <nav id="menu">
        <a aria-label="bouton paramètres utilisateurs" id="settings-nav-link" href=<?php echo 'settings.php?user_id=' . $_SESSION['connected_id']; ?>><i id="settings-icon" class="fa-solid fa-gear"></i></a>
        <hr class="vert-line" />

        <a href=<?php echo 'subscriptions.php?user_id=' . $_SESSION['connected_id']; ?>>Mes abonnements</a></li>
        <hr class="vert-line" />

        <a href=<?= 'wall.php?user_id=' . $_SESSION['logged_id']; ?>>Mur</a>
        <hr class="vert-line" />

        <a href=<?php echo 'followers.php?user_id=' . $_SESSION['connected_id']; ?>>Mes suiveurs</a>
        <hr class="vert-line" />

        <a href=<?php echo 'feed.php?user_id=' . $_SESSION['connected_id']; ?>>Flux</a>
        <hr class="vert-line" />

        <a href=<?php echo 'news.php'; ?>>Actualités</a>
        <hr class="vert-line" />
    </nav>
    <form id="search-bar" class="text-area">
        <label for="search-field" hidden>Rechercher un.e utilisateur.ice</label><input type="text" id="search-field"
            name="search-field" placeholder="recherche">
        <button class="search-button" aria-label="search button"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</header>

