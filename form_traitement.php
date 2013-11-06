<?php

/*

TODO : 
- salage mdp
- sécurité


*/

if(isset($_POST['submit'])){

    // initialise un tableau pour les éventuelles erreurs du formulaire
    $form_error = array();
    
    // Si l'email n'est pas renseigné, affichage erreur
    if (    !isset($_POST["email"]) || empty($_POST["email"]) ){  
        $form_error['email'] = "Veuillez renseigner votre email";  
        echo $form_error['email'];
    }

    else{   

        $email = mysql_real_escape_string($_POST['email']);

        // Vérification de la présence du compte dans la BDD
        $selectEmail = $PDO->prepare("SELECT email FROM utilisateurs WHERE email = :email ");
        $selectEmail->execute(array(
            ':email' => $email
        ));

        // L'email n'existe pas, vérification champs puis création du compte en BDD
        if($selectEmail->rowCount() == 0){



                if (    !isset($_POST["lastname"]) || empty($_POST["lastname"]) ){  $form_error['lastname'] = "Veuillez renseigner votre nom";  }
                else{   $lastname =  mysql_real_escape_string($_POST['lastname']);}

                if (    !isset($_POST["firstname"]) || empty($_POST["firstname"]) ){$form_error['firstname'] = "Veuillez renseigner votre prénom";}
                else{   $firstname =  mysql_real_escape_string($_POST['firstname']);}

                if (!isset($_POST["email"]) || empty($_POST["email"]) ){    $form_error['email'] = "Veuillez renseigner votre email";}
                else{
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $email =  mysql_real_escape_string($_POST['email']);
                    }
                    else{
                        $form_error['email'] = "Email invalide";
                    }       
                }

                if (    !isset($_POST["password"]) || empty($_POST["password"]) ){$form_error['password'] = "Veuillez renseigner un mot de passe";}
                else{   $password = hash('sha256', $_POST['password']);}

                if (    !isset($_POST["birthday"]) || empty($_POST["birthday"]) ){$form_error['birthday'] = "Veuillez renseigner votre date de naissance";}
                else{   
                        $birthday =  mysql_real_escape_string($_POST['birthday']);

                        // Conversion du format facebook (02/19/1988) au format SQL Date (1988-02-19)
                        $birthdayDate   = DateTime::createFromFormat('d/m/Y', $_POST['birthday']);
                        $birthdayFormat = $birthdayDate->format('Y-m-d');
                }

                if (    !isset($_POST["skill"]) || empty($_POST["skill"]) ){$form_error['skill'] = "Veuillez renseigner votre niveau";}
                else{   $skill =  $_POST['skill'];}



                if (    !isset($_POST["material"]) || empty($_POST["material"]) ){
                        $material = 0;
                }
                else{   
                        $material = 1;
                }


                if (    !isset($_POST["practice"]) || empty($_POST["practice"]) ){ $practice = ""; }
                else{   $practice = implode(', ', $_POST['practice']);}

                if (    !isset($_POST["description"]) || empty($_POST["description"]) ){$form_error['description'] = "Veuillez renseigner une description";}
                else{   

                        $description =  $_POST['description'];
                        $description = filter_var($description, FILTER_SANITIZE_STRING); 
                }

                /*
                if (    !isset($_POST["phone"]) || empty($_POST["phone"]) ){$form_error['phone'] = "Veuillez renseigner votre téléphone";}
                else{   $phone =  $_POST['phone'];}
                */

                var_dump($form_error);

                // Si aucune erreur
                if(empty($form_error)){

                    // Return Success - Valid Email  
                    $response = $PDO->prepare("INSERT INTO utilisateurs VALUES(NULL, :nom , :prenom , :email , :date_naissance, :mdp  , :niveau , :technique , :description , :materiel, :telephone) ") or die(print_r($PDO->errorInfo()));

                    $response->execute(
                        array(
                            'nom'               => $lastname,
                            'prenom'            => $firstname,
                            'email'             => $email,
                            'date_naissance'    => $birthdayFormat,
                            'mdp'               => hash('sha256', $_POST['password']),
                            'niveau'            => $skill,
                            'technique'         => $practice,
                            'description'       => $description,
                            'materiel'          => $material,
                            'telephone'         => ""
                        )
                    );

                    if($response == true){


                        // Vérification de la présence du compte dans la BDD
                        $selectEmail = $PDO->prepare("SELECT id, email, mdp FROM utilisateurs WHERE email = :email ");
                        $selectEmail->execute(array(
                              ':email' => $email
                        ));

                        // DEMARRAGE SESSION
                        if($selectEmail->rowCount() == 1){

                              while ($row = $selectEmail->fetch(PDO::FETCH_ASSOC)) {
                                    $pass = hash('sha256', $_POST['password']);
                                    if($pass == $row['mdp']){

                                          $_SESSION['membre_id']       = $row['id'];
                                          $_SESSION['membre_email']    = $row['email'];
                                          $_SESSION['membre_mdp']      = $row['mdp'];
                                          $_SESSION['membre_logged_in']= true;

                                          // Redirection carte
                                          header('Location: carte.php');

                                    }
                                    else{
                                          echo "Incorrect password";
                                    }
                              }
                        }
                        $selectEmail->closeCursor();


                        header("Location: ./carte.php"); /* Redirection du navigateur */
                        exit;

                    }
                    else{
                        echo "Petit erreur technique.. ".$response->errorInfo();
                    }

                    //'materiel'            => $_POST['materiel'],

                     $msg = 'Ok ! mail valide + ajout en BDD';
                     echo $msg; 

                }   

                    
           
            // Affichage message d'erreur
            /*
            foreach ($form_error as $i => $value) {
                echo $i . " => " .$value ." <br/> ";
            }
            */
            
            

        }

        else{
            // Adresse e-mail déjà utilisée !
            $email_error = true;
        }

    }

}


function isChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}



		/*

		// Récupération des variables du formulaire 
	    $lastname 		= mysql_escape_string($_POST['lastname']);
	    $firstname 		= mysql_escape_string($_POST['firstname']);
	    $email 			= mysql_escape_string($_POST['email']); 	
	    $password 		= hash('sha256', $_POST['password']);


	    // Conversion du format facebook (02/19/1988) au format SQL Date (1988-02-19)
	    $birthdayDate 	= DateTime::createFromFormat('d/m/Y', $_POST['birthday']);
	    $birthdayFormat = $birthdayDate->format('Y-m-d');

	    $skill 			= mysql_escape_string($_POST['skill']); 
	    $practice 		= mysql_escape_string($_POST['practice']); 
	    $description 	= mysql_escape_string($_POST['description']); 
	    $phone 			= int($_POST['phone']);

	    */




/*
	$id_fb = intval($_POST['id_fb']);



   	// Vérification de la présence du compte fb dans la BDD
	$selectFbId = $PDO->query("SELECT id_fb FROM utilisateurs WHERE id_fb = $id_fb");
	$selectFbId->execute();

	if($selectFbId->rowCount() == 0){

		$response = $PDO->prepare("INSERT INTO utilisateurs VALUES(NULL, :nom , :prenom , :email , :date_naissance, ':mdp'  , :niveau , '' , '', '', '') ") or die(print_r($PDO->errorInfo()));

		$response->execute(
			array(
				'id_fb' 			=> $id_fb,
				'nom' 				=> $_POST['last_name'],
				'prenom' 			=> $_POST['first_name'],
				'email' 			=> $_POST['email'],
				'date_naissance' 	=> $birthdayFormat,
				'mdp'				=> $_POST['password'],
				'niveau'			=> $_POST['niveau'],
				'genre' 			=> $_POST['gender']
			)
		);

		echo json_encode( array( 'adding_data' => true , 'redirect_profile' => false ) );

	}
	else{

		echo json_encode( array( 'adding_data' => false , 'redirect_profile' => false) );

	}


*/

?>