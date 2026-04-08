<?php
	class Comics {

  		function __construct() {

  		}

        /*I use a lot of basic globs to get basic directory information
        this function allows me to not repeat myself so much*/
        static function glob_it($cwd) {
            $glob_in = glob($cwd . '/*' , GLOB_ONLYDIR);
            return $glob_in;
        }

    	static function comic_list(){

    		$cwd = getcwd();

    		//Folders to exclude (monster is temporary, it was causing other issues)
    		$exclude = [$cwd . '/Monster', $cwd . '/comic_image'];

    		//removes the folders from the globbed array
    		$remove = array_diff(Comics::glob_it($cwd), $exclude);

        	foreach($remove as $filename){

            	//strips prefix from the original $filename variable
            	$filename = basename($filename);

            	//replaces any use of underscores with spaces
            	$comic = preg_replace("(_)", " ", $filename);

            	$upper_case = ucwords($comic);

			$obj = new Comics();
            	//checks if a thumbnail doesn't already exist. If it doesn't it runs functions to appropriately create one
            	if(!file_exists("../comics/comic_image/" . $filename . ".webp")) {
               		$obj->im_cr($filename, Comics::first_im($filename));
        		}

        		else {
        			echo "<a class='comic-card' href='reader.php?comic=" . $filename . "&vol='>";
        			echo "<img class='comic-card__cover' src='../comics/comic_image/" . $filename . ".webp' alt='" . htmlspecialchars($upper_case) . "'/>";
            		echo "<div class='comic-card__title'>" . htmlspecialchars($upper_case) . "</div>";
        			echo "</a>\n";
        		}
        	}
    	}

        //Image creation functions
    	static function first_im($filename){

    		$filename = array("$filename");
    		$cwd = getcwd();

    		//For every filename in the array
    		for ($i = 0; $i < sizeOf($filename); $i++) {

    	    	$dir = $cwd . '/' . $filename[$i] . "/";

 				$all_dirs = glob($dir . '*');

 				//Foreach function to fill the array with all directories for the comic
 				//This is so we can grab only the very first volume for each comic
 				foreach ($all_dirs as $file) {
 					$first_dir[] = $file;
 				}

 				//Recursively scans the very first volume for each comic and removes unnecessary results
 				$scanned_dir = scandir($first_dir[0]);

 				//Returns the full path to the first image found (array elements 0 and 1 of scanned_dir are the '..' files)
 				$full_path = $all_dirs[0] . '/' . $scanned_dir[2];
 				return $full_path;
    		}
    	}

    	//Basic image creation function with GD
    	 function im_cr($filename, $image){
    		$file_info = pathinfo($image, PATHINFO_EXTENSION);
    		$dir_im = 'null';
    		ob_start();

            //Checks file extension to decide which imagecreate function is required
           switch ($file_info) {
    			case 'webp':
    				$dir_im = imagecreatefromwebp($image);
    				break;
    			case 'jpg':
    				$dir_im = imagecreatefromjpeg($image);
    				break;
    			case 'jpeg':
    				$dir_im = imagecreatefromjpeg($image);
    				break;
    			case 'png':
    				$dir_im = imagecreatefrompng($image);
    				break;
    			default:
    				echo "error";
    				break;
    		}
        	$obj= new Comics();
        	$manipulated=$obj->im_man($image, $dir_im);

        	//Creates a webp image from provided resource
        	imagewebp($manipulated,  "../comics/comic_image/" . $filename .".webp", 100);
        	imagedestroy($manipulated);
        }

        //Function to handle image manipulation
        function im_man($image, $dir_im){
            //Gets the size of the image
            $image_size = getimagesize($image);

            //Checks which cropping template to use
            if ($image_size[0] >= 2050) {
                $cropped = imagecrop($dir_im, ['x' => ($image_size[1]/2),
                                                'y' =>0,
                                                'width' =>  ($image_size[0] / 3),
                                                'height' => ($image_size[1] /1.5)]);

                //Scales the image to an appropriate size to use as a thumbnail
                $scaled = imagescale($cropped, 300);
            }
            else{
                $cropped = imagecrop($dir_im, ['x' => ($image_size[1]/17),
                                                'y' =>0,
                                                'width' =>  (($image_size[0] / 3)*2.5),
                                                'height' => ($image_size[1] /2)]);

                //Scales the image to an appropriate size to use as a thumbnail
                $scaled = imagescale($cropped, 280);
            }

        	return $scaled;
        }


       static function validate_comic($get) {

            $glob_in = Comics::glob_it(getcwd());

       		for ($i=0; $i < count($glob_in); $i++) {
         		if(isset($get) == basename($glob_in[$i])) {
					$_SESSION['comic'] = $get;
					return $_SESSION['comic'];
                }
       		}
        }

        //Dropdown function for different volumes
        static function vol_dropdown(){

            //Sets comic directory with the session info
            $set_dir = '../comics/' . $_SESSION['comic'];

                foreach (Comics::glob_it($set_dir) as $filename) {

                    $volume = str_replace($set_dir . '/', "", $filename);

                    //Address with volume session information
                    $address = "reader.php?comic=" . $_SESSION['comic'] . "&vol=" . $volume;

                    //Sets the selected value to the user selected volume
                    if (isset($_GET['vol']) && $volume == $_GET['vol']){
                        echo "<option selected value= '" . $address . "'>" . $volume . "</option> \n";

                    }
                    else {
                        echo "<option value= '" . $address . "'>" . $volume . "</option> \n";
                    }
                }
        }

        static function page_dropdown(){
            $pages = glob(getcwd() . "/" . $_SESSION['comic'] . '/' . $_GET['vol'] . "/*.{jpg,jpeg,png,webp}", GLOB_BRACE);

            $_SESSION['page'] = substr($pages[0],29);

            for ($i=0; $i < count($pages); $i++) {

                //Removes unix prefix
                $sans_prefix = substr($pages[$i], 29);

                //If the volume is set then it sets the current page to the first page.
                if ($i == 0 && isset($_GET['vol'])) {
                    echo "<option selected value= '" . $sans_prefix . "'>" . $i+1 . "</option>\n";

                }
                else {
                    echo "<option value= '" . $sans_prefix . "'>" . $i . "</option>\n";
                }
            }
        }
    }
?>
