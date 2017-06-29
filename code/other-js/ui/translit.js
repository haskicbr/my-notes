/**
 * Created by PhpStorm.
 * User: Haskicbr
 * Date: 14.09.2016
 * Time: 13:12
 */


$.fn.Translit = function (str) {

    var str = str.split('');

    symbols = {
        'а': 'a',
        'б': 'b',
        'в': 'v',
        'г': 'g',
        'д': 'd',
        'е': 'e',
        'ё': 'jo',
        'ж': 'zh',
        'з': 'z',
        'и': 'i',
        'й': 'j',
        'к': 'k',
        'л': 'l',
        'м': 'm',
        'н': 'n',
        'о': 'o',
        'п': 'p',
        'р': 'r',
        'с': 's',
        'т': 't',
        'у': 'u',
        'ф': 'f',
        'х': 'h',
        'ц': 'c',
        'ч': 'ch',
        'ш': 'sh',
        'щ': 'sch',
        'ъ': '',
        'ы': 'y',
        'ь': '',
        'э': 'e',
        'ю': 'ju',
        'я': 'ja',
        'і': 'i',
        'ї': 'i',
        'є': 'e',
        'А': 'A',
        'Б': 'B',
        'В': 'V',
        'Г': 'G',
        'Д': 'D',
        'Е': 'E',
        'Ё': 'Jo',
        'Ж': 'Zh',
        'З': 'Z',
        'И': 'I',
        'Й': 'J',
        'К': 'K',
        'Л': 'L',
        'М': 'M',
        'Н': 'N',
        'О': 'O',
        'П': 'P',
        'Р': 'R',
        'С': 'S',
        'Т': 'T',
        'У': 'U',
        'Ф': 'F',
        'Х': 'H',
        'Ц': 'C',
        'Ч': 'Ch',
        'Ш': 'Sh',
        'Щ': 'Sch',
        'Ъ': '',
        'Ы': 'Y',
        'Ь': '',
        'Э': 'E',
        'Ю': 'Ju',
        'Я': 'Ja',
        'І': 'I',
        'Ї': 'I',
        'Є': 'E',
        ' ': ' '
    };

    var transliteString = '';

    str.forEach(function (symbol) {

        if (symbols.hasOwnProperty(symbol)) {
            transliteString += symbols[symbol];
        } else {
            transliteString += symbol;
        }
    });

    return transliteString;
};

