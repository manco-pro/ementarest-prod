<?php

use Verot\Upload\Upload;

require_once getLocal('VENDOR') . 'php-upload-files/class.upload.php';

//$img = base64 string img
//
function UploadImages($img, $folder = '', $file_name = '', $ext='jpeg') {
    // we create an instance of the class, giving as argument the data string


    $handle = new Upload($img);

    // check if a temporary file has been created with the file data
    if ($handle->uploaded) {
        $handle->image_convert      = 'webp';
        $handle->webp_quality          = 80;
        $handle->file_new_name_body = $file_name;
        $handle->file_new_name_ext  = $ext;

        $handle->process(getLocal('IMAGES') . $folder);
        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !

            $handle->clean();
            return true;
        } else {
            // one error occured
            return false;
            //$handle->error ;
        }

        // we delete the temporary files
    } else {
        // if we're here, the file failed for some reasons
        return false;
        //$handle->error . '';
    }
}
function UploadImagesLoja($img, $folder = '', $file_name = '', $ext='jpeg') {
    // we create an instance of the class, giving as argument the data string


    $handle = new Upload($img);

    // check if a temporary file has been created with the file data
    if ($handle->uploaded) {
        
        $handle->file_new_name_body = $file_name;
        $handle->file_new_name_ext  = $ext;

        $handle->process(getLocal('IMAGES') . $folder);
        // we check if everything went OK
        if ($handle->processed) {
            // everything was fine !

            $handle->clean();
            return true;
        } else {
            // one error occured
            return false;
            //$handle->error ;
        }

        // we delete the temporary files
    } else {
        // if we're here, the file failed for some reasons
        return false;
        //$handle->error . '';
    }
}

/**
 * Deletes an image file from the specified folder.
 *
 * @param string $nameIMG The name of the image file to delete.
 * @param string $folder The folder where the image file is located.
 * @return bool Returns true if the image file is successfully deleted, false otherwise.
 */
function DeleteIMG($nameIMG, $folder) {
     
    $path_to_file = $folder.$nameIMG;
      
    if (file_exists($path_to_file)) {
        if (unlink($path_to_file)) {
            return true;
        } else {
            return false;
        }
    } else {
        
        return false;
    }
}





