<?php
include 'functions.php';
session_start();
if(!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit();
}
$pdo = connect_mysql();
$msg = '';
// Check that the poll ID exists
if (isset($_GET['id'])){
	$id = $_GET['id'];
    // Select the record that is going to be deleted
    $result = $pdo->query("SELECT * FROM images WHERE id = '$id'");
	$image = $result->fetch_array();

    if (!$image) {
        die ('Image doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete file & delete record
            unlink($image['path']);
            $stmt = "DELETE FROM images WHERE id = '$id'";
            #$stmt->execute([$_GET['id']]);
			if (mysqli_query($pdo, $stmt)) {
				$msg = 'You have deleted the image!';
			}
        } else {
            // User clicked the "No" button, redirect them back to the home/index page
            header('Location: index.php');
            exit;
        }
    }
}else{
    die ('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Delete Image #<?=$image['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Are you sure you want to delete <?=$image['title']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$image['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$image['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>

