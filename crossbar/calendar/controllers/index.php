<?

class index_controller extends base_controller
{
	public function index()
	{
        //$this->foo = "This is the value of \$this->foo set in the index_controller and function index()";
        $year = "2014";
        $month = "July";
        $month_title = "July";
        //$month_display = date ('n');
//        if (isset($_GET['month'[) {
//            $month = $_GET['month'];
//        } else {
//            $month = date('m');
//        }
//        if (isset($_GET['year'[) {
//            $year = $_GET['year'];
//        } else {
//            $year = date('Y');
//        }
        $this->calendar = $this->draw_calendar($month, $year);
        $this->calendar_title = $this->draw_calendar_title($month_title, $year);
    }

    private function draw_calendar($month,$year)
    {
            /* draw table */
            $calendar = '<div class="container">';
            $calendar .= '<div id="main-calendar" class="table-responsive">';
            $calendar .= '<table cellpadding="0" cellspacing="0" class="calendar table-bordered">';

            /* table headings */
            $headings = array('S','M','T','W','T','F','S');
            $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

            /* days and weeks vars now ... */
            $running_day = date('w',mktime(0,0,0,$month,1,$year));
            $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
            $days_in_this_week = 1;
            $day_counter = 0;
            $dates_array = array();

            /* row for week one */
            $calendar.= '<tr class="calendar-row">';

            /* print "blank" days until the first of the current week */
            for($x = 0; $x < $running_day; $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
                $days_in_this_week++;
            endfor;

            /* keep going with days.... */
            //            for($list_day = 1; $list_day <= $days_in_month; $list_day++):
            //                $calendar.= '<td class="calendar-day">';
            //                /* add in the day number */
            //                $calendar.= '<div class="day-number">'.$list_day.'</div>';

            for($list_day = 1; $list_day <= $days_in_month; $list_day++):
                if($list_day == $today && $month == $nowmonth && $year == $nowyear) {
                    $calendar.= '<td class="calendar-day-today">';
                } else {
                    $calendar.= '<td class="calendar-day">';
                }
                /* add in the day number */
                $calendar.= '<div class="day-number">'.$list_day.'</div>';

                /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
                $sql = "SELECT * FROM notes WHERE notes.date = '$day, $month, $year'";
                $result = mysql::query('main', $sql);
                foreach ($result as $note) {
                    $calendar .= '<div class="note" id="' . $note['id'] . '">' . $note['title'] . $note['body'] . '</div>';
                }

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




    private function draw_calendar_title($month_title, $year){

            $calendar_title = '<h1 class="calendar-title">'.$month_title.'<small>'.$year.'</small></h1>';
            return $calendar_title;
        }


//        //        display calendar
//        echo draw_calendar_title($month_title,$year);
//        echo draw_calendar($month_display,$year);

    }



?>
