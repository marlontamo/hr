<?php


class Thumbnails extends MX_Controller
{
	
	public function index($module = "")
	{
		if($module == "") $module = 'users';

		define('UPLOAD_DIR', 'uploads/'. $module . '/');
		define('UPLOAD_THUMB', 'uploads/'. $module . '/thumbnail/');

		$files = scandir(UPLOAD_DIR);
		$files_thumb = scandir(UPLOAD_THUMB);
		
		foreach ($files as $key => $file) {
			$image_path = UPLOAD_DIR.$file;
			if(@is_array(getimagesize($image_path))){
			    $image = true;
			    if(in_array($file, $files_thumb)){
			    	$image_details = getimagesize($image_path);
			    	if($image_details[0] != 45 && $image_details[1] != 45){
			    		$new = $this->createThumbnail(UPLOAD_THUMB.$file, UPLOAD_THUMB.$file, 45, 45);
			    	}
			    }else{
			    	$new = $this->createThumbnail($image_path, UPLOAD_THUMB.$file, 45, 45);

			    }	    
			} 
		}

		 echo 'image thumbnail';
	}


	function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_path = $version.'/';
        }
        return UPLOAD_DIR.$version_path.$file_name;
    }

	function createThumbnail($filepath, $thumbpath, $thumbnail_width, $thumbnail_height) {
	    list($original_width, $original_height, $original_type) = getimagesize($filepath);
	    if ($original_width > $original_height) {
	        $new_width = $thumbnail_width;
	        $new_height = intval($original_height * $new_width / $original_width);
	    } else {
	        $new_height = $thumbnail_height;
	        $new_width = intval($original_width * $new_height / $original_height);
	    }
	    $dest_x = intval(($thumbnail_width - $new_width) / 2);
	    $dest_y = intval(($thumbnail_height - $new_height) / 2);
	    
	    if ($original_type === 1) {
	        $imgt = "ImageGIF";
	        $imgcreatefrom = "ImageCreateFromGIF";
	    } else if ($original_type === 2) {
	        $imgt = "ImageJPEG";
	        $imgcreatefrom = "ImageCreateFromJPEG";
	    } else if ($original_type === 3) {
	        $imgt = "ImagePNG";
	        $imgcreatefrom = "ImageCreateFromPNG";
	    } else {
	        return false;
	    }
	    
	    $old_image = $imgcreatefrom($filepath);
	    $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
	    imagecopyresampled($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
	    $imgt($new_image, $thumbpath);
	    
	    return file_exists($thumbpath);
	}


}
/* End of file */
/* Location: system/application */
