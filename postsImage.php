<?php 
error_reporting(E_ALL); 
require_once 'vendor/autoload.php';
require_once './includes.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

function createPostsImageSQL($post_author, $post_date, $post_name, $post_parent, $guid, $post_title="''", $post_content="''", $post_date_gmt="''", $post_modified="''", $post_modified_gmt="''", $post_excerpt="''", $post_status="'inherit'", $comment_status="'open'", $ping_status="'closed'", $post_password="''", $to_ping="''", $pinged="''", $post_content_filtered="''", $menu_order=0, $post_type="'attachment'", $post_mime_type="'image/jpeg'", $comment_count=0) 
{
    $post_date_gmt = $post_date;
    $post_modified = $post_date;
    $post_modified_gmt = $post_date;

    $post_title = $post_name;

    $eot = <<<EOT
    INSERT INTO `wp_posts`(`post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ($post_author, $post_date, $post_date_gmt, $post_content, $post_title, $post_excerpt, $post_status, $comment_status,$ping_status, $post_password, $post_name, $to_ping, $pinged, $post_modified, $post_modified_gmt, $post_content_filtered, $post_parent, $guid, $menu_order, $post_type, $post_mime_type, $comment_count);
    EOT;

    file_put_contents("output.txt", $eot);
}

// Script Start
// ------------

// Create helper for logging messages to the terminal
$helper = new Sample();
$helper->log("Start Time");

// Get excel file
$inputFileName = Get_the_filename("newpoliticsContent.xlsx");

// Load spreadsheet
$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(true); 
$reader->setReadEmptyCells(false);
$spreadsheet = $reader->load($inputFileName);
$worksheet = $spreadsheet->getSheet(0);

// Get highest row and column that contains data
$lastColumn = $worksheet->getHighestDataColumn();
$lastRow = $spreadsheet->getActiveSheet()->getHighestDataRow();

// Get column iterator and set current column
$columnIterator = $worksheet->getColumnIterator("A", $lastColumn);
$columnCurrent = $columnIterator->current();
// Create column arr
$columnArr = createColumnArr($columnIterator, $worksheet, $lastColumn);

// Get row iterator and set current row
$rowIterator = $worksheet->getRowIterator(2, $lastRow);
$rowCurrent = $rowIterator->current();

// Create array to collect SQL parameters
$parametersArr = array();

// Get vars for sql statement
while (!($rowCurrent->getRowIndex() > $lastRow)) 
{
    // Get row for loop
    $rowIndex = $rowCurrent->getRowIndex();
    
    // Get ID
    $ID_index = getColumnIndex("ID", $columnArr);
    $ID_cell = $worksheet->getCell($ID_index.strval($rowIndex), false);
    $poast_parent = $ID_cell->getValue();
    $parametersArr["post_parent"] = "'" . intval($post_parent) . "'";

    // Get post_author
    $postAuthor_index = getColumnIndex("post_author", $columnArr);
    $postAuthor_cell = $worksheet->getCell($postAuthor_index.strval($rowIndex), false);
    $postAuthor = $postAuthor_cell->getValue();
    $parametersArr["post_author"] = "'" . strval($postAuthor) . "'";

    // Get $post_date 
    $postDate_index = getColumnIndex("post_date", $columnArr);
    $postDate_cell = $worksheet->getCell($postDate_index.strval($rowIndex), false);
    $postDate = $postDate_cell->getValue();
    $parametersArr["post_date"] = "'" . strval($postDate) . "'";

    createPostsSQL($parametersArr["post_author"], $parametersArr["post_date"], $parametersArr["post_parent"]);
    echo "<br>";   

    // Iterate to next row
    $rowIterator->next();
    $rowCurrent = $rowIterator->current();
}


$helper->log("End Time");

// eval(\Psy\sh());
// createPostsSQL($ID, $post_author, $post_name, $post_title, $post_content, $post_date);

?>