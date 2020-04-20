<?php 

require './vendor/autoload.php';
if ( isset($_POST['submit']) )
{
    // Get the uploaded file
    $jsondata = file_get_contents($_FILES['thefile']['tmp_name']);
    $ids_urls = json_decode($jsondata);
    $i = 1;
    foreach ($ids_urls as $id => $url) 
    {
        $filename = basename($url);
        // Remote file url
        $remoteFile = str_replace(" ", "%20", $url);

        // Initialize cURL
        $ch = curl_init($remoteFile);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check the response code
        if($responseCode != 200)
        {
            // $filename = basename($url);
            // $tempLocation = "C:/xampp/htdocs/tnadev/tmp/" . $filename;
            // copy($url, $tempLocation);
            echo "$i : $id<br>";
            echo "$url<br>";
            $i++;
        }
    }

    $processed = "Process Completed";
}

// $jsondata = file_get_contents("C:/Users/chris/Desktop/migAssets/json/culture/skipped/252feats.json");
// $ids_urls = json_decode($jsondata);
// if (array_key_exists($ID, $ids_urls))
// {
    
// }

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
<form method = "POST" enctype="multipart/form-data">
         <input type="file" name="thefile">
         <label for="categories">Categories</label>
         <input type="text" id="cats" name="cats">
         <input type="submit" name="submit">
</form>

<?PHP
    global $processed;
    echo isset($processed) ? $processed : "";
    echo "<br>";
?>
</body>
</html>
