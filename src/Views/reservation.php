<?php
ob_start();

?>
<section id="reservation">  
    <img src="./img/maurice.jpg" alt="maurice">
    <article id="main_reservation">
        <div id="card">
            <img src="./img/caraibes_martinique_boucaniers.jpg" alt="">
            <div>
                <h2>Les Boucaniers</h2>
                <p>1 semaine / personne : 750eu</p>
            </div>
        </div>
        <div id="div_form">
            <span id="span_header">Je complète mes informations de réservations <img src="./img/Logo.png" alt=""></span>
            <form action="/confirmation" type="submit">
                <input type="email" placeholder="Email de confirmation" name="email">
                <span id="span_footer"><input type="number" placeholder="Je pars combien de semaines ?" name="nbr_semaine">
                <input type="number" placeholder="Nombre de vacancier" name="nbr_personne"></span>
                <button type="submit">Confirmer ma réservation</button>
            </form>
        </div>
    </article>
        <div class="images_footer">
            <img src="./img/caraibes_martinique_boucaniers.jpg" alt="">
            <img src="./img/sicile_kamarina.jpg" alt="">
            <img src="./img/maldives_fino.jpg" alt="">
            <img src="./img/maurice_albion.jpg" alt="">
            <img src="./img/maldives_kani.jpg" alt="">
            <img src="./img/grece_gregolimano.jpg" alt="">
        </div>
</section>


<?php

$content = ob_get_clean();
require VIEWS . 'layout.php';