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
	var keys = paillier.generateKeys(50);
	$scope.chiffre = 12;
	$scope.pub=keys.pub.n.toString();
	$scope.priv=keys.sec.lambda.toString();
	$scope.essai="Essai";
	
	//a supprimer
	//$scope.pub=keysScope.n.toString();


	$scope.encode = function() {
		$scope.chiffre = $scope.key;

// Je ne comprends pas comment fonctionne la transformation int --> BigInteger

		var keyLogged = new BigInteger($scope.key.toString(), 64);
	//  erreur ! ce n'est pas une public key....
		var keysScope = new paillier.publicKey(150, keyLogged);
		$scope.pub=keysScope.n.toString();
	 	$scope.chiffre=keyLogged.toString();
		
		//$scope.chiffre = keysScope.n.toString();
		
		
		//$scope.chiffre = keysScope.encrypt(nbv(self.vote)).toString();
		
		
		// publicKey(200, self.key).bits;
		// publicKey(self.key, 200).encrypt(nbv(self.vote))
	}

	self.decode = function() {
		var keySec = new BigInteger(self.secKey.toString(), 64);
		//keySec.toString()
	//var SecKeyScope = paillier.privateKey(keys.sec.lambda, keys.pub);
		var SecKeyScope = new paillier.privateKey(keySec, keys.pub);


		//$scope.resultat = SecKeyScope.decrypt(encABC).toString(10);
		// publicKey(200, self.key).bits;
		// publicKey(self.key, 200).encrypt(nbv(self.vote))
	}

}

angular.module('app', [])
.service('user', userService)
.constant('API', 'http://test-routes.herokuapp.com')
.controller('Main', MainCtrl)
})();