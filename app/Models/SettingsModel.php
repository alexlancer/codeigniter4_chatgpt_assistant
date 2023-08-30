<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $allowedFields = ['id', 'behavior', 'append', 'model', 'temperature', 'tokens', 'created_at', 'updated_at'];
    protected $returnType = 'object';
    protected $useTimestamps = true;
    protected $validationRules;

    public function __construct() {
        parent::__construct();
        $this->validationRules = [
                'behavior' => 'required',
                'append' => 'required',
                'model' => 'required|in_list[' . implode(',', OPEN_AI_MODELS) . ']',
                'tokens' => 'required|is_numeric',
                'temperature' => 'required|greater_than_equal_to[0]|less_than_equal_to[1]|max_length[3]',
            ];
    }
}
 

?>