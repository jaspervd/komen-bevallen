<?php
require_once ('config.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Admin - Komen Bevallen</title>
	<link rel="stylesheet" href="screen.css">
</head>
<body<?=(!empty($error)? ' class="error"' : ''); ?>>
	<div class="container">
		<header><h1>A207</h1></header>
		<form method="post" action="#" autocomplete="off">
			<fieldset>
				<?php
				if (empty($_SESSION['komen_bevallen']['admin'])) { ?>
				<p>
					<label for="username">Gebruikersnaam</label>
					<input type="text" name="username" id="username" required placeholder="Gebruikersnaam" />
				</p>
				<p>
					<label for="password">Wachtwoord</label>
					<input type="password" name="password" id="password" required placeholder="Wachtwoord" />
				</p>
				<p>
					<input type="submit" name="login" value="Login" class="button" />
				</p>
				<?php
			} else { ?>
			<p>
				<label for="date">Datum</label>
				<input type="date" name="date" id="date" value="<?php
				echo $currentSettings['date']; ?>" />
			</p>
			<p class="radio">
				<label><input type="radio" name="finished" value="yes"<?php
				echo ($currentSettings['finished'] === 'yes' ? ' checked' : '') ?> /><span>Afsluiten week</span></label>
				<label><input type="radio" name="finished" value="no"<?php
				echo ($currentSettings['finished'] === 'no' ? ' checked' : '') ?> /><span>Openen week</span></label>
				<div class="clear"></div>
			</p>
			<p>
				<input type="submit" name="edit" value="Update" class="button" />
			</p>
			<?php
		} ?>
	</fieldset>
	<?php
	if (!empty($error)) {
		echo '<div class="error">' . $error . '</div>';
	} ?>
</form>
</div>
</body>
</html>