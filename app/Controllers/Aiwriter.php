<?php namespace App\Controllers;


class Aiwriter extends BaseController{

  public function index(){
    $settings = $this->getSettings();
    if(!$settings){
      session()->setFlashdata('primary', 'Let\'s give OpenAi some settings to work with 😉.');
      return redirect()->to('/settings');
    }
    return view('article');
  }

}
?>