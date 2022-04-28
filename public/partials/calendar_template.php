<div id="calendar-div" class="fb_sc_maindiv">

    <div class="main-auth <?php echo $isLoggedIn == 1 ? 'loggedin' : '' ?> ">
            <div class=" pw-protect-div">
                <div class="input-group pw-protect-input-group">
                    <input type="password" class="form-control fb-form-control" placeholder="Password" name="pw-protect-field" id="pw-protect-field">
                    <div class="input-group-prepend">
                        <button type="submit" name="pw-submit" class="btn btn-primary pw-submit" href="#"><span class="dashicons dashicons-arrow-right-alt"></span></button>
                    </div>

                </div>
                <div id="login-notice"></div>
            </div>
    </div>
    <div class="main-calendar <?php echo $isLoggedIn == 1 ? 'loggedin' : '' ?> ">
        <div class="month">

                <div class="input-group">

                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-success add-user-shift" id="add-user-shift">Request Shift</button>
                    </div>

                    <select class="form-control" id="fb-year">
                        <?php
                        $yearNow = (int)date('Y');
                        for ($m=($yearNow); $m<=($yearNow+1); $m++) {
                            echo '<option value="'. $m .'" ' . (($m==$yearNow) ? 'selected' : '') . '>' . $m . '</option>';
                        }
                        ?>
                    </select>

                    <select class="form-control " id="fb-month">
                        <?php
                        $monthNow = (int)date('Y');
                        $monthNow = date('m');
                        for ($m=1; $m<=12; $m++) {
                            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                            $monthInt = date('m', mktime(0,0,0,$m, 1, date('Y')));


                            echo '<option value="'. $monthInt .'" ' . (((int)$m==(int)$monthNow) ? 'selected' : '') . '>' . $month . '</option>';
                        }
                        ?>
                    </select>

                    <select class="form-control " id="fb-shifttype">
                        <option value="0" selected >All Shift Types</option>
                        <?php
                        foreach ( $shiftTypes as $shifttype) {
                            echo '<option value="'. $shifttype->shifttype_id .'" >' . $shifttype->shifttype_name . '</option>';
                        }
                        ?>
                    </select>

                    <select class="form-control " id="fb-location">
                        <option value="0" selected >All Locations</option>
                        <?php
                        foreach ( $locations as $locs) {
                            echo '<option value="'. $locs->location_id .'" >' . $locs->location_name . '</option>';
                        }
                        ?>
                    </select>

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary choose-ym-calendar" id="choose-ym-calendar">Go</button>
                    </div>
                </div>


        </div>

        <div id="calendardays">
        </div>
    </div>


    <div class="shifts-overlay overlays">
        <div class="container">
            <div class="card shifts-overlay-card">
                <div class="card-title">
                    <div class="col-sm-12">
                        <h3 class="ymd-label"></h3>
                        <button type="button" class="btn btn-overlay-close">
                            <!-- <span aria-hidden="true">×</span> -->
                            X
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" id="selectedDay">
                    <div class="row">
                        <div class="col-sm-12">
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

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <?php
    include_once __DIR__ . '/user_requestshift_form.php';
    ?>

</div>
<?php
if ( isset( $doRefresh ) && $doRefresh == 1 ) {
?>
<script>

    window.location = window.location;

</script>

<?php
}
?>
