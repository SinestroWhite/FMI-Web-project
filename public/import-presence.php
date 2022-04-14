<?php
    require_once("../headers/main.php");
?>
<html>
    <head>
        <title>Import Presence</title>
    </head>
    <body>
   <section class="data-section">
        <h1>Импортиране на присъсъствен списък</h1>
        <!-- TODO: add CSRF filed -->
        <form action="import-presence.php" method="post" enctype="multipart/form-data">
            <input type="file" name="presence_list">
            <input type="submit" value="Качване" name="import"/>
        </form>
   </section>

   <a href="logout.php">Logout</a>

  </body>
</html>


<?php
if (isset($_POST["import"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $filename = $_FILES['presence_list']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if ($ext != "txt") {
        throw new InvalidFileFormatError();
    }

    if ($_FILES["presence_list"]["size"] > 500000) {
        throw new FileTooLargeError();
    }

    if (move_uploaded_file($_FILES["presence_list"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["presence_list"]["name"])). " has been uploaded.";
    } else {
        throw new FileUploadError();
    }
}

?>

