<?php 
error_reporting(E_ALL); 
require_once 'vendor/autoload.php';
require_once './includes.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Helper\Sample;

function createPostsSQL($ID, $post_author, $post_name, $post_title, $post_content, $post_date="''", $post_date_gmt="''", $post_modified="''", $post_modified_gmt="''", $post_excerpt="''", $post_status="'publish'", $comment_status="'open'", $ping_status="'open'", $post_password="''", $to_ping="''", $pinged="''", $post_content_filtered="''", $post_parent=0, $guid="''", $menu_order=0, $post_type="'post'", $post_mime_type="''", $comment_count=0) 
{
    $post_date = "'" . date("Y-m-d H:i:s") . "'";
    $post_date_gmt = $post_date;
    $post_modified = $post_date;
    $post_modified_gmt = $post_date;

    echo <<<EOT
    INSERT INTO `wp_posts`(`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES ($ID, $post_author, $post_date, $post_date_gmt, $post_content, $post_title,$post_excerpt, $post_status, $comment_status,$ping_status, $post_password, $post_name, $to_ping, $pinged, $post_modified, $post_modified_gmt, $post_content_filtered, $post_parent, $guid, $menu_order, $post_type, $post_mime_type, $comment_count);
    EOT;
}

// Script Start
// ------------

// Create helper for logging messages to the terminal
$helper = new Sample();
$helper->log("Start Time");

// Get excel file
$inputFileName = Get_the_filename("politicsContent.xlsx");

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

// Get row iterator and set current row
$rowIterator = $worksheet->getRowIterator(1, $lastRow);
$rowCurrent = $rowIterator->current();


// Loop columns to find ID column
$i = 0;
while (true)
{
    // Get cell, false = do not create new cell if cell does not exist
    $colLetter = $columnCurrent->getColumnIndex();
    $cell = $worksheet->getCell($colLetter."1", false);
    $cellvalue = strval($cell->getValue());

    if ($cellvalue === "ID") {
        # code...
    }
    // while (!($rowCurrent->getRowIndex() > $lastRow)) 
    // {
    //     $colLetter = "A";
    //     $rowIndex = $rowCurrent->getRowIndex();
    //     $cell = $worksheet->getCell($colLetter.strval($rowIndex), false);
    //     $cellvalue = strval($cell->getValue());

    //     $helper->log($i . " : " . $cellvalue);

    //     // Iterate to next row
    //     $rowIterator->next();
    //     $rowCurrent = $rowIterator->current();
    //     $i++;
    // }

    $helper->log($colLetter . " " . $cellvalue);

    // Iterate to next column
    $columnIterator->next();
    $columnCurrent = $columnIterator->current();

    // Break if on column P (last column)
    if ($colLetter === $lastColumn) 
    {
        break;    
    }
}

$helper->log("End Time");

// eval(\Psy\sh());
// createPostsSQL($ID, $user_login, $user_pass, $display_name);

?>