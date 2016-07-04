<?php

namespace App\Presenters;

use Nette;
use App\Model;
use App\Model\UserManager;


class HomepagePresenter extends BasePresenter
{  
    private $userManager;
    
    
    public function __construct(UserManager $um) {
        parent::__construct();
        $this->userManager = $um;
    }
    public function renderDefault() {
        $user = $this->userManager->getUserById($this->user->getId());
        $loggedIn = $this->user->loggedIn;
        if($loggedIn){
            $player = $user->player;
            $gear = $this->userManager->getUserGearById($user->id_user);
            $level = $this->getUserLevelById($user->id_user);
            $neededExp = $this->getNeededExperiences($user->id_user);
            $this->template->player = $player;
            $this->template->user = $user;
            $this->template->level = $level;
            $this->template->gear = $gear;
            $this->template->neededExp = $neededExp;
            \Tracy\Debugger::barDump($gear);
        } else {
            $this->redirect('Sign:in');
        }
    }
    
    public function getUserLevelById($id){
        $maxLevel = 100;
        $maxExp = 100000;
        $by = $maxExp / $maxLevel;
        $current = $maxExp - $by;
        $level = 0;
        $exp = $this->userManager->getUserLevelById($id);
        $exp = $exp->experiences;
        if(($exp>$maxExp)||($exp==$maxExp)){
            $exp = $maxExp;
        } else {
            do {
                $maxLevel = floor($maxLevel-1);
                $maxExp = $current;
                $current -= $by;
            } while(!($exp >= $maxExp));
        }
        return $maxLevel;
    }
    
    public function getNeededExperiences($id){
        $maxLevel = 100;
        $maxExp = 135000;
        $by = $maxExp / $maxLevel;
        $current = $maxExp - $by;
        $level = 0;
        $exp = $this->userManager->getUserLevelById($id);
        $exp = $exp->experiences;
        if(($exp>$maxExp)||($exp==$maxExp)){
            $exp = $maxExp;
        } else {
            do {
                $needed = $maxExp;
                $maxLevel = floor($maxLevel-1);
                $maxExp = $current;
                $current -= $by;
            } while(!($exp >= $maxExp));
        }
        return $needed;
    }

}
