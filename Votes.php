<html>
    <head>
    	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.0-beta.5/angular.min.js"></script>
   		<script src="app.js"></script>
        <script src="js/md5.js"></script>
        <script type="text/javascript" src="js/jsbn/jsbn.js"></script>
        <script type="text/javascript" src="js/jsbn/jsbn2.js"></script>
        <script type="text/javascript" src="js/jsbn/prng4.js"></script>
        <script type="text/javascript" src="js/jsbn/rng.js"></script>
        <script type="text/javascript" src="js/paillier.js"></script>


   		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    	<title>Wesen - Digital certificates</title>

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

            <div class="col-md-3">
                <p class="lead"><h4>Votes</h4></p>
                </br></br>
            </div>
            
            </br>
            </br>

            <div class="col-md-12">
                <p class="lead">Clé publique : {{ pub }}</p>
                </br></br>
                <p class="lead">Clé privée : {{ priv }}</p>
                </br></br>
            </div>

            </br>
			</br>

            <div class="col-md-12">

                    <div class="caption-full">
                        <h4>
                            Rajouter une question
                        </h4>
                        </br>


                            <form action="Votes.php" method="post" class="form-inline">

                                <div class="form-group">
                                        
                                    <label for="exampleInputName2">Question</label>
                                    <input type="text" ng-model="main.prenom" placeholder="Question" id="Question" name="Question" class="form-control">
                                    </br>
                                    </br>
                                </div>
                            
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail2">Clé publique</label>
                                    <input type="number" id="PublicKey" name="PublicKey" placeholder="Public key" class="form-control">
                                
                                    </br>
                                    </br>
                                </div>

                                <div class="form-group col-md-12">
                                    </br>
                                    <button ng-click="main.send()" class="btn btn-default">Envoyer</button> </br>
                                    </br>
                                    </br>
                                </div>
                            </form>
                        </div>
                        </br></br>


        <form class="form-inline">
                <p>
                    </br>
                    <label>Vote</label>
                    <input type="number" name="vote" class="form-control" ng-model="main.vote" />
                    </br>
                    <label>Clé publique</label>
                    <input type="number" name="token" class="form-control" ng-model="main.key" />
                    </br></br>
                    <input type="submit" ng-click="main.encode()" value="Chiffrer" />
                </p>
        </form>


        <p> {{ chiffre }} </p>



        <h1>Vous pouvez voter sur les questions suivantes :</h1>
        </br>
 
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

        // On récupère les 5 derniers billets
        $req = $bdd->query('SELECT id, question, publicKey FROM Questions ORDER BY id DESC LIMIT 0, 5');

        while ($donnees = $req->fetch())
        {
    ?>

    <div class="news">
        
        
        <h3>
            <?php echo htmlspecialchars($donnees['question']); ?>
        </h3>
        
        <p>
            
            
            <p>
                        Identifiant : <?php echo $donnees['id']; ?>
            </p>
            <p>
                        Clé publique : <?php echo $donnees['publicKey']; ?>
            </p>
            </br>

            <form class="form-inline" action="vote.php" method="post">
                <p>
                    </br>
                    <label>Vote chiffré</label>
                    <input type="number" name="vote" class="form-control" />
                    </br>
                    <label>Token</label>
                    <input type="number" name="token" class="form-control" />
                    </br></br>
                    <input type="submit" value="Voter" />
                </p>
            </form>
            
            <br />
        </p>

    </div>
    <?php
    } // Fin de la boucle des billets
    $req->closeCursor();
    ?>


    <?php
    if (isset($_POST['Question']) AND isset($_POST['PublicKey']))
    {
            // Testons si le fichier n'est pas trop gros
            $req = $bdd->prepare('INSERT INTO Questions(question,publicKey) VALUES(:question, :key)');
            $req->execute(array(
                'question' => $_POST['Question'],
                'key' => $_POST['PublicKey']
            ));
            header('Location: index.php');
    }
    ?>
                    
                </div>

    	</div>
    	<!-- /.container -->



		 <!-- jQuery -->
    	<script src="js/jquery.js"></script>

    	<!-- Bootstrap Core JavaScript -->
    	<script src="js/bootstrap.min.js"></script>
    	
    </body>
</html>