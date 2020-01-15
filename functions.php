<?php
function connect_mysql() {
	//connection info.
	$DATABASE_HOST = 'localhost';
	$DATABASE_USER = 'root';
	$DATABASE_PASS = '';
	$DATABASE_NAME = 'phpgallery';
	//connect using the info above.
	$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	if (mysqli_connect_errno()) {
		// If there is an error with the connection, stop the script and display the error.
		die ('Failed to connect to MySQL: ' . mysqli_connect_error());
	}else{
		return $con;
	}

}

// Template header, feel free to customize this
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Gallery System</h1>
            <a href="index.php"><i class="fas fa-image"></i>Gallery</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    	</div>
    </nav>
EOT;
}

// Template footer
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>