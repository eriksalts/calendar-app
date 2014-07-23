<?php

class Note
{
    public function __construct($date, $title, $body)
    {
        $this->date = $date;
        $this->title = $title;
        $this->body = $body;
    }

    public function save()
    {
        $sql = "INSERT INTO notes (date, title, body) VALUES ($this->date,$this->title,$this->body);";
        $result = mysql::query('main', $sql);
        if(PEAR::isError($result))
        {
            return FALSE;
        }
        return true;
    }

}
?>