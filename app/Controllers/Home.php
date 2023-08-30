<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index(){
        $settings = $this->getSettings();
        if($settings){
            return redirect()->to('/aiwriter');
        }
        return redirect()->to('/settings');
    }
}
