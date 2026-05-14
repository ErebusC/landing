<?php

	//Image randomisation function
	function rando_image(){
		/*Dynamic way to get the root on the current server.
		makes it easier if moving site to different structures*/
		$dir = $_SERVER['DOCUMENT_ROOT'] . '/wallpapers/';

		/*creates a glob array of all images in the folder, just in case we allow for all permutations
		of popular image formats, however webp should be considered the DEFAULT */
		$images = glob($dir . '*{.jpg,png,jpeg,webp}', GLOB_BRACE);

		//Uses a array randomisation function to then randomly order the glob array
		$image = array_rand($images);

		//Takes the randomly picture and creates a string that can easily inserted into css.
		$image_string = 'wallpapers/' . basename($images[$image]);
		echo $image_string;
	}

	//Deletes file from web server
	function rm_image($wallpaper){
		unlink($wallpaper);
	}

	//Checks if ID was received
	if(isset($_POST['id']) && ($_POST['id'] == "rm")) {
    	$wallpaper = $_POST['paper'];


    	//removes all unimportant parts of the received string
		$sans_chars = str_replace(str_split('"():'), '', $wallpaper);
		$important_string = substr($sans_chars, 26); //Increase number to remove more of the string, starting from the left.
		$full_string = $_SERVER['DOCUMENT_ROOT'] . $important_string;
    	rm_image($full_string);
	}

?>
