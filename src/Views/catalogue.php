<section id="catalogue">
    <img class="turkoiseImg" src="./img/turkoise.jpg" alt="turkoise">
        <article class="sectionCata">

            <?php
            if (isset($travels) && !empty($travels)) {
               foreach ($travels as $travel) {
                    ?>
                    <div class="divGridCata">
                        <img class="imgGridCata" src="./img/<?= escape($travel->getImage()) ?>" alt="">
                        <div class="infoCardCata">
                                <h2><?php echo escape($travel->getName()); ?></h2>
                                <p><?= escape($travel->getDescription()) ?></p>
                                <a class="lienCata" href="/reservation"><button class="btnReserver">Réserver maintenant !</button></a>
                        </div>                             
                    </div>
                       
                    
                    <?php
                }
            } else {
                echo "pas de voyages disponibles pour le moment";
            }
            ?>
        </article>
</section>