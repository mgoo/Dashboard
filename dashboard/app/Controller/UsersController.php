<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP UsersController
 * @author Andrew
 */
class UsersController extends AppController {
    public $uses = ['User', 'Device', 'Message'];
    public $helpers = ['Form', 'Html'];
    public $layout = 'MainLayout';
    public $components = ['Cookie', 'Session', 'Auth', 'RequestHandler'];
    
    private $username;

    public function index() {
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->set('username', $this->username);
        $this->set('userId', $this->User->find('first', ['conditions' => ['username' => $this->username]])['User']['id']);
    }
    public function links(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->set('username', $this->username);
        $userId = $this->User->find('first', ['conditions' => ['username' => $this->username]])['User']['id'];
        $this->set('unreadMessages', $this->unreadMessages($userId));
        $this->layout = 'PageLayout';
    }
    
    private function unreadMessages($userId){
        return $this->Message->find('count', ['conditions' => ['seen NOT LIKE' => '%'.$userId.'%']]);
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        try{
            $this->username = $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp(), 'loggedin' => '1']])['Device']['username'];
        } catch (Exception $e){}
    }
    public function isAuthorized($user) {
        return true;
    }
    
    public function editUser(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->set('username', $this->username);
        $this->set('info', $this->User->find('first', ['conditions' => ['username' => $this->username]]));
        
        if ($this->request->is('post')){
            if ($this->request->data['User']['password2'] != $this->request->data['User']['password'] ||
                    $this->request->data['User']['oldpassword'] === '' ||
                    $this->request->data['User']['password'] === '' ||
                    $this->request->data['User']['oldpassword'] != $this->User->find('first', ['conditions' => ['username' => $this->Cookie->read('user.username')]])['User']['password']){
                unset($this->request->data['User']['oldpassword']);
                unset($this->request->data['User']['password']);
                unset($this->request->data['User']['password2']);
            } else {
                unset($this->request->data['User']['oldpassword']);
                unset($this->request->data['User']['password2']);
            }
            if ($this->request->data['User']['username'] !== $this->Cookie->read('user.username')){
                $this->Cookie->write('user.username', $this->request->data['User']['username']);
            }
            $this->User->id = $this->request->data['User']['id'];
            $this->User->save($this->request->data);
            $this->set('info', $this->User->find('first', ['conditions' => ['username' => $this->Cookie->read('user.username')]]));
        }
    }
    public function newProfile(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->layout = 'HiddenLayout';
        $id = $this->User->find('first', ['conditions' => ['username' => $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp()]])['Device']['username']]])['User']['id'];
        $this->set('userId', $id);
        if ($this->request->is('post')){            
            move_uploaded_file( $this->request->data['User']['newProfile']['tmp_name'], 'C:/wamp/www/dashboard/app/webroot/img/profiles/'.$id );
        }
    }
    ///var/www/html/dashboard/app/webroot/img/profiles/
    
    public function login(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->layout = 'LoginLayout';
        
        if($this->Device->find('count', ['conditions' => ['ip' => $this->request->clientIp()]]) > 0 && $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp()]])['Device']['loggedin'] == 1){
             return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        } //auto Login
        
        if ($this->request->is('post') && ($this->request->data['User']['password'] === $this->User->find('first', ['conditions' => ['username' => $this->request->data['User']['username']]])['User']['password'])){           
            if ($this->Device->find('count', ['conditions' => ['ip' => $this->request->clientIp(), 'username' => $this->request->data['User']['username']]]) == 0){
                echo $this->request->clientIp().'<br>'.$this->request->data['User']['username'];
                return $this->redirect(['controller' => 'Users', 'action' => 'newDevice', '?' => ['username' => $this->request->data['User']['username']]]);
            }       
            
            if($this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp(), 'username' => $this->request->data['User']['username']]])['Device']['loggedin'] == 0){
                $this->Device->id = $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp(), 'username' => $this->request->data['User']['username']]])['Device']['id'];
                $this->Device->saveField('loggedin', 1);
            }
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }        
    }
    
    public function newDevice(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->layout = 'LoginLayout';
        
        if($this->request->is('post')){
            if(!isset($this->request->data['Device']['name']) || $this->request->data['Device']['name'] == ''){
                $this->request->data['Device']['name'] = $this->request->clientIp();
            }
            $this->request->data['Device']['ip'] = $this->request->clientIp();
            $this->request->data['Device']['username'] = $this->params['url']['username'];
            $this->request->data['Device']['loggedin'] = 1;
            $this->Device->save($this->request->data);
            return $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
    }
    
    public function editDevices(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->set('devices', $this->Device->find('all', ['conditions' => ['username' => $this->username]]));
        
        if ($this->request->is('post')){
            
        }
    }
    
    /**
     * Ajax to delete a device
     */
    public function deleteDevice(){
        $this->autoRender = false;
        $this->layout = 'ajax';
        
        $id = $this->request->data['id'];
        $this->Device->delete($id);                
    }
    
    public function logout(){
        $this->Device->id = $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp(), 'loggedin' => '1']])['Device']['id'];
        $this->Device->saveField('loggedin', 0);
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

}
