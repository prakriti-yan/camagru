<header>
	<div id="header">
	<div id="title"><strong>Camagru</strong></div>
		<ul id="nav">
			<? if (isset($_SESSION['loggedInUser'])): ?>
				<li><a href="main.php">Web-camera</a></li>
				<li><a href="myGallery.php">My callery</a></li>
				<li><a href="gallery.php?p=1">Gallery</a></li>
				<li><a href="logout.php">Log out</a></li>
			<? else: ?>
				<a href="home.php">Connect</a>
			<? endif; ?>
		</ul>
	</div>
</header>