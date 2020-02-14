<?php

if (isset($_POST['url'])) {
	$url = $_POST['url'];
	$command = "youtube-dl -x --audio-format mp3 --add-metadata ".$url." /var/www/html/Converter/";
	exec($command ,$output);

}
if (isset($_POST['submit'])) {
	if(!empty($_POST['check_list'])){
		foreach($_POST['check_list'] as $selected){
			$command = "rm /var/www/html/tests/'$selected'";
			exec($command, $output);
		}
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Convertisseur mp3</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:500&display=swap" rel="stylesheet"> 
</head>
<body>
	<main>
		<form method="post">
			<label for="url"></label>
			<input type="url" name="url" placeholder="...URL..." />
			<div class="btn">
				<button type="submit">Convertir</button>
			</div>
		</form>
	</main>

	<aside>
		<h6>Liste des fichiers téléchargés :</h6>
		
		<form action="" method="post">
		<?php
		$dir = new DirectoryIterator('.');
		foreach ($dir as $fileInfo) {
		    if ($fileInfo->getExtension() == "mp3") {
		    	$fileName = $fileInfo->getFilename();
		    	echo "<input type=\"checkbox\"name=\"check_list[]\" value=\"$fileName\"><label>$fileName</label><br/>\n";
		    }
		}
		?>

		<input type="submit" name="submit" value="supprimer"/>
		</form>
	</aside>

</body>
</html>