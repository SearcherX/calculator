<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\modules\mvc\commands;

use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $counter = 0;
        $basePath = Yii::getAlias('@runtime') . '/queue.job';

        while (true) {
            $counter++;
            echo 'Количество итераций запуска инструкции чтения файла: ' . $counter . PHP_EOL;

            if (file_exists($basePath)) {
                $data = file_get_contents($basePath);
                echo $data;
                unlink($basePath);
            }

            sleep(2);
        }
    }
}
