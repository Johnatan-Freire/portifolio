<!DOCTYPE HTML>
<!--
	Forty by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->

<?php
include('cabecalho.php');
$query = "SELECT nome, imagem, descricao, tecnologias, repositorio, privado, link_projeto FROM projetos";
$result = $conn->query($query);
?>
<!-- Banner -->
<section id="banner" class="major">
	<div class="inner">
		<header class="major">
			<h1>Projetos</h1>
		</header>
		<div class="content">
			<p>Portfólio feito com template <a href="https://html5up.net/forty">HTML5 UP</a>, PHP 8 e MySQL</p>
			<ul class="actions">
				<li><a href="https://github.com/Johnatan-Freire/portifolio" target="_blank" class="button next scrolly">Repositório</a></li>
			</ul>
		</div>
	</div>
</section>

<!-- Main -->
<div id="main">

	<!-- One -->
	<section id="one" class="tiles">
		<?php while ($row = $result->fetch_assoc()): ?>
			<article <?php if (!empty($row['link_projeto'])): ?> onclick="window.location.href='<?php echo htmlspecialchars($row['link_projeto']); ?>';" <?php endif; ?> style="cursor: pointer;">
				<span class="image">
					<img src="sistema/<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem do projeto" />
				</span>
				<header class="major">
					<h3><?php echo htmlspecialchars($row['nome']); ?></h3>
					<p class="descricao"><?php echo htmlspecialchars($row['descricao']); ?></p>
					
					<div class="tecnologia">
						<?php if (!empty($row['tecnologias'])): ?>
							<?php foreach (explode(',', $row['tecnologias']) as $tech): ?>
								<span class="tecnologias"> <?php echo htmlspecialchars(trim($tech)); ?> </span>
							<?php endforeach; ?>
						<?php else: ?>
							<span class="tecnologias">Não informado</span>
						<?php endif; ?>
					</div>
					<ul class="actions">
						<li>
							<a href="<?php echo htmlspecialchars($row['repositorio']); ?>" target="_blank" class="button next scrolly">
								<?php if ($row['privado'] == 1): ?>
									<i class="fas fa-lock"></i> Repositório Privado
								<?php else: ?>
									Ver Repositório
								<?php endif; ?>
							</a>
						</li>
					</ul>
				</header>
			</article>
		<?php endwhile; ?>
	</section>

	<!-- Two -->
	<section id="two">
		<div class="inner">
			<header class="major">
				<h2>Transforme sua ideia em realidade</h2>
			</header>
			<p>Precisa de um site ou sistema personalizado? Estou aqui para ajudar! Com experiência em HTML, CSS, PHP, Laravel, Vue.js, Java e Spring Boot, posso criar a solução perfeita para você. Entre em contato comigo para dar vida ao seu projeto!</p>
		</div>
	</section>
</div>
<?php include('rodape.php'); ?>
