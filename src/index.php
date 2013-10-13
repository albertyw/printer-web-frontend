<?php require("/var/www/codes/printer/header.php"); ?>
<?php
//Collect variables
require("/var/www/codes/printer/allowed_users.php");
$uploaddir = '/var/www/codes/printer/uploads/';
if(isset($_POST['copies'])){
    $copies = (int)$_POST['copies'];
}else{
    $copies = 0;
}

echo 'Hello '.$username;
?>

<form enctype="multipart/form-data" action="index.php" method="POST" id="submitform">
    <table>
    <tr><td>
    Select File to Print:</td><td><input name="userfile" type="file" /> (Max 10 MB)
    </td></tr>
    <tr><td>
    Select a Printer:</td><td>
    <select name="printer">
    <option value="MacG_F323">F323</option>
    </select>
    </td></tr>
    <tr><td>
    Number of copies:</td><td><input type = "text" name="copies" id="copies" value = "1" size = "3">
    <span id="badNumCopies">Please enter an integer between 1 and 10</span>
    </td></tr>
    </table>
    <input type="submit" value="Print" id ="printSubmit" />
</form>
<script type="text/javascript">
$('#copies').keyup(function() {
    var numCopies = $("#copies").val();
    checkNumeric(numCopies);
});
</script>

<?php
if (isset($_FILES['userfile'])){
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    if ($copies > 10 || $copies < 1){
        echo 'You can only print between 1 and 10 files at a time.<br />';
        require('/var/www/codes/printer/footer.php');
        die();
    }
    echo "Attempting to print ".$_POST["copies"]." copies of ".$_FILES['userfile']['name']." to ".$_POST["printer"]."<br><br>";
    $fileUploadReady = move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
    if ($fileUploadReady) {
        echo "File has been uploaded.  Converting to PDF...<br /><br />";
        ?>
        <script type = "text/javascript">
        $(document).ready(function(){
            var fileName='<?php echo basename($uploadfile); ?>';
            var printerName = '<?php echo $_POST["printer"]; ?>';
            var numCopies = '<?php echo $copies; ?>';
            var convertFileReady = convertFile(fileName);
            if(convertFileReady) doPrint(fileName, printerName, numCopies);
        });
        </script>
        <?php
    } else {
        echo "File upload failed.  Please make sure that the file is less than 10 MB<br />";
    }
}
?>
<div id="pdfConversionSuccess">Convert To PDF Success.  Printing...</div>
<div id="pdfConversionFail">Convert To PDF Failure (Try converting your printouts to pdfs yourself)</div>
<br /><br />
<div id="printSuccess">Print succeeded</div>
<div id="printFail">Print failed (maybe I want more paper?)</div>


<?php require("/var/www/codes/printer/footer.php"); ?>
