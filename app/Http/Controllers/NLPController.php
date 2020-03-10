<?php

namespace App\Http\Controllers;

use App\Http\Requests\NLPRequest;
use LanguageDetection\Language;
use Sentiment\Analyzer;
use StanfordTagger\CRFClassifier;
use StanfordTagger\StanfordTagger;


class NLPController extends Controller
{
    public function analyze(NLPRequest $request)
    {
        switch (strtolower($request->get('type'))) {
            case 'summarize':
                return $this->summarizeText($request->get('text'));
            case 'sentiment':
                return $this->analyzeTextSentiment($request->get('text'));
            case 'language':
                return $this->detectLanguage($request->get('text'));
            case 'categorize':
                return $this->tsvConverter($this->classifyText($request->get('text')));
        }
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
        $detectLang = new Language(['zh', 'es', 'en', 'hi', 'ar', 'bn', 'pt', 'ru', 'ja', 'ko']);

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

    private function tsvConverter($text)
    {
        $array = tokenize($text);

        $keys = [];

        $data = [];

        $finalData = [];

        foreach ($array as $k => $v) {
            if ($k % 2 == 0) {
                $data[] = $v;
            } else {
                $keys[] = $v;
            }
        }

        foreach ($data as $k => $datum) {
            $finalData[] = [
                'data' => $datum,
                'type' => $keys[$k],
            ];
        }

        return $finalData;
    }
}
