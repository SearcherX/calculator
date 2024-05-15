<?php
function getSelectedAttributeOnInputCondition(
    array  $input,
    string $inputName,
    mixed  $condition,
    bool   $asInt = false
): ?string
{
    if (isset($input[$inputName]) === false) {
        return null;
    }

    $condition = $asInt === true ? (int)$condition : (string)$condition;

    if ($input[$inputName] !== $condition) {
        return null;
    }

    return 'selected';

}

function getPriceTonnages(string $rawType, array $prices): array {

    if (isset($prices[$rawType]) === true) {

        $firstMonth = array_key_first($prices[$rawType]);

        return array_keys($prices[$rawType][$firstMonth]);
    }

    throw new \LogicException('Стоимости для типа сырья ' . $rawType . ' отсутствуют');
}

function getBorderClass($month, $tonnage, $postMonth, $postTonnage): string
{
    if ($month === mb_strtolower($postMonth) && $tonnage === (int)$postTonnage) {
        return 'with-border';
    }

    return ' ';
}

function getDropDownArray(array $arr): array
{
    $values = array_map(function ($str) {
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    }, $arr);
    return array_combine($arr, $values);
}