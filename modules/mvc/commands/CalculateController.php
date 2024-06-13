<?php

namespace app\modules\mvc\commands;

use app\helpers\Utils;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;

const ERROR_MSG = 'выполнение команды завершено с ошибкой' . PHP_EOL;

class CalculateController extends Controller
{
    public $month;
    public $type;
    public $tonnage;

    public function options($actionID)
    {
        return ['month', 'type', 'tonnage'];
    }

    private function printDecoration($lengths)
    {
        $decorateStr = '+';

        foreach ($lengths as $length) {
            $decorateStr .= str_repeat('-', $length + 2) . '+';
        }

        $decorateStr .= PHP_EOL;
        $this->stdout($decorateStr, Console::FG_GREEN);
    }

    private function printHeader($lengths)
    {
        $headerStr = '';

        foreach ($lengths as $header => $length) {
            $headerStr .= '| ' . $header . ' ' . str_repeat(' ', $length - mb_strlen($header));
        }

        $headerStr .= '|' . PHP_EOL;
        $this->stdout($headerStr, Console::FG_GREEN);
    }

    private function printRow($first, $row, $lengths)
    {
        $rowStr = '| ' . $first . ' ' . str_repeat(' ', $lengths['м/т'] - mb_strlen($first));

        foreach ($row as $month => $price) {
            $rowStr .= '| '. $price . ' ' . str_repeat(' ', $lengths[$month] - mb_strlen($price));
        }

        $rowStr .= '|' . PHP_EOL;
        $this->stdout($rowStr, Console::FG_GREEN);
    }

    private function printTable($arr)
    {
        $lengths = Utils::getLengths($arr);
        $this->printDecoration($lengths);
        $this->printHeader($lengths);

        foreach ($arr as $key => $row) {
            $this->printDecoration($lengths);
            $this->printRow($key, $row, $lengths);
        }

        $this->printDecoration($lengths);
    }

    public function actionIndex()
    {
        $res = 0;
        $errors = [];
        $prices = Yii::$app->params['prices'];

        $errors[] = ERROR_MSG;

        if (empty($this->month)) {
            $errors[] = "необходимо ввести месяц\n";
            $res = 1;
        }

        if (empty($this->type)) {
            $errors[] = "необходимо ввести тип сырья\n";
            $res = 1;
        }

        if (empty($this->tonnage)) {
            $errors[] = "необходимо ввести тоннаж\n";
            $res = 1;
        }

        if ($res === 0) {
            $type = mb_convert_case($this->type, MB_CASE_LOWER, 'UTF-8');
            $month = mb_convert_case($this->month, MB_CASE_LOWER, 'UTF-8');

            if (!isset($prices[$type])) {
                $errors[] = "не найдено сырьё {$this->type}\n";
                $res = 1;
            } elseif (!isset($prices[$type][$month])) {
                $errors[] = "не найден месяц {$this->month}\n";
                $res = 1;
            } elseif (!isset($prices[$type][$month][$this->tonnage])) {
                $errors[] = "не найден прайс для значения --tonnage={$this->tonnage}\n";
                $res = 1;
            }

            if ($res !== 0) {
                $errors[] = "проверьте корректность введённых значений\n";
            }
        }

        if ($res !== 0) {

            foreach ($errors as $error) {
                $this->stdout($error, Console::FG_RED);
            }

            return $res;
        }

        echo 'введённые параметры:' . PHP_EOL;
        echo 'месяц - ' . $month. PHP_EOL;
        echo 'тип - ' . $type. PHP_EOL;
        echo 'тоннаж - ' . $this->tonnage . PHP_EOL;
        echo 'результат - ' . $prices[$type][$month][$this->tonnage] . PHP_EOL;

        $MTTable = Utils::getMonthTonnageTable($prices[$this->type]);
        $this->printTable($MTTable);

        return 0;
    }
}
