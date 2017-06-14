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
		
					
				$vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());
				
				$this->jquery->compile($this->view);
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
				 
			$message=$this->semantic->htmlMessage("error","Merci de vous connecter pour tester.");
			$message->setIcon("announcement")->setError();
			$message->setDismissable();
			$message->addContent(Auth::getInfoUser($this,"-login"));
			echo $message;
			echo $this->jquery->compile($this->view);
		}
		
	}
}
