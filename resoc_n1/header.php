<header>
    <nav id="menu">
        <a aria-label="bouton paramètres utilisateurs" id="settings-nav-link" href=<?php echo 'settings.php?user_id=' . $_SESSION['connected_id']; ?>><i id="settings-icon" class="fa-solid fa-gear"></i></a>
        <hr class="vert-line" />
        <a href=<?php echo 'subscriptions.php?user_id=' . $_SESSION['connected_id']; ?>>Abonnements</a>
        <hr class="vert-line" />
        <a href=<?php echo 'followers.php?user_id=' . $_SESSION['connected_id']; ?>>Abonnés</a>
        <hr class="vert-line" />
        <a href=<?php echo 'wall.php?user_id=' . $_SESSION['connected_id']; ?>>Mur</a>
        <hr class="vert-line" />
        <a href=<?php echo 'feed.php?user_id=' . $_SESSION['connected_id']; ?>>Flux</a>
        <hr class="vert-line" />
        <a href=<?php echo 'news.php'; ?>>Actualités</a>
        <hr class='vert-line' />
        <a href='logout.php'>Deconnexion</a>
    </nav>
    <form id="search-bar" class="text-area">
        <label for="search-field" hidden>Rechercher un.e utilisateur.ice</label><input type="text" id="search-field"
            name="search-field" placeholder="recherche">
        <button class="search-button" aria-label="search button"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
</header>