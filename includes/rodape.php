<?php
$result = $conn->query("SELECT * FROM contato WHERE id = 1");
$contato = $result->fetch_assoc() ?: [
    'email' => 'seuemail@exemplo.com',
    'celular' => '(00) 00000-0000',
    'linkedin' => '#',
    'github' => '#'
];
?>

<!-- Contact -->
<section id="contact">
    <div class="inner">
    <section>
    <form method="post" action="sistema/config/enviarEmail.php">
        <div class="fields">
            <div class="field half">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" required />
            </div>
            <div class="field half">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required />
            </div>
            <div class="field">
                <label for="message">Mensagem</label>
                <textarea name="message" id="message" rows="6" required></textarea>
            </div>
        </div>
        <ul class="actions">
            <li><input type="submit" value="Enviar" class="primary" /></li>
            <li><input type="reset" value="Limpar" /></li>
        </ul>
    </form>
</section>

        <section class="split">
            <section>
                <div class="contact-method">
                    <span class="icon solid alt fa-envelope"></span>
                    <h3>E-mail</h3>
                    <a href="mailto:<?php echo htmlspecialchars($contato['email']); ?>"><?php echo htmlspecialchars($contato['email']); ?></a>
                </div>
            </section>
            <section>
                <div class="contact-method">
                    <span class="icon solid alt fa-phone"></span>
                    <h3>Contato</h3>
                    <span><?php echo htmlspecialchars($contato['celular']); ?></span>
                </div>
            </section>
            <section>
    <div class="contact-method">
        <span class="icon brands alt fa-linkedin-in"></span>
        <h3>LinkedIn</h3>
        <p>Acesse meu <a href="<?php echo htmlspecialchars($contato['linkedin']); ?>" target="_blank">LinkedIn</a></p>
    </div>
</section>

        </section>
    </div>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <ul class="icons">
            <li><a href="https://wa.me/55<?php echo preg_replace('/[^0-9]/', '', $contato['celular']); ?>?text=" target="_blank" class="icon brands alt fa-brands fa-whatsapp"><span class="label">WhatsApp</span></a></li>
            <li><a href="<?php echo htmlspecialchars($contato['github']); ?>" target="_blank" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
            <li><a href="<?php echo htmlspecialchars($contato['linkedin']); ?>" target="_blank" class="icon brands alt fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
        </ul>
    </div>
</footer>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>

</html>