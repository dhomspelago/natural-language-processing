<?php

namespace App\Http\Controllers;

use App\Http\Requests\NLPRequest;
use LanguageDetection\Language;
use PhpScience\TextRank\TextRankFacade;
use PhpScience\TextRank\Tool\StopWords\English;
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
        $api = new TextRankFacade();

        $stopWords = new English();

        $api->setStopWords($stopWords);

        return $api->summarizeTextBasic($text);
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
        $languages = ['zh', 'es', 'en', 'hi', 'ar', 'bn', 'pt', 'ru', 'ja', 'ko'];

        $detectLang = new Language($languages);

        $data = $detectLang->detect($text)->bestResults()->close();

        $key = array_keys($data);

        $lang = $key[0];

        $result = 'The language used in the content is ';

        switch ($lang) {
            case 'zh':
                $result .= "Chinese";
                break;
            case 'es':
                $result .= "Spanish";
                break;
            case 'en':
                $result .= "English";
                break;
            case 'hi':
                $result .= "Hindi";
                break;
            case 'ar':
                $result .= "Arabic";
                break;
            case 'bn':
                $result .= "Bengali";
                break;
            case 'pt':
                $result .= "Portuguese";
                break;
            case 'ru':
                $result .= "Russian";
                break;
            case 'ja':
                $result .= "Japan";
                break;
            case 'ko':
                $result .= "Korea";
                break;
        }

        return $result;
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
