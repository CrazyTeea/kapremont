<?php


namespace app\facades;

use app\models\Exceptions;
use Exception;
use Yii;

class ExceptionLogger
{
    protected $user_id;

    protected $description;

    protected $exception_message;

    protected $class_name;

    protected $method;

    protected $extra_info;

    public function __construct(Exception $e, array $params)
    {
        $this->exception_message = $e->getMessage();
        $this->user_id = Yii::$app->user->id;
        $this->description = $params['description'] ?? null;
        $this->class_name = $params['class'] ?? null;
        $this->method = $params['method'] ?? null;
        $this->extra_info = $params['extra_info'] ?? null;

        $this->log();
    }

    private function log()
    {
        $exceptionLog = new Exceptions();
        $exceptionLog->exception_message = $this->exception_message;
        $exceptionLog->description = $this->description;
        $exceptionLog->class_name = $this->class_name;
        $exceptionLog->method = $this->method;
        $exceptionLog->id_user = $this->user_id;
        $exceptionLog->date_time = new \DateTime();
        $exceptionLog->extra_info = $this->extra_info;

        $exceptionLog->save();
    }

}