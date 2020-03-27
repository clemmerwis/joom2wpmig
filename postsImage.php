<?php 
error_reporting(E_ALL); 
require_once 'vendor/autoload.php';
require_once './includes.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

function createPostsImageSQL($ID, $post_author, $post_date, $post_name="'image'", $post_title="'image'", $post_content="''", $post_date_gmt="''", $post_modified="''", $post_modified_gmt="''", $post_excerpt="''", $post_status="'closed'", $comment_status="'open'", $ping_status="'closed'", $post_password="''", $to_ping="''", $pinged="''", $post_content_filtered="''", $post_parent=0, $guid="''", $menu_order=0, $post_type="'post'", $post_mime_type="''", $comment_count=0) 
{
    $post_date_gmt = $post_date;
    $post_modified = $post_date;
    $post_modified_gmt = $post_date;

    $eot = <<<EOT
    INSERT INTO `wp_posts`(`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ($ID, $post_author, $post_date, $post_date_gmt, $post_content, $post_title, $post_excerpt, $post_status, $comment_status,$ping_status, $post_password, $post_name, $to_ping, $pinged, $post_modified, $post_modified_gmt, $post_content_filtered, $post_parent, $guid, $menu_order, $post_type, $post_mime_type, $comment_count);
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
    $ID = $ID_cell->getValue();
    $parametersArr["ID"] = "'" . intval($ID) . "'";

    // Get post_author
    $postAuthor_index = getColumnIndex("post_author", $columnArr);
    $postAuthor_cell = $worksheet->getCell($postAuthor_index.strval($rowIndex), false);
    $postAuthor = $postAuthor_cell->getValue();
    $parametersArr["post_author"] = "'" . strval($postAuthor) . "'";

    // Get post_name
    $postName_index = getColumnIndex("post_name", $columnArr);
    $postName_cell = $worksheet->getCell($postName_index.strval($rowIndex), false);
    $postName = $postName_cell->getValue();
    $parametersArr["post_name"] = "'" . strval($postName) . "'";

    // Get post_title
    $postTitle_index = getColumnIndex("post_title", $columnArr);
    $postTitle_cell = $worksheet->getCell($postTitle_index.strval($rowIndex), false);
    $postTitle = $postTitle_cell->getValue();
    $parametersArr["post_title"] = "'" . strval($postTitle) . "'";

    // Get $post_content 
    $postContent_index = getColumnIndex("post_content", $columnArr);
    $postContent_cell = $worksheet->getCell($postContent_index.strval($rowIndex), false);
    if ($postContent_cell === null) 
    {
        continue;
        $helper->log($ID . $rowIndex);
    }
    $postContent = $postContent_cell->getValue();
    // Add backslashes to escape single quotes
    $postContent = str_replace("'", "\'", $postContent);
    $postContent = str_replace("_x000D_", "", $postContent);
    $postContent = str_replace("<p>{modulepos inner_text_ad}</p>", "", $postContent);
    $parametersArr["post_content"] = "'" . strval($postContent) . "'";

    // Get $post_date 
    $postDate_index = getColumnIndex("post_date", $columnArr);
    $postDate_cell = $worksheet->getCell($postDate_index.strval($rowIndex), false);
    $postDate = $postDate_cell->getValue();
    $parametersArr["post_date"] = "'" . strval($postDate) . "'";

    createPostsSQL($parametersArr["ID"], $parametersArr["post_author"], $parametersArr["post_name"], $parametersArr["post_title"], $parametersArr["post_content"], $parametersArr["post_date"]);
    echo "<br>"; 

    // Iterate to next row
    $rowIterator->next();
    $rowCurrent = $rowIterator->current();
}


$helper->log("End Time");

// eval(\Psy\sh());
// createPostsSQL($ID, $post_author, $post_name, $post_title, $post_content, $post_date);

?>