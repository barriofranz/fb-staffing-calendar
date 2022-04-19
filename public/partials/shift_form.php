<div class="panel fb-panel">
    <h3 class="card-title">Shift Schedules</h3>

    <div class="row card-body">

        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <span class="badge badge-primary" id="add-edit-span"></span>
                    <button  type="submit" class="new_shift_sched btn btn-primary btn-sm float-right"><span class="dashicons dashicons-plus-alt2"></span></button>
                </div>
            </div>
            <br>
            <div class="crow">
                <form action="" method="post">
                    <input type="hidden" name="hidden_shift_id" id="hidden_shift_id" value="" class="fb-form-elem">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Location</label>
                        <div class="col-sm-8 ">
                            <select id="location_id" name="location_id" class="fb-input form-control form-control-sm fb-form-elem" required>
                                <option disabled="disabled" hidden selected value="">Select location..</option>
                            <?php
                            foreach ( $locations as $val ) {
                                echo '
                                    <option value="'.$val->location_id.'">'.$val->location_name.'</option>
                                ';
                            }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Shift Type</label>
                        <div class="col-sm-8 ">
                            <select id="shift_id" name="shift_id" class="fb-input form-control form-control-sm fb-form-elem" required>
                                <option disabled="disabled" hidden selected value="">Select shift type...</option>
                            <?php
                            foreach ( $shift_types as $val ){
                                echo '
                                    <option value="'.$val->shifttype_id.'">'.$val->shifttype_name.'</option>
                                ';
                            }
                            ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Date From</label>
                        <div class="col-sm-4 ">
                            <input type="date" id="date_from" name="date_from" class="fb-input form-control form-control-sm fb-form-elem" required>
                        </div>
                        <div class="col-sm-4 ">
                            <input type="time" id="time_from" name="time_from" class="fb-input form-control form-control-sm fb-form-elem" required>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Date To</label>
                        <div class="col-sm-4 ">
                            <input type="date" id="date_to" name="date_to" class="fb-input form-control form-control-sm fb-form-elem" required>
                        </div>
                        <div class="col-sm-4 ">
                            <input type="time" id="time_to" name="time_to" class="fb-input form-control form-control-sm fb-form-elem" required>
                        </div>
                    </div>

                    <div class="submit-div">
                        <input type="submit" name="submit_shift" id="submit_shift" class="button button-primary add_shift fb-form-elem" value="Add">
                    </div>


                </form>
            </div>
        </div>


        <br>

        <div class="col-sm-6">
            <table class="table table-sm table-bordered table-responsive table-hover table-condensed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>Shift Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ( $shift_scheds as $val ) :?>
                    <tr data-id="<?= $val->shift_schedules_id ?>">
                        <td><?= $val->shift_schedules_id ?></td>
                        <td><?= $val->location_name ?></td>
                        <td><?= $val->shifttype_name ?></td>
                        <td><?= $val->shift_schedules_datefrom .' '. $val->shift_schedules_timefrom ?></td>
                        <td><?= $val->shift_schedules_dateto . ' ' . $val->shift_schedules_timeto ?></td>
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
        </div>
    </div> <!-- row -->
</div>
