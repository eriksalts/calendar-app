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
//        if ($_POST['action'] == 'delete') {
//            $note = DELETE FROM add_delete_record WHERE id="note"
//        }
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