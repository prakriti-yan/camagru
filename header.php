<header>
	<div>
	<div class="title">Camagru</div>
	<nav>
		<? if (isset($_SESSION['loggedInUser'])): ?>
			<a href="main.php">Web-camera</a>
			<a href="myGallery.php">My callery</a>
			<a href="gallery.php?p=1">Gallery</a>
			<a href="logout.php">Log out</a>
		<? else: ?>
			<a href="home.php">Connect</a>
		<? endif; ?>
	</nav>
	</div>
</header>