<?php

declare(strict_types=1);

/**
 * @author  Jagepard <jagepard@yandex.ru">
 * @license https://mit-license.org/ MIT
 */

namespace Rudra\Annotation;

class AnnotationMatcher
{
    /**
     * @param array $exploded
     * @param string $assignment
     * @return array
     *
     * Parses parameters by key (assignment) value
     * and returns an array of parameters
     * ----------------------------------
     * Анализирует параметры по значению ключа (присваивания)
     * и возвращает массив параметров
     */
    public function getParams(array $exploded, string $assignment): array
    {
        $i = 0;
        $processed = [];

        foreach ($exploded as $item) {
            if (str_contains($item, $assignment)) {
                $item = $this->handleData($item, explode($assignment, $item));
            }
            (is_array($item)) ? $processed[key($item)] = $item[key($item)] : $processed[$i] = $item;
            $i++;
        }

        return $processed;
    }

    /**
     * @param string $data
     * @param array $exploded
     * @return ?array
     *
     * Parses data into key => value pairs
     * -----------------------------------
     * Разбирает данные в пары ключ => значение
     */
    private function handleData(string $data, array $exploded): ?array
    {
        /*
         * If in data an array of type address = {country : 'Russia'; state : 'Tambov'}
         * ----------------------------------------------------------------------------
         * Если в данных массив типа адрес = {страна: 'Россия'; состояние: 'Тамбов'}
         */
        if (preg_match("/=[\s]+{/", $data) && preg_match("/{(.*)}/", $exploded[1], $dataMatch)) {
            return [
                trim($exploded[0]) => $this->getParams(
                    explode(Annotation::DELIMITER["array"], trim($dataMatch[1])),
                    Annotation::ASSIGNMENT["array"]
                ),
            ];
        }

        /*
         * Remove quotation marks around parameter
         * ---------------------------------------
         * Убрирает кавычки вокруг параметра
         */
        if (preg_match("/'(.*)'/", $exploded[1], $dataMatch)) {
            return [trim($exploded[0]) => $dataMatch[1]];
        }
    } // @codeCoverageIgnore
}
