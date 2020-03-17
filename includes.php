<?php 
use PhpOffice\PhpSpreadsheet\Helper\Sample;

$authors_dict = array(
    63 => 'Thomas R. Eddlem',
    64 => 'William F. Jasper',
    66 => 'Birch Staff',
    67 => 'Kurt Williamsen',
    68 => 'Alex Newman',
    69 => 'James Heiser',
    71 => 'Bonnie Gillis',
    72 => 'Birch Staff',
    73 => 'Bruce Walker',
    75 => 'Christian Gomez',
    76 => 'Michael Tennant',
    78 => 'Warren Mass',
    46 => 'Gary Benoit',
    80 => 'Katie Carder',
    81 => 'Kelly Holt',
    84 => 'Thomas R. Eddlem',
    85 => 'Larry Greenley',
    86 => 'My Garden Path',
    87 => 'John F. McManus',
    88 => 'Charles Scaliger',
    90 => 'R. Cort Kirkwood',
    92 => 'Bill Hahn',
    93 => 'Birch Staff',
    96 => 'Kurt Hyde',
    97 => 'Beverly K. Eakman',
    98 => 'Eric Egan',
    100 => 'Bob Confer',
    102 => 'Jack Kerwick, Ph.D.',
    104 => 'T. Dan Tolleson',
    105 => 'Birch Staff',
    106 => 'Jack Kenny',
    107 => 'Melissa Burns',
    108 => 'Birch Staff',
    110 => 'Joe Wolverton, II',
    45 => 'Warren Mass',
    115 => 'Julie Dufrane',
    118 => 'Mary Hare',
    51 => 'Bob Adelmann',
    58 => 'Dave Bohon',
    131 => 'Julie Hays',
    77 => 'Sam Blumenfeld',
    70 => 'Rebecca Terrell',
    59 => 'Raven Clabough',
    10410 => 'John K Taylor',
    225 => 'Frank Koch',
    15477 => 'Patrick J. Buchanan',
    15482 => 'James Murphy',
    15483 => 'Mary Elise Dugan',
    15485 => 'James Donlon',
    15486 => 'Arthur R. Thompson',
    13437 => 'Laura Harding',
    15491 => 'Luis Miguel',
    1347 => 'Coop',
    59 => 'Raven Clabough',
    79 => 'Brian Koenig',
    3727 => 'Birch Staff',
    5699 => 'Birch Staff',
    5829 => 'Kevin Scholl',
    99 => 'Laurence Vance',
    50 => 'Kurt Williamsen',
    52 => 'Joe Wolverton, II, J.D.',
    49 => 'Selwyn Duke',
    42 => 'Super User',
    53 => 'William F. Jasper',
    15470 => 'Kristin Stockheimer',
    57 => 'Bill Hahn',
    56 => 'R. Cort Kirkwood',
    54 => 'Jack Kenny',
    9286 => 'John Larabell',
    9314 => 'Thomas Sowell',
    48 => 'Steven J. DuBord',
    10309 => 'Tom DeWeese',
    10310 => 'Walter E. Williams',
    11067 => 'Mitch',
    13787 => 'Eric',
    47 => 'jkelly',
    10876 => 'Mallory',
    10997 => 'Duke',
    13154 => 'jbujanowski',
    15465 => 'Ron',
    15471 => 'Clinton Alexander',
    5811 => 'Bobby',
    15468 => 'Lisa Shaw',
    15472 => 'Robert Brown',
    15473 => 'Walter McLaughlin',
    15239 => 'Steve Byas',
    15241 => 'C. Mitchell Shaw',
    15242 => 'Author1',
    15469 => 'Constance McDaniel'
);

function createUserLogin($name)
{
    // get last name
    $explosion = explode(' ', $name);
    $login = end($explosion);
    return $login;
}

function generatePassword() 
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $special = '!@#$%^&*';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    $specLength = strlen($special) - 1;
    for ($i = 0; $i < 8; $i++) 
    {
        $n = rand(0, $alphaLength);
        $s = rand(0, $specLength);
        $full = $alphabet[$n].$special[$s];
        $pass[] = $full;
    }
    return implode($pass); //turn the array into a string
}

function Get_the_filename($filename=null)
{
    $helper = new Sample();
    if (!isset($filename))
    {
        // $val will return false if no arg is passed
        $val = getopt("p:");
        if ($val) 
        {
            print_r($val);
        }
        else 
        {
            $helper->isCli() ? $helper->log('Enter file name as parameter') : die();
            $filename = trim(fgets(STDIN, 1024));
        } 
        $filename = isset($filename) ? $filename : $val["p"];
    }
    $inputFileName = 'C:\Users\clemmer\Desktop\migAssets\\'.$filename;
    return $inputFileName;
}

?>