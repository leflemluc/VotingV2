;(function(){



function userService($http, API) {
  var self = this;

  
	self.send = function(contract) {
		return $http.post(API + '/dipl/send', {
    		contract : contract
    	})
	}

	self.check = function(contract, block) {
		return $http.get(API + '/dipl/check', {
    		contract : contract,
				block : block
    	})
	};
	
	

  // add authentication methods here

}



function MainCtrl(user, $scope) {
  var self = this;
	var jsonId={ prenom: 'prenom', nom: 'pilcer' };
	var jsonIdHashed='';
	var contract='';
	var signedContract = '';
	var keys = paillier.generateKeys(50);
	$scope.chiffre = 0;
	$scope.pub=keys.pub.n.toString();
	$scope.priv=keys.sec.lambda.toString();
	var keyLogged = new BigInteger(self.key);
	//erreur : probablement sur le bigint..
	var keysScope = paillier.publicKey(150, keyLogged);

	var keySec = new BigInteger(self.secKey);
	//var SecKeyScope = paillier.privateKey(keySec, keysScope);

	self.encode = function() {
		$scope.chiffre = keysScope.encrypt(nbv(self.vote)).toString();
		// publicKey(200, self.key).bits;
		// publicKey(self.key, 200).encrypt(nbv(self.vote))
	}

	self.decode = function() {
		//$scope.resultat = SecKeyScope.decrypt(encABC).toString(10);
		// publicKey(200, self.key).bits;
		// publicKey(self.key, 200).encrypt(nbv(self.vote))
	}

	self.send = function() {
		jsonId['prenom']=self.prenom;
		jsonId['nom']=self.nom;
		var jsonIdString = JSON.stringify(jsonId);
		jsonIdHashed=md5(jsonIdString);
		alert(keys.pub.n);
		alert(keys.sec.lambda);
		
		// Création du contrat
		// Compilation du contrat & signature

		// Envoi à l'API
		user.send(signedContract)
      .then(handleRequest, handleRequest)
  }

	self.check = function() {
		jsonId['prenom']=self.prenom;
		jsonId['nom']=self.nom;
		var jsonIdString = JSON.stringify(jsonId);
		jsonIdHashed=md5(jsonIdString);
		alert(jsonIdHashed);
		
		// Création du contrat
		// Compilation du contrat & signature

		// Envoi à l'API
		user.check(signedContract, self.block)
      .then(handleRequest, handleRequest)


  }
  
  
  

}

angular.module('app', [])
.service('user', userService)
.constant('API', 'http://test-routes.herokuapp.com')
.controller('Main', MainCtrl)
})();