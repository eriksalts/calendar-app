<?php

class note_controller extends base_controller
{
    public function index()
    {
        if ($_POST['action'] == 'new') {
            $note = new Note($_POST['date'], $_POST['title'], $_POST['body']);
            $note->save();
            return 'saved';
        }
        if ($_POST['action'] == 'delete') {
            $id = $_POST['id'];
            $sql = "DELETE FROM notes WHERE id=$id;";
            $result = mysql::query('main', $sql);
            return $result;
        }

    }

    public function submit()
    {



    }
}

?>