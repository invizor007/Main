<?php

class MyClass
{
    public $prop1 = "Я - свойство класса!";

    public function __construct()
    {
        echo 'Класс ' . __CLASS__ . ' был инстанцирован! (Был создан экземпляр класса)<br />';
    }

    public function setProperty($newval)
    {
        $this->prop1 = $newval;
    }

    public function getProperty()
    {
        return $this->prop1 . "<br />";
    }
}

// Создаем новый объект
$obj = new MyClass;

// Получаем значение свойства $prop1
echo $obj->getProperty();

// Выводим сообщение в конце файла
echo "Конец файла.<br />";

?>