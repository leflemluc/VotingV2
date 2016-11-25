<html>
    <head>
    	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0-beta.5/angular.min.js"></script>
   		<script src="app.js"></script>
        <script type="text/javascript" src="js/jsbn/jsbn.js"></script>
        <script type="text/javascript" src="js/jsbn/jsbn2.js"></script>
        <script type="text/javascript" src="js/jsbn/prng4.js"></script>
        <script type="text/javascript" src="js/jsbn/rng.js"></script>
        <script src="js/md5.js"></script>
        <script type="text/javascript" src="js/paillier.js"></script>


		
   		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    	<title>Voting</title>

    	<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/shop-item.css" rel="stylesheet">
	</head>
   
   
    <body ng-app="app" ng-controller="Main as main">
    
    		    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        		<div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Voting</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">Voting - Plateforme de vote sécurisé</a>
            </div>
            
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.html">Accueil</a>
                    </li>
                    <li>
                        <a href="about.html">A propos</a>
                    </li>
                    <li>
                        <a href="Votes.php">Votes disponibles</a>
                    </li>
                    <li>
                        <a href="Resultats.php">Obtenir le résultat</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    		</nav>

    
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <p class="lead"><h4>Obtenir le résultat d'un vote</h4></p>
                </br></br>
            </div>
            
            </br>

            
            <form class="form-inline">
                <p>
                    </br>
                    <label>Résultat</label>
                    <input type="number" name="vote" class="form-control" ng-model="main.resultatChiffre" />
                    </br>
                    <label>Clé publique</label>
                    <input type="number" name="token" class="form-control" ng-model="main.key" />
                    </br>
                    <label>Clé privée</label>
                    <input type="number" name="token" class="form-control" ng-model="main.secKey" />
                    </br></br>
                    <input type="submit" ng-click="main.decode()" value="Déchiffrer" />
                </p>
            </form>
            </br>
			</br>

            <div class="col-md-12">

                    <div class="caption-full">
                        </br>


                            <form class="form-inline" action="Resultats.php" method="post">

                                <div class="form-group">
                                        
                                    <label for="exampleInputName2">Entrez l'identifiant de votre question</label>
                                    <input type="number" ng-model="main.prenom" placeholder="Identifiant" id="id" name="id" class="form-control">
                                    </br>
                                    </br>
                                </div>

                                <div class="form-group col-md-12">
                                    </br>
                                    <button type="submit" value="Envoyer" class="btn btn-default">Envoyer</button> </br>
                                    </br>
                                    </br>
                                </div>
                            </form>
                        </div>
                    
                </div>

                <?php
                    // Connexion à la base de données
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=Voting;charset=utf8', 'root', '');
                    }
                    catch(Exception $e)
                    {
                            die('Erreur : '.$e->getMessage());
                    }


                    if (isset($_POST['id']))
                    {
                            
                        // On récupère les 5 derniers billets
                        $id=$_POST['id'];
                        $req = $bdd->query("SELECT token, vote FROM Token WHERE id='$id'");
                        $somme=1;

                        while ($donnees = $req->fetch())
                        {
                            $somme=$somme*$donnees['vote'];
                            
                ?>
                <div class="caption-full">
                    
                    
                    <p>
                        <?php echo htmlspecialchars($donnees['vote']); ?>
                    </p>
                    <p>
                        Token associé : <?php echo htmlspecialchars($donnees['token']); ?>
                    </p>
                    
                    <p>
                        
                        
                        
                        
                        <br />
                    </p>

            
                <p>
                    La somme chiffrée des voix vaut : </br>
                <?php
                    }echo ($somme); // Fin de la boucle des billets
                    $req->closeCursor();}
                ?>
                </p>
                </br>
                </br>
                <p>
                    Reste à déchiffrer le résultat !
                </p>
                </div>

    	</div>
    	<!-- /.container -->




		 <!-- jQuery -->
    	<script src="js/jquery.js"></script>

    	<!-- Bootstrap Core JavaScript -->
    	<script src="js/bootstrap.min.js"></script>
    	
   </body>
</html>