<div class="card">
    <h3 class="card-title">Modify shifts</h3>

    <div class="col-sm-12 card-body">
        <div class="col-sm-12">
            <form action="" method="post">

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Location</label>
                    <div class="col-sm-8 ">
                        <select id="location_id" name="location_id" class="fb-input form-control form-control-sm" required>
                        <?php
                        foreach ( $locations as $val ){
                            echo '
                                <option value="'.$val->location_id.'">'.$val->location_name.'
                            ';
                        }
                        ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Shift Type</label>
                    <div class="col-sm-8 ">
                        <select id="shift_id" name="shift_id" class="fb-input form-control form-control-sm" required>
                        <?php
                        foreach ( $shift_types as $val ){
                            echo '
                                <option value="'.$val->shifttype_id.'">'.$val->shifttype_name.'
                            ';
                        }
                        ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date From</label>
                    <div class="col-sm-4 ">
                        <input type="date" id="date_from" name="date_from" class="fb-input form-control form-control-sm" required>
                    </div>
                    <div class="col-sm-4 ">
                        <input type="time" id="time_from" name="time_from" class="fb-input form-control form-control-sm" required>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Date To</label>
                    <div class="col-sm-4 ">
                        <input type="date" id="date_to" name="date_to" class="fb-input form-control form-control-sm" required>
                    </div>
                    <div class="col-sm-4 ">
                        <input type="time" id="time_to" name="time_to" class="fb-input form-control form-control-sm" required>
                    </div>
                </div>

                <div class="submit-div">
                    <input type="submit" name="add_shift" id="submit" class="button button-primary add_shift" value="Add Shift">
                </div>
            </form>
        </div>


        <br>
        
        <div class="col-sm-12">
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>Location</th>
                        <th>Shift Type</th>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ( $shift_scheds as $val ) :?>
                    <tr>
                        <td><?= $val->location_name ?></td>
                        <td><?= $val->shifttype_name ?></td>
                        <td><?= $val->shift_schedules_datefrom . $val->shift_schedules_timefrom ?></td>
                        <td><?= $val->shift_schedules_dateto . $val->shift_schedules_timeto ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>

            </table>
        </div>

    </div>
</div>
