    <footer class="bg-primary">
        <section id="footer">
            <!--Bas de page-->
            <article id="basdepage">
                <p class="retour_haut pb-3 text-center">
                    <a href="#haut"><i class="fa fa-arrow-circle-up fa-3x pt-3"></i></a>
                </p>
            
                <p id="bas" class="text-center py-3 mb-0"><em>© 2021 Lokisalle - Site factice - Projet Ifocop</em> | <em><a href="/pages/ml.php">Mentions Légales</a></em> | <em><a href="/pages/cgv.php">
        C.G.V.</a></em> | <em><a href="/pages/pds.php">
       Plan du site</a></em> | <em>
       <i class="fa fa-print fa-2x"></i></em> | <?php if(internauteEstConnecte()) echo '<em><a href="/pages/newsletter.php">
        S\'inscrire à la newsletter</a></em> | ';?><?php if(!internauteEstConnecteEtEstAdmin()) echo '<em><a href="/pages/contact.php">
        Contact</a></em>';?>
                </p>

            </article>
        </section>
    </footer>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    <script src="/inc/js/ajax.js"></script>
</body>
</html>