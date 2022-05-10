<div class="tablediv" data-table="shift_schedules">

    <table class="table table-sm table-bordered table-hover table-condensed fb_sc_table">
        <thead>
            <tr>
                <th>Location</th>
                <th>Shift Type</th>
                <th>Shift Schedule</th>
                <th>Claimed by</th>
                <th>Is New</th>
                <th>Verified</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ( $rows as $val ) :?>
            <tr data-id="<?= $val->shift_schedules_id ?>">
                <td><?= $val->location_name ?></td>
                <td><?= $val->shifttype_name ?></td>
                <td>From: <?= $val->shift_schedules_datefrom .' '. date('H:i', strtotime($val->shift_schedules_timefrom)) ?><br>
                    To: <?= $val->shift_schedules_dateto . ' ' . date('H:i', strtotime($val->shift_schedules_timeto)) ?></td>
                <td><?= $val->shift_schedules_name ?><br><?= $val->shift_schedules_email ?></td>
                <td><?php
                    if ( $val->shift_schedules_is_new_chk === null ) {

                    } else if ( $val->shift_schedules_is_new_chk == 1 ) {
                        echo '<span class="badge badge-success " data-state="1">Yes</span>';
                    } else if ( $val->shift_schedules_is_new_chk == 0 ) {
                        echo '<span class="badge badge-danger " data-state="0">No</span>';
                    }
                    ?>
                </td>
                <td><?= $val->shift_schedules_location_verified ? '<span class="badge badge-success verifiedbadge" data-state="1">Yes</span>' : '<span class="badge badge-danger verifiedbadge" data-state="0">No</span>' ?></td>
                <td>
                    <div class="btn-group btn-group-toggle">
                        <button class="btn btn-sm btn-info btn-edit-shift"><span class="dashicons dashicons-edit"></span></button>
                        <button class="btn btn-sm btn-danger btn-delete-shift"><span class="dashicons dashicons-trash"></span></button>
                    </div>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>

    </table>


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
</div>
