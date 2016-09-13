<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
            $router = new RouteList();
            
            $router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);

            $router[] = new Route('game/<presenter>/<action>/<id>', array(
                'module' => 'Game',
                'presenter' => 'Homepage',
                'action' => 'default',
                'id' => 'home',
            ));
            
            $router[] = new Route('admin/<presenter>/<action>/<id>', array(
                'module' => 'Admin',
                'presenter' => 'Homepage',
                'action' => 'default',
                'id' => NULL,
            ));
            
            $router[] = new Route('<presenter>/<action>/<id>', array(
                'module' => 'Front',
                'presenter' => 'Homepage',
                'action' => 'default',
                'id' => NULL,
            ));

            return $router;
	}

}
