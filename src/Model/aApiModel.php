<?php

namespace Militer\mvcCore\Model;

abstract class aApiModel extends aModel
{
    protected string $popupsTable;
    protected string $views;


    public function __construct()
    {
        parent::__construct();
    }


    protected function renderPopup(string $popup)
    {
        // $popupFile = $this->getPopup($popup);
        $popup = \lcfirst(\str_replace('-', '', \ucwords($popup, '-')));
        $popup = "{$this->views}/popups/{$popup}.php";
        if (\file_exists($popup)) {
            \ob_start();
            require $popup;
            $popup = \ob_get_clean();
            $this->Response->sendPopup($popup);
        } else {
            $this->Response->badRequestMessage();
        }
    }
    private function getPopup(string $popup)
    {
        $sql = "SELECT `file` FROM `{$this->popupsTable}` WHERE `name`='{$popup}'";
        return self::$PDO::queryFetchColumn($sql);
    }
}
