# Créer un database.sql
 avec une entité et un repository pour : un Movie avec un title en varchar, un resume en text, un released en Date et un duration en int

## Premier contrôleur Rest :


	
Créer un contrôleur MovieController et lui rajouter un constructeur contenant un MovieRepository en private
	
Rajouter une route /api/movie, préciser dans la route que sa méthode est GET
	
Faire un return d'un $this->json() avec le findAll du repository à l'intérieur
	
Tester cette méthode sur thunder client en faisant une requête GET vers localhost:8000/api/movie
	
Rajouter une nouvelle route sur /api/movie/{id} en GET également, et dedans faire un findById, si le retour est null on fait un return d'un $this->json avec un message Resource Not Found et le status 404  , sinon on renvoie le movie
	
Rajouter une nouvelle route /api/movie/{id} mais cette fois ci en method DELETE et dedans on supprime le movie
## exemple.html ......

# Faire le POST à la main


	
Créer une nouvelle route sur /api/movie en POST, dans les arguments de la route, ajouter le Request $request
	
Utiliser la méthode ->toArray() de la $request pour récupérer les données du body sous forme de tableau associatif (par exemple si on stock ça dans une variable data on pourra accéder à $data['title']
	
Faire une instance de movie et dans le constructeur mettre les données du toArray aux bons emplacement, sachant que pour le "released" il faudra faire un new DateTime
	
Donner cette instance au persist du repo et faire un return de json() avec l'instance en argument et le status 201 (created)