<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JoggApp\NaturalLanguage\NaturalLanguageClient;
use LanguageDetection\Language;
use PhpScience\TextRank\TextRankFacade;
use PhpScience\TextRank\Tool\StopWords\English;
use Sentiment\Analyzer;
use StanfordTagger\CRFClassifier;
use StanfordTagger\POSTagger;
use StanfordTagger\StanfordTagger;


class NLPController extends Controller
{
    public function test()
    {
        $text = 'Albert Einstein was a theoretical physicist born in Germany.';

        dd($this->classifyText($text));
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

    private function detectLanguage($text)
    {
        $detectLang = new Language(['zh', 'es', 'en', 'hi', 'ar', 'bn', 'pt', 'ru', 'ja']);

        return $detectLang->detect($text)->bestResults()->close();
    }

    private function classifyText($text)
    {
        $classify = new CRFClassifier();

        $classify->setOutputFormat(StanfordTagger::OUTPUT_FORMAT_TSV);

        $classify->setClassifier(base_path() . '/stanford-ner-2018-10-16/classifiers/english.all.3class.distsim.crf.ser.gz');

        $classify->setJarArchive(base_path() . '/stanford-ner-2018-10-16/stanford-ner.jar');

        return $classify->tag($text);
    }

    private function tsvConverter($content, $args = [])
    {
//        $fields = [
//            'header_row' => true,
//            'remove_header_row' => true,
//            'trim_headers' => true, //trim whitespace around header row values
//            'trim_values' => true, //trim whitespace around all non-header row values
//            'debug' => false, //set to true while testing if you run into troubles
//            'lb' => "\n", //line break character
//            'tab' => "\t", //tab character
//        ];
//        foreach ($fields as $key => $default) {
//            if (array_key_exists($key, $args)) {
//                $$key = $args[$key];
//            } else {
//                $$key = $default;
//            }
//        }


    }
}
