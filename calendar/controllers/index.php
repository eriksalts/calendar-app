<?php

class index_controller extends base_controller
{


	public function index()
	{

        $this->month = (int) ($_POST['month'] ? $_POST['month'] : date('n'));
        $this->year = (int)  ($_POST['year'] ? $_POST['year'] : date('Y'));
        $this->monthtext = (int) ($_POST['month'] ? $_POST['month'] : date('F'));
        $this->navbar = $this->controls();
//        $this->controls = $this->calendar_controls();
        $this->calendar = $this->draw_calendar();
        $this->calendar_title = $this->draw_calendar_title();
    }
    private function controls(){

        $month = (int) ($_POST['month'] ? $_POST['month'] : date('n'));
        $year = (int)  ($_POST['year'] ? $_POST['year'] : date('Y'));

        $controls = '<nav class="navbar navbar-default" role="navigation"><div class="container">';

        $controls .= '<div class="navbar-header">';

//              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
//                  <span class="sr-only">Toggle navigation</span>
//                  <span class="icon-bar"></span>
//                  <span class="icon-bar"></span>
//                  <span class="icon-bar"></span>
//              </button>
        $controls .= '<a class="navbar-brand" href="#">Calendar</a></div>';

        $controls .= '<div class="collapse navbar-collapse"><ul class="nav navbar-nav">';



        $select_month_control = '<select class="form-control nav-control" role="menu" name="month" id="date-picker-month">';

        for($x = 1; $x <= 12; $x++) {
            $select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
        }

        $select_month_control.= '</select>';

        $year_range = 10;
        $select_year_control = '<select class="nav-control form-control"  name="year" id="date-picker-year">';

        for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
            $select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
        }
        $select_year_control.= '</select>';
        $next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month >></a>';
        $previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><< 	Previous Month</a>';

        //$controls .= '<div id="date-picker-year">';
        $controls .= '<form id="date-picker" method="post">' . $select_month_control . $select_year_control .'<input type="submit" id="date-picker-btn" class="nav-control btn btn-primary" name="submit" value="Submit" /> '.$previous_month_link.$next_month_link.' </form>';
//        $controls .= '<form id="cal-search" class="navbar-form" role="search">';
//        $controls .= '<div class="form-group"><input type="text" class="form-control" placeholder="Search"></div>';
//        $controls .= '<button type="submit" class="btn btn-default">Submit</button></form>';

        $controls .= '</div></div></nav>';

        return $controls;

    }
    private function draw_calendar_title(){
        $calendar_title = '<div id="title-date"><h1 class="calendar-title" id="select-month">'.$this->month.'</h1><h1><small id="select-year">'.$this->year.'</small></h1></div>';
        return $calendar_title;
    }


    private function draw_calendar()
    {
            $calendar = '<div class="container" id="calendar">';
            $calendar .= '<div id="main-calendar" class="table-responsive"> ';
            $calendar .= '<table cellpadding="0" cellspacing="0" class="calendar table-bordered">';

            $headings = array('S','M','T','W','T','F','S');

            $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

            $running_day = date('w',mktime(0,0,0,$this->month,1,$this->year));

            $days_in_month = date('t',mktime(0,0,0,$this->month,1,$this->year));

            $days_in_this_week = 1;

            $day_counter = 0;



            $calendar.= '<tr class="calendar-row">';
            for($x = 0; $x < $running_day; $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
                $days_in_this_week++;
            endfor;
            for($list_day = 1; $list_day <= $days_in_month; $list_day++):
                $calendar.= '<td class="calendar-day" id="input-date-' . $list_day . '">';
                $calendar.= '<div class="day-number">'.$list_day.'</div>';

                $calendar .= '<div id="badge-date-' . $list_day . '"class="note-wrapper">';

               //database query for note
               $sql = 'SELECT * FROM notes WHERE date = "' . $this->year . '-' . $this->month . '-' . $list_day . '";';

               $result = mysql::query('main', $sql);
                foreach ($result as $note) {
                   // $calendar.= '<div class="panel panel-info>';

                    $calendar .= '<div class="note panel panel-primary clearfix" id="' . $note['id'] . '">';
                    $calendar.='<div class="panel-heading"><div class="note-title panel-title">'. $note['title'].'</div></div>';
                    $calendar.='<div class="note-body panel-body">'. $note['body'].'</div>';
                    $calendar .= '<button data-id="' . $note['id'] . '" type="button" class="btn btn-danger delete-button">Delete</button></div>';

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

        if($days_in_this_week < 8):
            for($x = 1; $x <= (8 - $days_in_this_week); $x++):
                $calendar.= '<td class="calendar-day-np"> </td>';
            endfor;
        endif;

        $calendar.= '</tr>';
        $calendar.= '</table></div></div>';

        return $calendar;
    }
}
//<div class="form-control" id="date-picker-month">

?>
