<?php
class Directories {
    public function createDirectoryAndFile($directoryName, $content) {
        $directoryPath = "/home/l/s/lsyversen/public_html/directories/$directoryName";

        if (file_exists($directoryPath)) {
            return "A directory already exists with that name.";
        }

        if (!mkdir($directoryPath, 0777, true)) {
            return "Failed to create the directory.";
        }

        $file = fopen("$directoryPath/readme.txt", "w");

        if (!$file) {
            return "Failed to create the file.";
        }

        fwrite($file, $content);
        fclose($file);

        return "Directory and file created successfully.";
    }
}
?>