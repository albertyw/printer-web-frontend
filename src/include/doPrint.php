<?php
/**
This file sends a pdf to the printer

**/

// Get the variables
$inputDir = '/var/www/codes/printer/uploads_pdf/';
$inputFileName = $_GET['filename'];
if(strpos($inputFileName, '/')!==false || strpos($inputFileName,'\\')!==false){
    echo '0';
    die();
}
$inputFileNameWithoutSuffix = substr($inputFileName,0,strrpos($inputFileName,'.'));
$inputFileNameWithoutSuffix = str_replace(' ','_',$inputFileNameWithoutSuffix);
$inputFileName = $inputFileNameWithoutSuffix.'.pdf';
$printerName = $_GET['printer'];
$copies = $_GET['copies'];

//Check that the input file exists
if(file_exists($inputDir.$inputFileName)==false){
    echo '0';
    die();
}

for($i=0;$i<$copies;$i++){
    //Send the pdf to the printer
    $command = 'lpr -P '.$printerName.' '.$inputDir.$inputFileName;
    $shellOutput = shell_exec($command);
    //Wait for the printer to finish printing
    $finishedPrinting = false;
    while($finishedPrinting == false){
        sleep(2);
        $command = 'lpq -P '.$printerName;
        $shellOutput = shell_exec($command);
        if(strpos($shellOutput,'no entries')!== false){
            $finishedPrinting = true;
        }
    }
}
//Return info
echo '1';
?>
