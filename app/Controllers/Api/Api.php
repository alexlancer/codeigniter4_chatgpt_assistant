<?php namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController{

  use ResponseTrait;

  public function openai(){
    $settings = $this->getSettings();
    if(!$settings){
      return $this->respond(ajaxData(true,[], 'No settings have been specified'));
    }
    if(!$prompt = $this->request->getPost('prompt')){
      return $this->respond(ajaxData(true,[], 'No prompt has been specified'));
    }
    $apiKey = getenv('OPENAI_API_KEY');
    $openai_base_url = 'https://api.openai.com/v1/chat/completions';
    $append = $settings->append;
    $behavior = $settings->behavior;

    $prompt = trim($prompt);
    $prompt = rtrim($prompt, '.');
    $prompt .= '. '; 

    $final_prompt = 'Write an article about: ' . $prompt . $append;
    $data = [
      'model' => $settings->model,
      'messages' => [
        [
          "role" => "system",
          "content" => $behavior
        ],
        [
          "role" => "user",
          "content" => $final_prompt,
        ],
      ],
      'temperature' =>  (int) $settings->temperature,
      'max_tokens' => (int) $settings->tokens,
      'frequency_penalty' => 0,
      'presence_penalty' => 0,
    ];

    $headers = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $apiKey
    ];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $openai_base_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    if ($error) {
      return $this->respond(ajaxData(true, [], $this->getAlert('danger', 'Error: ' . $error)));
    } else {
      $responseData = json_decode($response, true);
      if($responseData['error'] ?? false){
        return $this->respond(ajaxData(true, [], $this->getAlert('danger', $responseData['error']['message'])));
      }
    // echo '<pre>';
    //  print_r($responseData['choices'][0]['message']['content']);
    // echo '</pre>';
      if($responseData['choices'][0] ?? false){
        $choice = $responseData['choices'][0];
        $message = '';
        $finish_reason = $responseData['choices'][0]['finish_reason'];
        
        //Check if the article was completed by Open AI
        if( $finish_reason != 'stop'){
          $message = $this->getAlert('warning', 'The article was not completed due to some limitation. Finish reason: ' . $finish_reason);
        }

        //Check if the response is a valid JSON
        $content = $choice['message']['content'];
        $content = str_replace('\n', '', $content);
        $content = str_replace(PHP_EOL, '', $content);
        $invalidJson = invalidJson($content);
        $choice['message']['content'] = $content;
        if($invalidJson){
          $invalidJson = invalidJson($content);
          if($invalidJson){
            return $this->respond(ajaxData(true, $choice, $this->getAlert('danger', 'Invalid JSON response: ' . $invalidJson)));
          }
        }
        
        return $this->respond(ajaxData(false, $choice, $message));
      }

      return $this->respond(ajaxData(true, [], $this->getAlert('danger', 'No response data')));
    }

  }

  public function pexels(){
    //create curl get request with authorization header

    $pexel_base_url = 'https://api.pexels.com/v1/search?query=';
    $images_per_page = 10;
    $apiKey = getenv('PEXELS_API_KEY');

    $query = $this->request->getPost('query');
    
    $bad_query = $this->getAlert('danger', 'No search terms have been specified');
    if(!$query){
      return $this->respond(ajaxData(true,[], $bad_query));
    }
    $validated_query = trim($query);
    $validated_query = str_replace('+', '', $validated_query);
    if(!$validated_query){
      return $this->respond(ajaxData(true,[], $bad_query));
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $pexel_base_url . $validated_query . '&per_page=' . $images_per_page);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: ' . $apiKey
    ));

    $response = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);

    if($error){
      return $this->respond(ajaxData(true,[], $this->getAlert('danger', 'Error: ' . $error)));
    }
    $responseData = json_decode($response, true);
    if($responseData['error'] ?? false){
      return $this->respond(ajaxData(true,[], $this->getAlert('danger', $responseData['error'])));
    }

    $photos = $responseData['photos'];
    if(!$photos){
      return $this->respond(ajaxData(true,[], $this->getAlert('danger', 'No photos found')));
    }
    $data = [
      'photos' => $photos,
      'query' => $validated_query,
      'url' => $pexel_base_url . $validated_query
    ];
    $message = view('gallery', ['photos' => $photos]);
    return $this->respond(ajaxData(false, $data, $message));

  }

  private function getAlert($type, $message){
    return view('components/alert', [
      'type' => $type,
      'message' => $message
    ]);
  }
}
?>