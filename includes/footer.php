<footer>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php if ($isActive == "contact") echo 'active';?>" 
                   href="<?php if($isActive == "contact") echo '#'; else echo 'contact.php';?>">
                   contact us
                </a>
            </li>
        </ul>

        <p id="footer_text">© 2025 My Website. All rights are reserved.</p>

    </nav>
</footer>