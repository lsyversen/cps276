<?php

class Directories {
    public function createDirectory($directoryName, $fileContent) {
        $directoryPath = '/home/l/s/lsyversen/public_html/directories/' . $directoryName;

        if (file_exists($directoryPath) && is_dir($directoryPath)) {
            return "A directory already exists with that name.";
        }

        if (!mkdir($directoryPath, 0777, true)) {
            return "Error: Unable to create the directory.";
        }

        $readmePath = $directoryPath . '/readme.txt';
        if (file_put_contents($readmePath, $fileContent) === false) {
            return "Error: Unable to create the readme.txt file.";
        }

        return "Directory and readme.txt file created successfully";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["directory_name"]) && isset($_POST["content"])) {
        $directoryName = $_POST["directory_name"];
        $fileContent = $_POST["content"];
        $directories = new Directories();
        $message = $directories->createDirectory($directoryName, $fileContent);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>File and Directory Assignment</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto">
                <h1 class="text-center">File and Directory Assignment</h1>
 
                <?php
                if (isset($message)) {
                    if (strpos($message, 'A directory already exists with that name.') !== false) {
                        echo "<p class='alert alert-danger'>$message</p>";
                    } else {
                        echo "<p class='alert alert-success'>$message</p>";
                        echo "<a href='viewfile.php?dir=$directoryName&file=readme.txt' class='alert alert-info' target='_blank'>Path where file is located</a>";
                    }
                } else {
                    echo "<p class='alert alert-info'>Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>";
                }
                ?>

                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label for="folder_name">Folder Name</label>
                        <input type="text" name="directory_name" id="folder_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="file_content">File Content</label>
                        <textarea name="content" id="file_content" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>