<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Candidate Match{if $title} - {$title}{/if}</title>
  
  <!-- Meta Ownership -->
  <meta name="description" content="Candidate Match System">
  <meta name="author" content="Andrew Benfield, Ben Thurlow, Elliot Adderton, Garlen Saldanha">
  <!-- Meta Style and Compatible -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="initial-scale=1">

  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
</head>

<body>

<header>
	<h1>Candidate Match</h1>
	<nav>
		<a href="./">Home</a>
		<a href="./voters.php">Voters</a>
		{if isset($session)}<a href="./dashboard.php" class="current">Dashboard</a>
		<a href="./logout.php">Logout</a>{else}<a href="./login.php">Candidate Login</a>{/if}
	</nav>
</header>
