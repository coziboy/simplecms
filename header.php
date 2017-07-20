<?php 
$config = "./config.php";
if (file_exists($config)) require_once($config);
else die("Config file is missing");
?>
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>

   <!--- Basic Page Needs
   ================================================== -->
	<meta charset="utf-8">
	<title><?php echo TITLE ?></title>
	<meta name="description" content="<?php echo DESCRIPTION ?>">
	<meta name="author" content="<?php echo NAME ?>">

	<!-- CSS
   ================================================== -->
	<link rel="stylesheet" href="<?php echo BASEURL.'css/main.css'?>">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/railscasts.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>
<body>
<div id="content-wrap">
<header class="container">

         <div style="position: absolute; height: 67px; width: 100%; display: block; top: 56px; left: 10px;">
            <h1 style="display: block;height: 48px;width: 100%;border: none;margin: 0;padding: 0;text-shadow: none;color: #1e83b6;"><a href="<?php echo BASEURL ?>"><?php echo TITLE ?></a></h1>
            <h6 style="height: 0;text-shadow: none;color: #8D8D96;"><?php echo DESCRIPTION ?></h6>
         </div>


         <nav id="nav-wrap" class="cf">

            <ul id="menu">
	            <li class="current"><a href="<?php echo BASEURL ?>">Home</a></li>
	            <li><a href="<?php echo BASEURL.'p/about' ?>">About</a></li>
            </ul>

         </nav>

      </header>