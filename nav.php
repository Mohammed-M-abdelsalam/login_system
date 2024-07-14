<nav>
    <div>HOME</div>
    <div class="links">
        <?php if(isset($_SESSION["id"])): ?>
            <a href="controllers/UserController.php?type=logout">logout</a>
        <?php else: ?>
            <a href="login.php">login</a>
        <?php endif; ?>
    </div>
</nav>