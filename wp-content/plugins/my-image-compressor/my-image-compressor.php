<?php
/*
Plugin Name: My Image Compressor
Description: Automatically compress JPEG/PNG images when uploaded to the Media Library.
Version: 1.0
Author: Nilma Abbas
*/

// Hook into WordPress' file upload process
add_filter('wp_handle_upload', 'mic_compress_uploaded_image');

/**
 * Compresses images after they're uploaded through the WordPress Media Library.
 *
 * @param array $upload Array containing details about the uploaded file.
 * @return array Modified $upload array with updated file path/URL if image was compressed.
 */
function mic_compress_uploaded_image($upload) {
    // Get the full server path to the uploaded file
    $file_path = $upload['file'];

    // Get the file extension and make it lowercase (e.g., "JPG" becomes "jpg")
    $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

    // Define compression quality (0 = worst, 100 = best)
    $quality = 75;

    // Check the file type and apply appropriate compression
    switch ($file_type) {
        case 'jpg':
        case 'jpeg':
            // Load the JPEG image into memory
            $image = imagecreatefromjpeg($file_path);

            // Re-save the image with lower quality to compress it
            imagejpeg($image, $file_path, $quality);
            break;

        case 'png':
            // Load the PNG image into memory
            $image = imagecreatefrompng($file_path);

            // Convert PNG to JPEG to apply lossy compression
            $converted_path = preg_replace('/\.png$/', '.jpg', $file_path);

            // Save the converted image as a JPEG with lower quality
            imagejpeg($image, $converted_path, $quality);

            // Delete the original PNG file to avoid confusion
            unlink($file_path);

            // Update the file path and URL in the $upload array
            $upload['file'] = $converted_path;
            $upload['url'] = str_replace('.png', '.jpg', $upload['url']);
            break;

        default:
            // If it's not a supported image type, do nothing and return original info
            return $upload;
    }

    // Free up server memory used by the image resource
    if (isset($image)) {
        imagedestroy($image);
    }

    // Return the modified upload data so WordPress uses the compressed image
    return $upload;
}