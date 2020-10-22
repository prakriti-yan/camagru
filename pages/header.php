<header>
	<div id="header">
	<div id="title"><strong>Camagru</strong></div>
		<ul id="nav">
			<? if (isset($_SESSION['loggedInUser'])): ?>
				<li><a href="main.php">Web-camera</a></li>
				<li><a href="myGallery.php">My gallery</a></li>
				<li><a href="gallery.php?page=1">Gallery</a></li>
				<li><a href="profile.php" id="name"><?=$_SESSION['loggedInUser']?></a></li>
				<li><a href="logout.php">Log out</a></li>
			<? else: ?>
				<li><a href="gallery.php?page=1">Gallery</a></li>
				<li><a href="home.php">Connect</a></li>
			<? endif; ?>
		</ul>
	</div>
</header>
