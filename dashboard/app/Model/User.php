<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP UserModel
 * @author Andrew
 */
class User extends AppModel {

    public function find($type = 'first', $query = array()) {
        if ($type === 'login'){
            return $query['password'] === parent::find('first', ['conditions' => ['username' => $query['username']]])['User']['password'];
        }
        return parent::find($type, $query);
    }
}
