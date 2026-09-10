<nav class="site-nav" aria-label="Primary navigation">
    <div class="nav-bar">
        <a class="nav-logo" href="index.html" aria-label="UCSM Home">
            <img src="IMG/ucsm1.png" alt="UCSM logo">
            <span>UCSM</span>
        </a>

        <button class="menu-toggle" type="button" aria-label="Open navigation menu" aria-expanded="false">
            <i class="bx bx-menu" aria-hidden="true"></i>
        </button>

        <div class="nav-menu">
            <a class="nav-link" href="index.html">Home</a>
            <a class="nav-link" href="info.html">Campus Information</a>
            <a class="nav-link" href="map.html">Map</a>
            <a class="nav-link" href="aboutus.php">About Us</a>

            <button class="dark-light" type="button" aria-label="Toggle dark mode" aria-pressed="false">
                <i class="bx bx-moon moon" aria-hidden="true"></i>
                <i class="bx bx-sun sun" aria-hidden="true"></i>
            </button>

            <div class="search-container">
                <button class="searchToggle" type="button" aria-label="Open search" aria-expanded="false">
                    <i class="bx bx-search search" aria-hidden="true"></i>
                    <i class="bx bx-x cancel" aria-hidden="true"></i>
                </button>

                <form class="search-field" action="se.php" method="get" role="search">
                    <input
                        type="search"
                        name="q"
                        placeholder="Search campus information..."
                        aria-label="Search campus information"
                        autocomplete="off"
                        required
                    >
                    <button type="submit" aria-label="Submit search">
                        <i class="bx bx-search" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
