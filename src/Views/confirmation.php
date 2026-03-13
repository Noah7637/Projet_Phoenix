<?php
ob_start();

?>
<section id="confirmation">
    <div>    
        <img src="./img/turkoise.jpg" alt="turkoise">
        <span><img src="./img/Logo.png" alt="">Récapitulatif de votre réservation pour</span>
    </div>
    <div id="recap">
        <div id="jaune">
            <p>Participant(s)</p>
            <p>2</p>
            <p>Semaine(s) :</p>
            <p>3</p>
        </div>
        <div id="vert">
            <p>Commande</p>
            <p>1</p>
            <p>Total</p>
            <p>4500eu</p>
        </div>
    </div>
    <span id="span_footer">Bon séjour <img src="./img/Logo.png" alt="logo_footer"></span>

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