<?php

namespace Php\Utils\PhpBaseController;
/**
 * 基类控制器
 * @author <fman@qq.com>
 * @date   2018-08-17 11:01
 * 入库文件要定义日志存储常量 LOG_PATH
 */
use Php\Utils\Log\Logger;

class PhpBaseController
{
    public static $startTime;

    public function __construct()
    {
        self::$startTime = microtime();

        //注册一个PHP终止时执行的函数
        register_shutdown_function(array($this, 'writeLog'));
    }

    public function writeLog()
    {
        error_reporting(0);
        $msg = error_get_last();
        $log = new Logger(LOG_PATH);
        if (empty($msg)) {
            $endTime = explode(' ',microtime());
            $starTtime = explode(' ',self::$startTime);
            $runTime = $endTime[0]+$endTime[1]-($starTtime[0]+$starTtime[1]);
            $runTime = round($runTime,3);
            $content = 'url:' . $_SERVER['REQUEST_URI'] . ' 用时：'. $runTime . '秒';
            $log::notice($content);
            return;
        }

        $content = 'url:' . $_SERVER['REQUEST_URI']
            . ' file:' . $msg['file']
            . ' line:' . $msg['line']
            . ' message:' . $msg['message'];

        //根据PHP 内部编号区分错误等级
        switch ($msg['type']) {
            case 2:
                $log::warning($content);
                break;
            case 8:
                $log::notice($content);
                break;
            case 32:
            case 128:
            case 512:
            case 1024:
               $log::notice($content);
                break;
            case 1:
                $log::error($content);
                break;
            case 4:
            case 16:
            case 64:
            case 256:
                $log::error($content);
                break;
            default:
                $log::error($content);
                break;
        }
        return;
    }

}
