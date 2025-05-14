<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LanguageDetection\Language;
use LanguageDetection\Tokenizer\TokenizerInterface;

class AvatarController extends Controller
{
    public function __invoke(Request $request)
    {
      $inputValue = $request->inputValue;
      $languageDetection = new Language(['vi','en','ja','km']);
      $languageDetection->setTokenizer(new class implements TokenizerInterface
      {
        public function tokenize(string $str): array
        {
          return preg_split('/[^a-z0-9]/u', $str, -1, PREG_SPLIT_NO_EMPTY);
        }
      });
      $arrayDetect = $languageDetection->detect($inputValue)->whitelist('vi','en','ja','km')->close();
    }
}
