<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Team</title>
    <link rel="stylesheet" href="../css/styleEquipe.css">
</head>
<body>
<?php include('../includes/header.php') ?>
<div class="tit">
<h2>LES DEVELOPPEURS</h2>
</div>

    <div class="container">
    
    <div class="bwat">
            <div class="bwat_header">
                
            </div>
            <div class="won">
                <img src="../images/id.jpg" alt="">
            </div>
            <div class="text">
				<h4>Ancelinio S. SAINTILNORD</h4>
				<P>Etudiant en sciences informatiques à l'Université Anténor Firmin </P>
                <p></p>
                <p></p>
                <h6>@ancelinio_saintilnord</h6>
			</div>

            <div class="icone">
				<img src="../images/what.png">
				<img src="../images/face.png">
				<img src="../images/insta.png">
				<img src="../images/yout.png">

			</div>
           
        </div>

        <div class="bwat">
            <div class="bwat_header">
                
            </div>
            <div class="won">
                <img src="../images/d4.jpg" alt="">
            </div>
            <div class="text">
				<h4>Gachard DORELIEN</h4>
				<P>Etudiant en sciences informatiques à l'Université Anténor Firmin </P>
                <p></p>
                <p></p>
                <h6>@gachard_dorelien</h6>
			</div>

            <div class="icone">
				<img src="../images/what.png">
				<img src="../images/face.png">
				<img src="../images/insta.png">
				<img src="../images/yout.png">

			</div>
           
        </div>

        <div class="bwat">
            <div class="bwat_header">
                
            </div>
            <div class="won">
                <img src="../images/d2.jpg" alt="">
            </div>
            <div class="text">
				<h4>Loukervens SAINT-PREUX</h4>
				<P>Etudiant en sciences informatiques à l'Université Anténor Firmin </P>
                <p></p>
                <p></p>
                <h6>@loukervens_sp</h6>
			</div>

            <div class="icone">
				<img src="../images/what.png">
				<img src="../images/face.png">
				<img src="../images/insta.png">
				<img src="../images/yout.png">

			</div>
           
        </div>
           
        </div>

        


        </div>

      
</body>
</html>
