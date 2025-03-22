<?php
ob_start();

require_once('config/conexao.php');
require_once('../../includes/verificaLogin.php');

$query = "SELECT * FROM projetos ORDER BY data_criacao DESC";
$result = $conn->query($query);
?>

<html>

<head>
	<title>Portifólio</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="../assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="../assets/css/noscript.css" />
	</noscript>
</head>

<body class="is-preload">
	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<a href="index.php" class="logo"><strong>Portifólio</strong> <span>ADMINISTRADOR</span></a>
			<nav>
				<a href="#menu">Menu</a>
			</nav>
		</header>

		<!-- Menu -->
		<nav id="menu">
			<ul class="links">
				<li><a href="projetos.php">Projetos</a></li>
				<li><a href="contato.php">Curriculo e Contatos</a></li>
			</ul>
			<ul class="actions stacked">
				<li><a href="../logout.php" class="button fit">Sair</a></li>
			</ul>
		</nav>