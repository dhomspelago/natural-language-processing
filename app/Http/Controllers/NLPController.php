<?php

namespace App\Http\Controllers;

use App\Http\Requests\NLPRequest;
use LanguageDetection\Language;
use PhpScience\TextRank\TextRankFacade;
use PhpScience\TextRank\Tool\StopWords\English;
use Sentiment\Analyzer;


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

        return $analyzer->getSentiment($text);
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
                $result .= "Chinese.";
                break;
            case 'es':
                $result .= "Spanish.";
                break;
            case 'en':
                $result .= "English.";
                break;
            case 'hi':
                $result .= "Hindi.";
                break;
            case 'ar':
                $result .= "Arabic.";
                break;
            case 'bn':
                $result .= "Bengali.";
                break;
            case 'pt':
                $result .= "Portuguese.";
                break;
            case 'ru':
                $result .= "Russian.";
                break;
            case 'ja':
                $result .= "Japanese.";
                break;
            case 'ko':
                $result .= "Korea.";
                break;
        }

        return $result;
    }
}
