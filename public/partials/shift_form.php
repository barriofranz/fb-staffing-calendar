<div class="panel fb-panel fb_sc_maindiv">
    <div class="shifts-overlay adminoverlays">
    </div>
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
            <div class="shiftform">
                <form action="" method="post" class="adminform">
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
                        <input type="submit" name="submit_shift" id="submit_shift" class="button button-primary add_shift fb-form-elem fb_sc_submitbtn" value="Add">
                    </div>


                </form>
            </div>
        </div>


        <br>

        <div class="col-sm-6">
            <table class="table table-sm table-bordered table-hover table-condensed fb_sc_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th>Shift Type</th>
                        <th>Shift Schedule</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ( $shift_scheds as $val ) :?>
                    <tr data-id="<?= $val->shift_schedules_id ?>">
                        <td><?= $val->shift_schedules_id ?></td>
                        <td><?= $val->location_name ?></td>
                        <td><?= $val->shifttype_name ?></td>
                        <td>From: <?= $val->shift_schedules_datefrom .' '. date('H:i', strtotime($val->shift_schedules_timefrom)) ?><br>
                            To: <?= $val->shift_schedules_dateto . ' ' . date('H:i', strtotime($val->shift_schedules_timeto)) ?></td>
                        <td><?= $val->shift_schedules_email ?></td>
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
        </div>

    </div> <!-- row -->
</div>


<div class="panel fb-panel fb_sc_maindiv">
    <h3 class="card-title">Locations</h3>

    <div class="row card-body">

        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-12">
                    <span class="badge badge-primary" id="add-edit-span_loc"></span>
                    <button  type="submit" class="new_loc btn btn-primary btn-sm float-right"><span class="dashicons dashicons-plus-alt2"></span></button>
                </div>
            </div>
            <br>


            <div class="locform">
                <form action="" method="post" class="adminform">
                    <input type="hidden" name="hidden_loc_id" id="hidden_loc_id" value="" class="fb-form-elem">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Location Name</label>
                        <div class="col-sm-8 ">
                            <input type="text" class="fb-input form-control form-control-sm fb-form-elem" id="loc_name" name="loc_name" required>

                        </div>
                    </div>

                    <div class="submit-div">
                        <input type="submit" name="submit_loc" id="submit_loc" class="button button-primary add_loc fb-form-elem fb_sc_submitbtn" value="Add">
                    </div>

                </form>
            </div>

        </div>


        <br>

        <div class="col-sm-6">
            <table class="table table-sm table-bordered table-hover table-condensed fb_sc_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ( $locations as $val ) :?>
                    <tr data-id="<?= $val->location_id ?>">
                        <td><?= $val->location_id ?></td>
                        <td><?= $val->location_name ?></td>
                        <td>
                            <div class="btn-group btn-group-toggle">
                                <button class="btn btn-sm btn-info btn-edit-loc"><span class="dashicons dashicons-edit"></span></button>
                                <button class="btn btn-sm btn-danger btn-delete-loc"><span class="dashicons dashicons-trash"></span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>

            </table>
        </div>


    </div>


</div>




<div class="panel fb-panel fb_sc_maindiv">
    <h3 class="card-title">Shift Types</h3>

    <div class="row card-body">

        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-12">
                    <span class="badge badge-primary" id="add-edit-span_shifttype"></span>
                    <button  type="submit" class="new_shifttype btn btn-primary btn-sm float-right"><span class="dashicons dashicons-plus-alt2"></span></button>
                </div>
            </div>
            <br>


            <div class="shifttypeform">
                <form action="" method="post" class="adminform">
                    <input type="hidden" name="hidden_shifttype_id" id="hidden_shifttype_id" value="" class="fb-form-elem">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Shift Type</label>
                        <div class="col-sm-8 ">
                            <input type="text" class="fb-input form-control form-control-sm fb-form-elem" id="shifttype_name" name="shifttype_name" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Color hex code</label>
                        <div class="col-sm-8 ">
                            <input type="text" class="fb-input form-control form-control-sm fb-form-elem" id="shifttype_colorcode" name="shifttype_colorcode" required>
                            <small id="emailHelp" class="form-text text-muted">Use any hex code without sharp character (#)</small>
                        </div>
                    </div>

                    <div class="submit-div">
                        <input type="submit" name="submit_shifttype" id="submit_shifttype" class="button button-primary add_shifttype fb-form-elem fb_sc_submitbtn" value="Add">
                    </div>

                </form>
            </div>

        </div>


        <br>

        <div class="col-sm-6">
            <table class="table table-sm table-bordered table-hover table-condensed fb_sc_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Shift Type</th>
                        <th>Color hex code</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ( $shift_types as $val ) :?>
                    <tr data-id="<?= $val->shifttype_id ?>">
                        <td><?= $val->shifttype_id ?></td>
                        <td><?= $val->shifttype_name ?></td>
                        <td><?= $val->shifttype_colorcode ?></td>
                        <td>
                            <div class="btn-group btn-group-toggle">
                                <button class="btn btn-sm btn-info btn-edit-shifttype"><span class="dashicons dashicons-edit"></span></button>
                                <button class="btn btn-sm btn-danger btn-delete-shifttype"><span class="dashicons dashicons-trash"></span></button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>

            </table>
        </div>


    </div>
</div>


<div class="panel fb-panel fb_sc_maindiv">
    <h3 class="card-title">Settings</h3>

    <div class="row card-body">

        <div class="col-sm-6">

            <div class="row">
                <div class="col-sm-12">

                </div>
            </div>
            <br>


            <div class="settingsform">
                <form action="" method="post" class="adminform">

                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Email from</label>
                        <div class="col-sm-8 ">
                            <input type="text" value="<?= $fb_sc_emailfrom ?>" class="fb-input form-control form-control-sm fb-form-elem" id="fb_sc_emailfrom" name="fb_sc_emailfrom" required>
                        </div>
                    </div>

                    <div class="submit-div">
                        <input type="submit" name="submit_fb_sc_settings" id="submit_fb_sc_settings" class="button button-primary fb-form-elem fb_sc_submitbtn" value="Save">
                    </div>

                </form>
            </div>

        </div>


        <br>


    </div>
</div>
