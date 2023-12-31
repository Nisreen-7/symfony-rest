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

# Faire le GenreController en utilisant le GenreRepository
## Méthode alternative
 pour avoir le même résultat mais juste un peu moins optimisée : Créer une méthode findByMovie(int $movieId) dans le GenreRepository, et dans le MovieRepository::findAll() faire en sorte de lancer le findByMovie dans le foreach pour chaque film

 ### Dans le GenreController,
  rajouter une route sur localhost:8000/api/genre/movie/{id} qui utilisera le findByMovie du GenreRepository pour renvoyer les genres associés à un film donné


  # faire le test dans un symfony

  ## Des tests. En vous "inspirant" de la méthode testGetAll faire les tests suivants :

Vérifier que le /api/movie/id fonctionne et renvoie bien un truc qui ressemble à un film
	
Vérifier que le /api/movie/id renvoie bien un 404 quand on lui donne un id qui n'existe pas
	
Vérifier que le /api/movie en POST fonctionne quand on lui envoie un film en JSON (on pourra par exemple vérifier que la réponse contient bien un id)
	
Vérifier que le /api/movie/id en PATCH fonctionne et met bien à jour le champ qu'on lui dit de modifier
	
Vérifier qu'on a un 404 sur le PATCH aussi si on donne un truc qui existe pas
	
Tester que le /api/movie/id en DELETE fonctionne, mais du coup ça marchera qu'une seule fois pour le moment


# En vous inspirant de la partie validation du post du MovieController, faire :
	
La validation du Patch de MovieController (juste avant le update)
	
La validation du POST de GenreController, on veut juste que le label ne soit pas vide
	
La validation du PATCH du GenreController



//ici on a faire les suivants pour projet angular-symfony et

# Champ de recherche (avec autocomplétion !)


	
# Côté symfony:
1.  dans le MovieRepository, créer une méthode search(string $term) qui va faire une requête pour récupérer juste les films (pas de jointure) dont le title ou le resume ou le released contient le terme recherché
	
2. Dans la partie contrôleur créer une nouvelle route sur /api/movie/search/{term} qui va lancer la méthode du repo qu'on vient de créer
	
3. Rajouter un test ou deux dans le MovieApiTest pour cette route, car on aime la qualité logicielle
	
# Côté Angular:
1.  dans le MovieService, rajouter une nouvelle méthode search qui va faire appelle à la route symfony qu'on vient de créer
	
2. Générer un SearchComponent qu'on va afficher dans le AppComponent (comme ça on a la barre de recherche sur toutes les pages)
	
3. Dans ce component, on va avoir une propriété term en string initialisée vide qu'on va lier à un input
	
4. On va également avoir une propriété result de type Movie[] initialisée en tableau vide
	
5. Créer une méthode doSearch qui va lancer le search du service et assigné les data au results
	
6. Faire en sorte de lancer cette méthode quand on tape dans l'input
	
7. Faire du style pour que ça ressemble à une barre de recherche avec autocomplétion