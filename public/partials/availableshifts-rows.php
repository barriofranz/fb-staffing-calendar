<?php

if (count($shift_schedules) == 0 ) {
    echo '<tr><td colspan="6" class="loadertd">No shifts found</td></tr>';
}
foreach ( $shift_schedules as $scheds) :
?>

<tr>
    <td><?= $scheds->shift_schedules_id ?></td>
    <td><?= $scheds->location_name ?></td>
    <td><?= $scheds->shifttype_name ?></td>
    <td><?= $scheds->shift_schedules_datefrom . ' ' . $scheds->shift_schedules_timefrom ?></td>
    <td><?= $scheds->shift_schedules_dateto . ' ' . $scheds->shift_schedules_timeto ?></td>
    <td>
        <div class="btn-group btn-group-toggle">
            <?php if ( empty($scheds->shift_schedules_email) ) : ?>
            <button class="btn btn-sm btn-info btn-claim-sched" data-id="<?= $scheds->shift_schedules_id ?>">Claim</button>
            <?php endif; ?>
        </div>
    </td>
</tr>
<?php
endforeach;
?>
