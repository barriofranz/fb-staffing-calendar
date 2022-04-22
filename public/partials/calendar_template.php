<div id="calendar-div" class="fb_sc_maindiv">
    <div class="month">

            <div class="input-group">


                <select class="form-control" id="fb-year">
                    <?php
                    $yearNow = (int)date('Y');
                    for ($m=($yearNow-3); $m<=($yearNow+1); $m++) {
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
                    <option value="0" selected >All types</option>
                    <?php
                    foreach ( $getShiftTypes as $shifttype) {
                        echo '<option value="'. $shifttype->shifttype_id .'" >' . $shifttype->shifttype_name . '</option>';
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


    <div class="shifts-overlay">
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
                                        <th>ID</th>
                                        <th>Locatio</th>
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



</div>
