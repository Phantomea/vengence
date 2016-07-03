<?php

namespace App\Model;

use Nette,
    Nette\Security\Permission;

class AuthorizatorFactory extends Nette\Object {
    
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_GUEST = 'guest';
    const ROLE_BANNED = 'banned';

    public function create() {
        $acl = new Permission;


        //-----------ROLE-----------//
        $acl->addRole(self::ROLE_GUEST);
        $acl->addRole(self::ROLE_BANNED);
        $acl->addRole(self::ROLE_USER, self::ROLE_GUEST);
        $acl->addRole(self::ROLE_ADMIN, self::ROLE_USER);



        //------ZDROJE----------(templates)//
        $acl->addResource('Homepage');
        $acl->addResource('Sign');


        //------PRIRADENIE PRAV--------//
        $acl->allow(self::ROLE_BANNED, 'Homepage');
        $acl->allow(self::ROLE_GUEST, 'Sign','in');
        $acl->allow(self::ROLE_USER, 'Sign',array('in','out'));/*
        $acl->allow(self::ROLE_USER, 'Project',array('default','detail'));
        $acl->allow(self::ROLE_USER, 'Customer',array('default','detail'));
        $acl->allow(self::ROLE_USER, 'User',array('default','detail','edit'));
        $acl->allow(self::ROLE_USER, 'Team',array('default','detail'));     */   
        
        $acl->allow(self::ROLE_ADMIN, Permission::ALL, Permission::ALL);

        return $acl;
    } 
}