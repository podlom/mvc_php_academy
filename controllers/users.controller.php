<?php

class UsersController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function admin_login()
    {
        if ( $_POST
            && !empty($_POST['login'])
            && !empty($_POST['password'])
        ) {
            // die(print_r($_POST, 1));
            $user = $this->model->getByLogin($_POST['login']);
            // die('user: ' . print_r($user, 1));
            $hash = md5(Config::get('salt').$_POST['password']);
            // die('$hash: ' . print_r($hash, 1));
            if ( $user && $user['is_active'] && $hash == $user['password'] ){
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
            }
            Router::redirect('/admin/');
        }
    }

    public function admin_logout()
    {
        Session::destroy();
        Router::redirect('/admin/users/login?t=' . rand(1111, 9999));
    }

}