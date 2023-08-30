<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    protected $table = 'settings';
    public function up()
    {
        //create table with columns:'id', 'behavior' as text, 'append' as text, 'model' enum with some values, 'temperature' min 0 max 1, step 0.1, 'created_at' is  current timestamp, 'updated_at'
        
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false,
            ],
            'behavior' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'append' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'model' => [
                'type' => 'ENUM',
                'constraint' => OPEN_AI_MODELS,
                'null' => false,
            ],
            'temperature' => [
                'type' => 'DECIMAL',
                'constraint' => '2,1',
                'null' => false,
            ],
            'tokens' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        //create the table 
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->table);
        //insert default values

        

        
    }

    public function down()
    {
       $this->forge->dropTable($this->table);
    }
}
