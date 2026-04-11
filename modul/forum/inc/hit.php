<?php
 



function countdown( $event, $month, $day, $year )
{
    // subtract desired date from current date and give an answer in terms of days
    $remain = ceil( ( mktime( 0,0,0,$month,$day,$year ) - time() ) / 86400 );
    // show the number of days left
    if( $remain > 0 )
    {
        print "<p><strong>$remain</strong> more sleeps until $event</p>";
    }
    // if the event has arrived, say so!
    else
    {
        print "<p>$event has arrived!</p>";
    }
}

// call the function
countdown( "Christmas Day", 12, 25, 2010 );
?>
