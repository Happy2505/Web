<?php
require_once 'logic.php';
require_once 'text.php';
$textData = $_POST;
$resultText = "";
$html = "";

$handle1 = "https://ru.wikipedia.org/wiki/Киноринхи";
$handle2 = "https://echo.msk.ru/programs/sorokina/2917870-echo/";
$handle3 = "https://mishka-knizhka.ru/skazki-dlay-detey/zarubezhnye-skazochniki/skazki-alana-milna/vinni-puh-i-vse-vse-vse/#glava-pervaya-v-kotoroj-my-znakomimsya-s-vinni-puhom-i-neskolkimi-pchy";
if (isset($_GET["preset"]) == "1") {
    $inputText = file_get_contents($handle1);

} elseif (isset($_GET["preset"]) == "2") {
    $inputText = file_get_contents($handle2);

} elseif (isset($_GET["preset"]) == "3") {
    $inputText = file_get_contents($handle3);
} elseif (isset($_GET["preset"]) == "") {
    $inputText = "";
}

if (isset($textData['doText'])) {
    $inputText = $textData['text'];
}
$internalErrors = libxml_use_internal_errors(true);
$resultText = AddHyphensToPrepositions($inputText);
$resultText = MuteWrongsWords($resultText);
$resultText = makeTableList($resultText);
$resultText = FindLongest($resultText);


function FindLongest($text)
{
    $link = 'automaticallyGeneratedLinkForP';
    $doc = new DOMDocument();
    $doc->loadHTML($text);
    $p_list = $doc->getElementsByTagName('p');
    $len = 0;
    $i = 0;
    if ($p_list->length > 0) {
        $theLongest = $doc->createElement('div');
        $doc->insertBefore($theLongest, $doc->firstChild);
        $p = $doc->createElement('p');
        $theLongest->appendChild($p);
        $a = $doc->createElement('a');
        $p->appendChild($a);
        while ($test = $p_list->item($i++)) {
            if (strlen($test->nodeValue) > $len) {
                $len = strlen($test->nodeValue);
                $theLongest = $test->nodeValue;
                if ($test->attributes && $test->attributes->getNamedItem('id')) {//Если у таблицы есть id, берем его
                    $linkVal = $test->attributes->getNamedItem('id')->value;
                } else {//Иначе добавляем ей новый
                    $linkVal = $link . $i;
                    $test->setAttribute('id', $linkVal);
                }

                $a->setAttribute('href', '#' . $linkVal);

            }
        }
        $arr = explode(".", $theLongest);
        $len = 0;
        foreach ($arr as $i) {
//            echo $i . "<br>";
            if (strlen($i) > $len) {
                $theLongest123 = $i;
                $len = strlen($i);
            }
        }
        $a->nodeValue = "...";

        $p->nodeValue = mb_substr($theLongest123, 0, 80);
        $p->appendChild($a);
    }
    $text = html_entity_decode($doc->saveHTML());
    $text = mb_convert_encoding($text, 'HTML-ENTITIES', 'utf-8');
    return $text;
}

function makeTableList($text)
{
    $link = 'automaticallyGeneratedLink';
    $doc = new DOMDocument();
    $doc->loadHTML($text);
    $tables = $doc->getElementsByTagName('table');//Находим все таблицы
    $i = 0;
    if ($tables->length > 0) {
        $tableList = $doc->createElement('ul');
        $doc->insertBefore($tableList, $doc->firstChild);
        while ($table = $tables->item($i++)) {
            $li = $doc->createElement('li');
            $tableList->appendChild($li);
            $a = $doc->createElement('a');
            $li->appendChild($a);

            /*Добавляем id к таблице для формирования ссылки на нее*/
            if ($table->attributes && $table->attributes->getNamedItem('id')) {//Если у таблицы есть id, берем его
                $linkVal = $table->attributes->getNamedItem('id')->value;
            } else {//Иначе добавляем ей новый
                $linkVal = $link . $i;
                $table->setAttribute('id', $linkVal);
            }

            $a->setAttribute('href', '#' . $linkVal);
            $linkText = lookForFirstCellText($table);
            if ($linkText) {
                $a->nodeValue = $linkText;
            }
        }
    }
    $text = html_entity_decode($doc->saveHTML());
    $text = mb_convert_encoding($text, 'HTML-ENTITIES', 'utf-8');
    return $text;
}

function lookForFirstCellText($node)
{//Используя поиск в глубину (через рекурсию), находим текст первой ячейки таблицы
    if ($node->nodeName == 'td' || $node->nodeName == 'th') {
        return $node->nodeValue;
    } else if ($node->hasChildNodes()) {
        foreach ($node->childNodes as $childNode) {
            $result = lookForFirstCellText($childNode);
            if ($result) {
                return $result;
            }
        }
    }
    return false;
}

function AddHyphensToPrepositions($htmlText)
{
    $resultText = "";
    $htmlText = str_replace(array(" то", " ка", " де", " кась", "из под",),
        array("-то", "-ка", "-де", "-кась", "из-под"),
        $htmlText);
    return $htmlText;
}

function MuteWrongsWords($htmlText)
{
    $patterns = array("/рот[а-я]/gm", "/пух[а-я]/gm", "/делать[а-я]/gm", "/ехать[а-я]/gm", "/около[а-я]/gm",
        "/Для[а-я]/gm", "/Рот[а-я]/gm", "/Пух[а-я]/gm", "/Делать[а-я]/gm", "/Ехать[а-я]/gm", "/Около[а-я]/gm", "/Для[а-я]/gm");
    $replacements = array(" ###", " ###", " ######", " #####", " #####", " ###", " ###", " ###", " ######", " #####", " #####", " ###");
    $htmlText = preg_filter($patterns, $replacements, $htmlText);
    return $htmlText;
}
