<?php namespace App\Controllers;

use App\Models\SettingsModel;

class Settings extends BaseController{

  public function index(){
    
    $settings = $this->getSettings();

    //if request is post, then create or update settings
    if($this->request->getMethod() == 'post'){
      return $this->update();
    }

    $data = [
      'behavior' => '',
      'append' => '',
      'model' => '',
      'tokens' => '',
      'temperature' => '',
    ];

    if($settings){
      $data = (array) $settings;
    }
    
    
    return view('settings/form', $data);

   
  }

  private function update(){
    $settings = $this->getSettings();

    $data = [
      'behavior' => $this->request->getVar('behavior') ,
      'append' => $this->request->getVar('append') ,
      'model' => $this->request->getVar('model'),
      'tokens' => $this->request->getVar('tokens') ,
      'temperature' => $this->request->getVar('temperature') ,
    ];
    
    $settings_model = new SettingsModel();
    if($settings){
      $data['id'] = $settings->id;
      $response = $settings_model->save($data);
    }else{
      $response = $settings_model->insert($data);
    }
    if(!$response){
      $errors_arr = $settings_model->errors();
      $error_str = implode(' ', $errors_arr);
      session()->setFlashdata('danger', $error_str);
    }else{
      session()->setFlashdata('success', 'Settings have been updated.');
    }
    return redirect()->to('/settings')->withInput();
  }


  
}
 ?>