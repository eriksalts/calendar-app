<?php

class note_controller extends base_controller
{

    public function submit()
    {
        if (!empty($_POST['title'])) {
            $note = new Note($_POST['date'], $_POST['title'], $_POST['body']);
            $note->save();

        }
    }
}

?>