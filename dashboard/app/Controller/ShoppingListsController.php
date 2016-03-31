<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ShoppingListsController
 * @author Andrew
 */
class ShoppingListsController extends AppController {
    public $uses = ['ShoppingList', 'Device'];
    public $helpers = ['Form', 'Html'];
    public $layout = 'PageLayout';
    public $components = ['Cookie', 'Session', 'Auth', 'RequestHandler'];
    
    public $username;
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->username = $this->Device->find('first', ['conditions' => ['ip' => $this->request->clientIp()]])['Device']['username'];   
    }
    public function isAuthorized($user) {
        return true;
    }

    private function setValues(){
        if ($this->RequestHandler->isMobile()){
            $this->set('mobile', 1);
        }
        $this->set('personal_list', $this->ShoppingList->find('all', ['conditions' => ['list' => $this->username]]));
        $this->set('flat_list', $this->ShoppingList->find('all', ['conditions' => ['list' => 'flat']]));
        $this->set('username', $this->username);
    }
    
    public function index(){
        $this->setValues();
    }
    
    public function addItem(){
        $this->autoRender = false;
        $this->layout = 'ajax';
        
        $data = array();
        $data['ShoppingList']['name'] = $this->request->data['name'];
        $data['ShoppingList']['quantity'] = $this->request->data['quantity'];
        $data['ShoppingList']['list'] = $this->request->data['list'];
        $this->ShoppingList->save($data);
                
        $this->setValues();
        
        $this->render('index');
    }
    
    public function clearList(){
        $this->autoRender = false;
        $this->layout = 'ajax';
        
        $this->ShoppingList->deleteAll(['list' => $this->request->data['list']]);
                
        $this->setValues();
        
        $this->render('index');
    }
    
    public function clearItem(){
        $this->autoRender = false;
        $this->layout = 'ajax';
        
        $this->ShoppingList->delete($this->request->data['id']);
                
        $this->setValues();
        
        $this->render('index');
    }

}
