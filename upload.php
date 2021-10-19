<html>
<head>
<title>Upload File</title>
</head>
<body>
<?php
require "Clamav.php";
$clamav = new Clamav(['clamd_sock' => '/var/run/clamav/clamd.ctl']);
if (isset($_POST['upload'])) {
    $fileName = $_FILES['userfile']['name'];
    $tmpName = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];
    $tmpPath = "/home/student/files/";
    $filePath = "/var/www/html/files/";
    $result = move_uploaded_file($tmpName, $tmpPath.$fileName);
    if (!$result) {
        error_log($result);
        die("Error uploading file $tmpName");
    }
    if (!get_magic_quotes_gpc()) {
        $fileName = addslashes($fileName);
        $filePath = addslashes($filePath);
    }
    if (!$clamav->scan($tmpPath.$fileName)) {
        error_log($clamav->getMessage());
        unlink($tmpPath.$fileName);
        die("File bervirus");
    }
    $result = rename($tmpPath.$fileName, $filePath.$fileName);
    if (!$result) {
        error_log($result);
        die("Error uploading file $fileName");
    }
    echo "<br>File $fileName uploaded<br>";
}
?>
<form method="post" enctype="multipart/form-data" name="uploadform">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
<tr>
<td width="246">
<input type="hidden" name="MAX_FILE_SIZE" value="2000880">
<input name="userfile" type="file" class="box" id="userfile">
</td>
<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
</tr>
</table>
</form>
</body>
</html>
