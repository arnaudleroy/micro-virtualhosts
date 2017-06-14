<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
/**
 * Controller My 
 **/
class My extends ControllerBase{
	
	/**
	 * Mes services
	 * Hosts et virtualhosts de l'utilisateur connecté
	 */
	
	
	public function index(){
		
		if(Auth::isAuth()){
			$user=Auth::getUser();
			$hosts=DAO::getAll("models\Host","idUser=".$user->getId());
			
	//Permet d'afficher, obligé de l'appeler dans twig
			$hostsItems=$this->semantic->htmlItems("list-hosts");
			$hostsItems->fromDatabaseObjects($hosts, function($host){
				$item=new HtmlItem("");
				$item->addImage("public/img/host.jpg")->setSize("tiny");
				$item->addItemHeaderContent($host->getName(),$host->getIpv4(),"");
				return $item;
				
			
			});
			
	//TODO1
		
					//Accéder à tous les vhosts en fonction de l'userID passé en paramètres
					//Utilise un des models pour accéder à un des virtuals hosts 
					//Met dans une variable tous les vhosts grâce à la fonction membre 
				//presente dans le modèle virtualhost.php qui lui même va les chercher dans la base de données
					// Mais il y a un paramètre idUser, que l'on applique à getID, pour avoir seulement ID du user,
				//on va chercher une donnée de l'objet user
				$vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());
				
				//Permet de compiler en Java
				$this->jquery->compile($this->view);
				//Permet de charger dans la vue les variables instanciées dans le contrôleur(=cette page)
				$this->loadView("My/index.html"
						,array(
						"tableau_vhosts"=>$vhosts
						//"tableau_server"=>$vhosts_server
				) );
			
		}
		
	//TODO4
	//PROTECTION DU CONTROLLER MY
		
		else 
		{
				//Utilisation de phpMv-UI
				//Pris dans le contrôler login
				//Pas obligé d'utiliser twing parce qu'on fait l'appel directement ici avec echo "$message"
				//Créer un objet "message" et on lui applique la méthode semantic (pour dire utilise sementic-ui)
			//et html message (permet de mettre "merci de vous connecter pour tester") 
			$message=$this->semantic->htmlMessage("error","Merci de vous connecter pour tester.");
				//Rajoute l'icône au message affiché précédement avec la méthode setIcon créer par Mr HERON'
			$message->setIcon("announcement")->setError();
				//Ajouter la croix en haut à gauche pour fermer la mesage précédement affiché
			$message->setDismissable();
				//Permet d'ajouter le bouton pour le test, on a changé la librairie Login:: en Auth::
			//pour que cela focntionne
			$message->addContent(Auth::getInfoUser($this,"-login"));
			//Affichage de l'objet "$message"
			echo $message;
			//Utilisation de Java pour pouvoir cliquer sur le bouton pour s'identifier "connexion pour tests"
			echo $this->jquery->compile($this->view);
		}
		
	}
}