<div id="calendar-div" class="fb_sc_maindiv">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

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
                        for ($m=($yearNow); $m<=($yearNow+3); $m++) {
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


    <div class="shifts-overlay overlays" data-overlay="shifts-overlay">
        <div class="container">
            <div class="card overlay-card">
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
                        <div class="col-sm-12 tablediv" id="available-shifts-table-div" data-table="available-shifts-table-div">

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="claimform-overlay overlays" data-overlay="claimform-overlay">
        <div class="container">
            <div class="card overlay-card">
                <div class="card-title">
                    <div class="col-sm-12">
                        <h3 class="claimform-label">Claim form</h3>
                        <button type="button" class="btn btn-overlay-close">
                            <!-- <span aria-hidden="true">×</span> -->
                            X
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- <input type="hidden" id="selectedDay"> -->
                    <div class="row">
                        <div class="col-sm-12">

                            <form action="" method="post" class="adminform">

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="fb-input form-control form-control-sm fb-form-control" id="fb_sc_name" name="fb_sc_name" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" class="fb-input form-control form-control-sm fb-form-control" id="fb_sc_email" name="fb_sc_email" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="form-check newuser_chk_label">
                                        <label class="form-check-label " for="newuser_chk">
                                            Click here if you have not worked at this facility before
                                        </label>
                                        <input class="form-check-input" type="checkbox" value="" name="newuser_chk" id="newuser_chk">
                                    </div>


                                    <div class="submit-div">
                                        <input type="submit" name="fb_sc_claimbtn" id="fb_sc_claimbtn" class="button button-primary fb-form-elem fb_sc_submitbtn fb_sc_claimbtn" value="Claim">
                                    </div>
                                </div>

                            </form>


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
