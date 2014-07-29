<?php

class index_controller extends base_controller
{


	public function index()
	{

//        $month_display = date('n');
        $this->month = (int) ($_POST['month'] ? $_POST['month'] : date('n'));
        $this->year = (int)  ($_POST['year'] ? $_POST['year'] : date('Y'));

        $this->controls = $this->calendar_controls();
        $this->calendar = $this->draw_calendar();
        $this->calendar_title = $this->draw_calendar_title();
       // $this->print_notes = $this->print_notes();

    }

    private function draw_calendar_title(){
        $today = '<div id="select-date">'. date('n'). ' </div>';
        $calendar_title = '<div id="title-date"><span><h1 class="calendar-title" id="select-month">'.$this->month.'</h1></span><span><h1 ><small id="select-year">'.$this->year.'</small></h1></span></div>';
        return $calendar_title;
    }

    private function calendar_controls(){

        /* date settings */
        $month = (int) ($_POST['month'] ? $_POST['month'] : date('n'));
        $year = (int)  ($_POST['year'] ? $_POST['year'] : date('Y'));

        /* select month control */
        $select_month_control = '<select name="month" id="month">';
        for($x = 1; $x <= 12; $x++) {
        $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
        }
        $select_month_control.= '</select>';

        /* select year control */
        $year_range = 10;
        $select_year_control = '<select name="year" id="year">';
        for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
            $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
        }
        $select_year_control.= '</select>';

        /* "next month" control */
        $next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month >></a>';

        /* "previous month" control */
        $previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($this->month != 1 ? $year : $year - 1).'" class="control"><< 	Previous Month</a>';

        /* bringing the controls together */
        $controls = '<form method="post">'.$select_month_control.$select_year_control.' <input type="submit" name="submit" value="Submit" />      '.$previous_month_link.'     '.$next_month_link.' </form>';

        return $controls;
    }

    private function draw_calendar()
    {

        /* draw table */
            $calendar = '<div class="container" id="calendar">';
            $calendar .= '<div id="main-calendar" class="table-responsive"> ';
            $calendar .= '<table cellpadding="0" cellspacing="0" class="calendar table-bordered">';

            /* table headings */
            $headings = array('S','M','T','W','T','F','S');
            $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

            /* days and weeks vars now ... */
            $running_day = date('w',mktime(0,0,0,$this->month,1,$this->year));
            $days_in_month = date('t',mktime(0,0,0,$this->month,1,$this->year));
            $days_in_this_week = 1;
            $day_counter = 0;
            //$dates_array = array();

            /* row for week one */
            $calendar.= '<tr class="calendar-row">';

            /* print "blank" days until the first of the current week */
            for($x = 0; $x < $running_day; $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
                $days_in_this_week++;
            endfor;


            /* keep going with days.... */
                        for($list_day = 1; $list_day <= $days_in_month; $list_day++):
                            $calendar.= '<td class="calendar-day">';
                            /* add in the day number */
                            $calendar.= '<div class="day-number">'.$list_day.'</div>';



                            $calendar .= '<div class="note-wrapper" >';
                /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
               $sql = 'SELECT * FROM notes WHERE date = "' . $this->year . '-' . $this->month . '-' . $list_day . '";';
               $result = mysql::query('main', $sql);
                //$debug = $sql;

                foreach ($result as $note) {
                   $calendar .= '<div class="note-present"' . $note['id'] . '"></div>';

                  $calendar .= '<div class="note" id="' . $note['id'] . '">' . $note['title'] . $note['body'] . '</div>';
                  $calendar .= '<button id="delete-button" type="button" class="btn btn-danger">Delete</button>';
                }
                $calendar .= '</div>';



                $calendar.= '</td>';
                if($running_day == 6):
                    $calendar.= '</tr>';
                    if(($day_counter+1) != $days_in_month):
                        $calendar.= '<tr class="calendar-row">';
                    endif;
                    $running_day = -1;
                    $days_in_this_week = 0;
                endif;
                $days_in_this_week++; $running_day++; $day_counter++;
            endfor;

            /* finish the rest of the days in the week */
            if($days_in_this_week < 8):
                for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                    $calendar.= '<td class="calendar-day-np"> </td>';
                endfor;
            endif;

            /* final row */
            $calendar.= '</tr>';

            /* end the table */
            $calendar.= '</table></div></div>';

            /* all done, return result */


            return $calendar;

    }

}


?>
