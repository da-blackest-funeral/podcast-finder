<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
    use HasFactory;

    protected $mappingProperties = [
        'text_contents' => [
            'type' => 'string',
            'analyzer' => 'standard',
        ],
    ];

    public function process()
    {
        //
    }

    public static function createExample()
    {
        $instance = new static;
        $instance->user_id = 1;
        $instance->uploaded_file_name = 'example.mp3';

        $instance->save();

        return $instance;
    }
}
