<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>— Phoenix —</title>
    <link rel="stylesheet" href="/accueil.css">
     <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
</head>
<body>
    <header>
        <nav>
            <img src="./img/Logo.png" alt="">
            <ul>
                <li><a href="/">Phoenix</a></li>
                <li><a href="/catalogue">Choisir une destination</a></li>
                <li><a href="/confirmation">Payer</a></li>
                <li>
                <li>
                <?php 
                if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
                    echo "<a href='/logout'>déconnexion</a>";
                } else {
                    echo "<a href='/login'>se connecter</a>";
                }
                ?>
                </li>
            </ul>
        </nav>
            
    </header>
    <main>
        <section id="accueil">
             <a href="/catalogue"><button>Choisir mon séjour tout  de suite !</button></a>
        </section>
    </main>
    <footer>
        <i class="ri-sun-fill"></i>
        <p>Vos vacances de rêve... </p>
        <i class="ri-settings-5-fill"></i>        
        <p>Plage... </p>
        <i class="ri-building-fill"></i>        
        <p>Urbaine... </p>
        <i class="ri-ship-2-fill"></i>       
        <p>Croisière... </p>
        <i class="ri-image-fill"></i>
        <p>Montagne... </p>
        <i class="ri-money-euro-circle-line"></i>
        <p>A prix tout doux...</p>
        <i class="ri-sun-fill"></i>
    </footer>
</body>
</html>





