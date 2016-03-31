<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MessagesController
 * @author Andrew
 */
class MessagesController extends AppController {
    public $uses = ['User','Device','Message'];
    public $helpers = ['Form', 'Html'];
    public $layout = 'MainLayout';
    public $components = ['Cookie', 'Session', 'Auth', 'RequestHandler'];
    
    private $username;
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->username = $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp(), 'loggedin' => '1']])['Device']['username'];
    }
    
    public function index() {
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $userId = $this->User->find('first', ['conditions' => ['username' => $this->username]])['User']['id'];
        $this->set('messages', $this->getMessages($userId));
        $this->set('user_id', $userId);
        $this->seeMessages($this->Message->find('all', ['conditions' => ['seen NOT LIKE' => '%'.$userId.'%']]), $userId);
    }
    
    private function seeMessages($results, $userId){
        foreach ($results as $messages){
            $this->Message->id = $messages['Message']['id'];
            $this->Message->saveField('seen', $messages['Message']['seen'].$userId);
        }
    }
    private function getMessages($userId){        
        $messages = $this->Message->find('all', ['limit' => 10, 'fields' => ['message', 'user', 'seen'], 'order' => ['id DESC']]);
        foreach($messages as &$message){
            if ($message['Message']['user'] == $userId){
                $message['Message']['own'] = 1;                
            } else {
                $message['Message']['own'] = 0;
            }
            $message['Message']['user'] = $this->User->find('first', ['conditions' => ['id' => $message['Message']['user']]])['User']['username'];
            if (strpos($message['Message']['seen'], $userId) === false){
                $message['Message']['seen'] = 0;
            } else {
                $message['Message']['seen'] = 1;
            }
        }
        return $messages;
    }
    
    public function newMessage(){
        $this->autoRender = false;
        
        $this->Message->save(['Message' => ['message' => $this->request->data['message'], 'user' => $this->request->data['user'], 'seen' => $this->request->data['user']]]);        
        
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $userId = $this->User->find('first', ['conditions' => ['username' => $this->username]])['User']['id'];
        $this->set('messages', $this->getMessages($userId));
        $this->set('user_id', $userId);
        $this->seeMessages($this->Message->find('all', ['conditions' => ['seen NOT LIKE' => '%'.$userId.'%']]), $userId);
        
        $this->render('index');        
    }    

}
