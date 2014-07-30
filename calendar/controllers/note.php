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
            //$sql = "INSERT INTO notes (date, title, body) VALUES (\"$this->date\",\"$this->title\",\"$this->body\");";
            $result = mysql::query('main', $sql);
            return $result;
        }
    }

    public function submit()
    {
        $this->debug = 'test2';
        if (!empty($_POST['title'])) {

            $note = new Note($_POST['date'], $_POST['title'], $_POST['body']);

            $note->save();

        }
    }
}

?>