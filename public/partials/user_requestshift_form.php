<div class="blankoverlays">
</div>
<div class="requrest-shifts-overlay overlays" data-overlay="requrest-shifts-overlay">
    <div class="container2">
        <div class="card overlay-card">
            <div class="card-title">
                <div class="col-sm-12">
                    <h3 class="overlaytitle">Request shift</h3>
                    <button type="button" class="btn btn-overlay-close">
                        <!-- <span aria-hidden="true">×</span> -->
                        X
                    </button>
                </div>
            </div>
            <div class="card-body">



                <div class="row card-body">

                    <div class="col-sm-12">

                        <div class="shiftform">
                            <form action="" method="post" action="submitShiftRequest" id="requestshiftform">
                                <input type="hidden" name="hidden_shift_id" id="hidden_shift_id" value="" class="fb-form-elem">


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8 ">
                                        <input type="text" id="name" name="name" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8 ">
                                        <input type="email" id="email" name="email" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Location</label>
                                    <div class="col-sm-8 ">
                                        <select id="location_id" name="location_id" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
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
                                        <select id="shift_id" name="shift_id" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                            <option disabled="disabled" hidden selected value="">Select shift type...</option>
                                        <?php
                                        foreach ( $shiftTypes as $val ){
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
                                        <input type="date" id="date_from" name="date_from" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                    <div class="col-sm-4 ">
                                        <input type="time" id="time_from" name="time_from" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Date To</label>
                                    <div class="col-sm-4 ">
                                        <input type="date" id="date_to" name="date_to" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                    <div class="col-sm-4 ">
                                        <input type="time" id="time_to" name="time_to" class="fb-input fb-form-control form-control-sm fb-form-elem" required>
                                    </div>
                                </div>

                                <div class="submit-div">
                                    <input type="submit" name="submit_shift_request" id="submit_shift_request" class="button button-primary add_shift fb-form-elem fb_sc_submitbtn" value="Submit">
                                </div>


                            </form>
                        </div>
                    </div>


                </div> <!-- row -->



            </div>
        </div>
    </div>

</div>
