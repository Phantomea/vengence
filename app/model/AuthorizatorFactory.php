<?php

namespace App\Model;

use Nette,
    Nette\Security\Permission;

class AuthorizatorFactory extends Nette\Object {
    
    const ROLE_ADMIN = 'admin';
    const ROLE_PLAYER = 'player';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_GUEST = 'guest';
    const ROLE_BANNED = 'banned';

    public function create() {
        $acl = new Permission;


        //-----------ROLE-----------//
        $acl->addRole(self::ROLE_BANNED);
        $acl->addRole(self::ROLE_GUEST);
        $acl->addRole(self::ROLE_MODERATOR);
        $acl->addRole(self::ROLE_PLAYER, self::ROLE_GUEST);
        $acl->addRole(self::ROLE_ADMIN, self::ROLE_PLAYER);



        //-----------Resources----------(all templates)//
        $acl->addResource('Front:Homepage');
        $acl->addResource('Front:Sign');
        $acl->addResource('Front:Registration');
        
        $acl->addResource('Admin:Homepage');
        $acl->addResource('Admin:Sign');
        $acl->addResource('Admin:User');
        $acl->addResource('Admin:Menu');
        $acl->addResource('Admin:Item');
        $acl->addResource('Admin:Location');
        
        $acl->addResource('Game:Homepage');
        $acl->addResource('Game:Sign');
        $acl->addResource('Game:Location');


        //---------PRIRADENIE PRAV--------//
		
	$acl->allow(self::ROLE_BANNED, 'Front:Sign','in');
        
        $acl->allow(self::ROLE_GUEST, 'Admin:Sign','in');
        $acl->allow(self::ROLE_GUEST, 'Front:Sign','in');
        $acl->allow(self::ROLE_GUEST, 'Front:Registration');
        
        $acl->allow(self::ROLE_MODERATOR, 'Admin:Sign',array('in','out'));    
        $acl->allow(self::ROLE_MODERATOR, 'Admin:Homepage');
		
        $acl->allow(self::ROLE_PLAYER, 'Admin:Sign','in');
        $acl->allow(self::ROLE_PLAYER, 'Game:Homepage');
        $acl->allow(self::ROLE_PLAYER, 'Game:Sign','out');
        
        
        $acl->allow(self::ROLE_ADMIN, Permission::ALL, Permission::ALL);
        

        return $acl;
    } 
}