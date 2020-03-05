<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JoggApp\NaturalLanguage\NaturalLanguageClient;
use PhpScience\TextRank\TextRankFacade;
use PhpScience\TextRank\Tool\StopWords\English;
use Sentiment\Analyzer;


class NLPController extends Controller
{
    public function test()
    {

    }

    private function summarizeText($text)
    {
        $stopWords = get_stop_words(base_path() . '/vendor/yooper/stop-words/data/stop-words_english_1_en.txt');
        $stopWords = array_map(function ($word) {
            return " {$word} ";
        }, $stopWords);

        return summary_simple($text, $stopWords)[0];
    }

    private function analyzeTextSentiment($text)
    {
        $analyzer = new Analyzer();

        $array = $analyzer->getSentiment($text);

        array_pop($array);

        $highestSentiment = max($array);

        return array_search($highestSentiment, $analyzer->getSentiment($text));
    }
}
