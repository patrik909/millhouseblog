    <div>
    <a href="?page=home">Start</a>
    <a href="?page=categories">Kategorier</a>
    <a href="?page=faq">FAQ</a>
    <?php
        if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
            echo '<a href="parts/logout.php">Logga ut</a>';
        }
        else{
            echo '<a href="?page=home">Logga in</a>';   
        }
    ?>
</div>