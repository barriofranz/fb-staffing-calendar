

<ul class="weekdays">
<?php foreach ( $days as $day) : ?>
    <?php echo '<li>'.$day.'</li>'; ?>
<?php endforeach; ?>
</ul>

<ul class="days">


<?php for ( $a=1; $a<=$maxDays; $a++ ) : ?>

    <?php
    // echo $currentDayOfMonth;
    if ( $a == 1) {
        for ( $b=1; $b<=$firstDayOffset; $b++ ) :
            echo '<li></li>';
        endfor;
    }
    echo '<li class="selectable ' . ( ($currentDayOfMonth == $a) ? 'active' : ''  ) . ' " data-day="'.$a.'">'.$a.'</li>';

    if ( $a == $maxDays) {
        for ( $b=1; $b<=(6-$currentDayLastOfMonth); $b++ ) :
            echo '<li></li>';
        endfor;
    }
    ?>
<?php endfor; ?>
</ul>
