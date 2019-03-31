<?php

class UserController extends CoreController
{

    public function connexionAction()
    {
        $data = $this->getData();

        if ($this->isConnexionFormValid($data) === true ) {
            if ($user = $this->getModel()->getUserByName($data)) {
            	if ( password_verify($data['password'], $user['use_password'])) {
            		$user['use_last_login'] = date('Y-m-d H:i:s');
            		$this->getModel()->updateUser($user);

		            unset($user['use_password']);
		            $_SESSION['blog']['user'] = $this->secureData($user);
            	}
	            else {
            		$data['messages'][] = 'bad credentials';
				}
            }
            else {
            	$data['messages'][] = 'bad credentials';
            }
        } 
        else {
        	$data['messages'] = $this->isConnexionFormValid($data);
        }
    	$this->render('home', $data);	
    }

    protected function isConnexionFormValid(array $data)
    {
    	$errors = array();
    	$loginPattern = "@^[a-zA-Z\déè]{4,20}$@";
    	$mdpPattern = "@^[a-zA-Z\déè]{4,20}$@";

    	if (empty($data['login'])) {
    		$errors[] = 'Vous n\'avez pas rentré votre login!';
    	}
    	elseif ( !preg_match($loginPattern, $data['login']) ) {
    		$errors[] = "Votre login doit contenir entre 4 et 20 caracteres alphanumeriques!";
    	}
    	if (empty($data['password'])) {
    		$errors[] = 'Vous n\'avez pas rentré votre mot de passe!';
    	}
    	elseif ( !preg_match($mdpPattern, $data['password']) ) {
    		$errors[] = "Votre mot de passe doit contenir entre 4 et 20 caracteres alphanumeriques!";
    	}
    	return (count($errors) === 0) ? true : $errors;
    }

    public function deconnexionAction()
    {
        unset($_SESSION['blog']['user']);

        $this->render('home');
    }

    public function showRegisterFormAction()
    {
        // If the user is connected and is ADMIN or MANEGER
        // We give him the choice to decide the role of the registered user
        if ($this->getConnectedUser()) {
            
            var_dump($this->getRoles());
            var_dump($this->hasRole('ROLE_ADMIN'));
            var_dump($this->hasRole('ROLE_MANAGER'));
            var_dump($this->hasRole('ROLE_USER'));

            if ($this->hasRole('ROLE_ADMIN')) {
                $data['roles'] = ['ROLE_MANAGER', 'ROLE_ADMIN'];
                $this->render('form/registerForm', $data);
            }
            elseif ($this->hasRole('ROLE_MANAGER')) {
                $data['roles'] = ['ROLE_MANAGER'];
                $this->render('form/registerForm', $data);
            }
            else {
                $this->render('form/registerForm');
            }
        }
        else {
            $this->render('form/registerForm');
        }

    }

    protected function registerAction()
    {
    	$receivedData = $this->getData();

    	if($this->isRegistrationFormValid($receivedData) === true) {

			$data['role'] = 'ROLE_USER';
            if (!empty($receivedData['role'])) {
                switch ($receivedData['role']) {
                    case 'ROLE_MANAGER':
                        $data['role'] .= ', ROLE_MANAGER';
                        break;
                    case 'ROLE_ADMIN' :
                        $data['role'] .= ', ROLE_MANAGER, ROLE_ADMIN';
                    default;
                }
            }
            $data['login'] = $receivedData['login'];
    		$data['last_login'] = ''; 
    		$data['created'] = date('Y-m-d H:i:s');
    		$data['password'] = password_hash($receivedData['password'], PASSWORD_DEFAULT );
    		$newUser = new User($data);
    		
    		try{
				$this->getModel()->createUser($newUser);
    			$data['messages'][] = 'Vous etes bien inscrit';
    			$this->render('home', $data);
    		}
    		catch(Exception $e) {
    			if($e->getCode() === '23000') {
                    $data['messages'][] = 'Ce login existe déjà';
    				$data['messages'][] = $e->getMessage();
    			}
    			else {
    				$data['messages'][] = 'Une erreur est survenue';
    			}
    			$this->render('form/registerForm', $data);
    		}
    	}
    	else {
    		$data['messages'] = $this->isRegistrationFormValid($receivedData);
    		$this->render('form/registerForm', $data);
    	}
    }

    protected function isRegistrationFormValid(array $data)
    {
    	$errors = array();
    	$loginPattern = "@^[a-zA-Z\dé]{4,20}$@";
    	$mdpPattern = "@^[a-zA-Z\dé]{4,20}$@";

    	if (empty($data['login'])) {
    		$errors[] = 'Vous n\'avez pas rentré votre login!';
    	}
    	elseif ( !preg_match($loginPattern, $data['login']) ) {
    		$errors[] = "Votre login doit contenir entre 4 et 20 caracteres alphanumeriques!";
    	}
    	if (empty($data['password'])) {
    		$errors[] = 'Vous n\'avez pas rentré votre mot de passe!';
    	}
    	elseif ( !preg_match($mdpPattern, $data['password']) ) {
    		$errors[] = "Votre mot de passe doit contenir entre 4 et 20 caracteres alphanumeriques!";
    	}
    	if($data['password'] !== $data['passwordConf'])
    		$errors[] = 'Votre mdp de confirmation est different du premier!';
    	return (count($errors) === 0) ? true : $errors;
    }
}

?>