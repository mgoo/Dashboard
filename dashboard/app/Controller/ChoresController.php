<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP Chores
 * @author Andrew
 */
class ChoresController extends AppController {
    public $uses = ['User','Device'];
    public $helpers = ['Form', 'Html'];
    public $layout = 'MainLayout';
    public $components = ['Cookie', 'Session', 'Auth', 'RequestHandler'];

    public function index() {
        $this->set('current_user',  $this->User->find('all', ['feilds' => ['id', 'username', 'first_name'], 'conditions' => ['username' =>  $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp()]])['Device']['username']]]));    
        $this->set('users', $this->User->find('all', ['feilds' => ['id', 'username', 'first_name']]));
    }

}
