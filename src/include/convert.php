<?php
/**
This file converts a file to pdf

**/

// Get the variables
$inputDir = '/var/www/codes/printer/uploads/';
$printerDir = '/home/albertyw/PDF/';
$outputDir = '/var/www/codes/printer/uploads_pdf/';
$inputFileName = $_GET['filename'];
if(strpos($inputFileName, '/')!==false || strpos($inputFileName,'\\')!==false){
    echo '0';
    die();
}
$inputFileNameWithoutSuffix = substr($inputFileName,0,strrpos($inputFileName,'.'));
$inputFileNameWithoutSuffix = str_replace(' ','_',$inputFileNameWithoutSuffix);
$outputFileName = $inputFileNameWithoutSuffix.'.pdf';

//Check that the uploaded file exists
if(file_exists($inputDir.$inputFileName)==false){
    echo '0';
    die();
}
rename($inputDir.$inputFileName,$outputDir.$outputFileName);
echo '1';
die();






if(strtolower(substr($inputFileName,-4)) == '.pdf'){
    //Copy file directly if already pdf
    copy($inputDir.$inputFileName,$outputDir.$outputFileName);
}else{
    //Send through PdfPrinter
    $command = "lpr -P PdfPrinter '".$inputDir.$inputFileName."'";
    $shellOutput = shell_exec($command);
    if(file_exists($printerDir.$outputFileName)==false){
        echo '0';
        die();
    }
    //Copy printer's outputted file to correct location
    rename($printerDir.$outputFileName,$outputDir.$outputFileName);
}

//Delete uploaded file
unlink($inputDir.$inputFileName);

//Check that converted file exists
if(file_exists($outputDir.$outputFileName)==false){
    echo '0';
    die();
}

//Return info
echo '1';

?>
