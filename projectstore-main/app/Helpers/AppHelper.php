<?php
namespace App\Helpers;

class AppHelper
{
    /**
     * Функция обрезки слов до указанного кол-ва и приписывание в конце ...
     * используется, чтобы не было слишком длинных слов и чтобы верстка не ломалась (afjsdioprayqhpweqjfwerweruwio)
     * В скобках пример нежелательного слова
     * @param string $input
     * @param int $maxWordLength
     * @param string $endLetters
     * @return string
     */

    public static function truncate(string $input, int $maxWordLength = 24, string $endLetters = '...')
    {
    //    $completedWords = array();
        foreach (preg_split('/\s+/', $input) as $word) // обрезка предолжения по словам через пробел и
            // присваивание каждому слову $word
        {
            if (mb_strlen($word) > $maxWordLength)
                $completedWords[] = mb_substr($word, 0, $maxWordLength) . $endLetters;
            else
                $completedWords[] = $word;
        }
       // return str_replace('<', '&lt;', implode(' ', $completedWords));
        return implode(' ', $completedWords);
    }

    /**
     * Усечение текста до первого перенса. Если кол-во символов до первого переноса больше, чем $length_substr, то
     * берется $length_substr
     * @param string $str
     * @param int $length_substr
     * @return string
     */

    public static function truncate_break(string $str, int $length_substr) {
        $cut_len = null;

        if(preg_match("/[^\r\n]*/u", $str, $matches, PREG_OFFSET_CAPTURE)) {
            $cut_len = min(mb_strlen($matches[0][0]),$length_substr);

            return mb_substr($str,0,$cut_len,'UTF-8');
        }
        else {
            return mb_substr($str,0,$length_substr,'UTF-8');
        }
    }

    /**
     * Функция обрезки слова слева направо (в обратном порядке)
     * используется для обрезки e-mail адреса в карточке кандидата
     * @param string $string
     * @param int $length
     * @return false|string
     */

    public static function getSubstringFromEnd(string $string, int $length)
    {
        return substr($string, strlen($string) - $length, $length);
    }
}
