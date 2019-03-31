<?php

abstract class CoreController
{

    protected $model;
    protected $param;
    protected $data;

    public function __construct()
    {
        $this->param = array();
        $this->data = array();

        $controllerName = get_class($this);
        //Recupération du nom du modele associé au controller
        $modelName = substr($controllerName, 0, -10) . 'Model';
        if (file_exists(MODEL_PATH . DS . $modelName . '.php')) {
            $model = new $modelName();
            $this->model = $model;
        }
    }

    protected function getModel()
    {
        return $this->model;
    }

    protected function render($viewname, array $data = [])
    {
        ob_start();
        include(VIEW_PATH . DS . $viewname . '.php');
        $view = ob_get_contents();
        ob_end_clean();

        include(VIEW_PATH . DS . 'layout.php');
    }

    protected function renderUnknownPage()
    {
        http_response_code(404);
        $this->render('page404');
    }

    protected function showHomeAction(array $erros=[])
    {
        if (empty($errors))
            $this->render('home');
        else {
            $data['messages'] = $errors;
            $this->render('home', $data);
        }
    }

    /**
     * Equivalent de ParamFetcher en SF
     * Recupere les donnees GET
     * @return array $_GET
     */
    protected function getParam()
    {
        return $this->param;
    }

    /**
     * Equivalent de ParamConverter en SF
     * Recupere les donnees POST
     * @return array $_POST
     */
    protected function getData()
    {
        return $this->data;
    }

    public function setParam($array)
    {
        $this->param = $array;
    }

    public function setData($array)
    {
        $this->data = $array;
    }

    public function secureData(array $data)
    {
        foreach ($data as $key => $value) {
            // Exclude tag key as it is a multiple selection
            // sent in tag[] format, doesn't match the htmlentity test
            if ($key!='tags')
                $data[$key] = htmlentities($data[$key]);
        }
        return $data;
    }

    public function trigger($action)
    {
        $actionName = $action . 'Action';
        if (method_exists($this, $actionName)) {
            $this->$actionName();
        } 
        else {
            $this->renderUnknownPage();
        }
    }

    protected function getSession()
    {
        return $_SESSION;
    }

    public function getConnectedUser()
    {
        $session  = $this->getSession();
        if (isset($session['blog']['user']) && !empty($session['blog']['user'])) {
            return $session['blog']['user'];
        } 
        return false;
    }

    /**
     * [Verify if there is a connected user and get his roles as string
     * to return them as array]
     * @return [array] [return array of role(s)]
     */
    public function getRoles()
    {
        if (($user = $this->getConnectedUser()) !== false) {
            $roles = $user['use_role'];

            //If there is more than one role, split element into array
            if (strpos($roles, ',')!==false) {
                $rolesArray = explode(',', $roles);
                foreach ($rolesArray as $key => $value) {
                    $rolesArray[$key]=trim($rolesArray[$key]);
                }
            }// If there is only one element, put this element into array
            else {
                $rolesArray[] = $roles;
            }
            return $rolesArray;
        }
        return false;
    }

    /**
     * [Verify if the user has the role placed in parameter]
     * @param  string  $role [the role to be verified]
     * @return boolean       [description]
     */
    public function hasRole(string $role)
    {
        if (($rolesArray = $this->getRoles()) !==false) {
            return (in_array($role, $rolesArray)) ? true : false;
        }
        return false;
    }

    /**
     * Display string in views if set.
     * @param  string $data [description]
     * @return [type]       [description]
     */
    public function display(string $data='')
    {
        if (isset($data))
            echo $data;
    }
}

?>