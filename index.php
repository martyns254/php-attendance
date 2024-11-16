<?php 
session_start();
require_once('classes/actions.class.php');

// Define allowed pages for security
$allowed_pages = ['home', 'about', 'contact'];
$page = $_GET['page'] ?? 'home';
$page = in_array($page, $allowed_pages) ? $page : 'home';

$page_title = ucwords(str_replace("_", " ", $page));

/**
 * Displays flash messages stored in the session.
 */
function displayFlashMessage() {
    if (isset($_SESSION['flashdata']) && !empty($_SESSION['flashdata'])) {
        $type = htmlspecialchars($_SESSION['flashdata']['type'] ?? 'default', ENT_QUOTES, 'UTF-8');
        $msg = htmlspecialchars($_SESSION['flashdata']['msg'] ?? '', ENT_QUOTES, 'UTF-8');
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
        unset($_SESSION['flashdata']);
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
            <?php 
            $file = "pages/{$page}.php";
            include_once(file_exists($file) ? $file : 'pages/404.php'); 
            ?>
        </div>
    </div>
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
