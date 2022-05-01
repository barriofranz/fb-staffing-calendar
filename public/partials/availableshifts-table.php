<div class="available-shifts-table-overflowdiv">
<table class="table table-sm table-bordered" id="available-shifts-table">
    <thead>
        <tr>
            <th>Location</th>
            <th>Shift Type</th>
            <th>From</th>
            <th>To</th>
            <th></th>
        </tr>
    </thead>

    <tbody>


        <?php

        if (count($shift_schedules) == 0 ) {
            echo '<tr><td colspan="6" class="loadertd">No shifts found</td></tr>';
        }
        foreach ( $shift_schedules as $scheds) :
        ?>
        <tr>
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


    </tbody>

</table>
</div>
<?php
if (count($shift_schedules) > 0 ) {
?>
    <nav >
      <ul class="pagination">
        <?php
        for ($a=1; $a <= ceil($count/$limit); $a++) :

        ?><li class="page-item <?php echo ($page+1==$a) ? 'active' : '' ?>">
<a class="page-link" href="#" data-page="<?= $a ?>"><?= $a ?></a>
</li><?php
        endfor;
        ?>
      </ul>
    </nav>
<?php
}
?>
