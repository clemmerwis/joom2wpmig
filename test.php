<?php 

require './vendor/autoload.php';

$remoteImage = "https://www.thenewamerican.com/media/k2/items/cache/1973f6de3f89f571585cddf8c7407339_M.jpg";
$imginfo = getimagesize($remoteImage);
$basename = basename($remoteImage);
// header("Content-type: {$imginfo['mime']}");
$upload = wp_upload_bits($basename, null, $imginfo['bits']);

if ( isset($_POST['submit']) ) {
    $upload = wp_upload_bits($basename, null, $imginfo['bits']);
     
    $post_id = YOUR_POST_ID; //set post id to which you need to set post thumbnail
    $filename = $upload['file'];
    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $post_id, $attach_id );
}

// eval(\Psy\sh());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        Select image to upload:
        <input type="file" name="image">
    </div>
    <div class="form-group" style="margin-top:20px;">
        <input type="submit" name="submit" value="submit">
    </div>
</form>

    
</body>
</html>
