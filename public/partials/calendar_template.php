<div id="calendar-div">
    <div class="month">

            <div class="input-group">
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

                <select class="form-control" id="fb-year">
                    <?php
                    $yearNow = (int)date('Y');
                    for ($m=($yearNow-3); $m<=($yearNow+1); $m++) {
                        echo '<option value="'. $m .'" ' . (($m==$yearNow) ? 'selected' : '') . '>' . $m . '</option>';
                    }
                    ?>
                </select>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-success choose-ym-calendar" id="choose-ym-calendar">Go</button>
                </div>
            </div>


    </div>

    <div id="calendardays">
    </div>

</div>

<div class="shifts-overlay">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="ymd-label"></h3>

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
