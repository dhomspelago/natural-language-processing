<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JoggApp\NaturalLanguage\NaturalLanguageClient;

/**
 * @property NaturalLanguageClient lang
 */
class NLPController extends Controller
{
    public function __construct()
    {
        $config = [
            'project_id' => 'unified-ring-270003',
            'key_file_path' => base_path('secret.json'),
        ];

        $this->lang = new NaturalLanguageClient($config);
    }
}
