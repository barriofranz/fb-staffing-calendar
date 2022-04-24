

<ul class="weekdays">
<?php foreach ( $days as $day) : ?>
    <?php echo '<li>'.$day.'</li>'; ?>
<?php endforeach; ?>
</ul>

<ul class="days">


<?php
// echo "<pre>";print_r($daysWithShifts);echo "</pre>";die();
for ( $a=1; $a<=$maxDays; $a++ ) :
?>

    <?php
    // echo $currentDayOfMonth;
    if ( $a == 1) {
        for ( $b=1; $b<=$firstDayOffset; $b++ ) :
            echo '<li></li>';
        endfor;
    }

    $unclaimed = '';
    if ( isset($daysWithShifts['unclaimed'][$a]) ) {
        foreach ( $daysWithShifts['unclaimed'][$a] as $shiftkey => $shiftdata) {
            $unclaimed .= '<span class="badge badge-secondary" style="background-color: #'.$shiftdata['colorcode'].'">' . $shiftdata['count'] . ' ' . $shiftkey . '</span><br>';
        }

    }

    $claimed = '';
    if ( isset($daysWithShifts['claimed'][$a]) ) {
        $claimed = '<span class="badge badge-secondary">' . $daysWithShifts['claimed'][$a] . ' claimed</span><br>';
    }

    echo '
    <li class="selectable ' . ( ($currentDayOfMonth == $a) ? 'active' : ''  ) . ' " data-day="'.$a.'">
    <span>'.$a.'</span><br>
    '.$unclaimed.'
    '.$claimed.'
    </li>';

    if ( $a == $maxDays) {
        for ( $b=1; $b<=(6-$currentDayLastOfMonth); $b++ ) :
            echo '<li></li>';
        endfor;
    }
    ?>
<?php endfor; ?>
</ul>
