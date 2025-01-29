<?php 
session_start();
require_once('classes/actions.class.php');

// Define allowed pages for security
$allowed_pages = ['home', 'about', 'contact'];
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Sanitize page to prevent directory traversal attacks
$page = in_array($page, $allowed_pages) ? $page : 'home';

// Set page title by formatting the page name
$page_title = ucwords(str_replace("_", " ", $page));

/**
 * Displays flash messages stored in the session.
 */
function displayFlashMessage() {
    if (isset($_SESSION['flashdata']) && !empty($_SESSION['flashdata'])) {
        $flashdata = $_SESSION['flashdata'];
        $type = htmlspecialchars($flashdata['type'] ?? 'default', ENT_QUOTES, 'UTF-8');
        $msg = htmlspecialchars($flashdata['msg'] ?? '', ENT_QUOTES, 'UTF-8');

        echo <<<HTML
        <div class="flashdata flashdata-{$type} mb-3">
            <div class="d-flex w-100 align-items-center flex-wrap">
                <div class="col-11">{$msg}</div>
                <div class="col-1 text-center">
                    <a href="javascript:void(0)" onclick="this.closest('.flashdata').remove()" class="flashdata-close">
                        <i class="far fa-times-circle"></i>
                    </a>
                </div>
            </div>
        </div>
        HTML;

        // Unset flash message after displaying
        unset($_SESSION['flashdata']);
    }
}

// Helper function to include page files dynamically
function includePage($page) {
    $file = "pages/{$page}.php";
    if (file_exists($file)) {
        include_once($file);
    } else {
        include_once('pages/404.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once('inc/header.php'); ?>
<body>
    <?php include_once('inc/navigation.php'); ?>

    <div class="container-md py-3">
        <?php displayFlashMessage(); ?>

        <div class="main-wrapper">
            <?php includePage($page); ?>
        </div>
    </div>

    <?php include_once('inc/footer.php'); ?>
</body>
</html>
