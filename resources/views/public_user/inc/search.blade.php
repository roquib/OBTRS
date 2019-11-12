<div class="block col-md-6">
    <form name="bussearch" id="bussearch" method="POST" action="{{route('search')}}"
        onsubmit="return validateBusForm(this)">
        @csrf
        <ul class="list-inline">
            <div class="form-group hide" style="font-size:21px;color:#000;">
                <!-- Eid Change : Added hide class -->
                Lowest prices guaranteed on Bus Tickets
            </div>
            <div class="form-group">
                <label for="dest_from">From</label>
                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text"
                    class="form-control jqchars  ui-autocomplete-input" id="dest_from" name="dest_from"
                    placeholder="Enter City" maxlength="15" value="" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="dest_to">To</label>
                <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span><input type="text"
                    class="form-control jqchars ui-autocomplete-input" id="dest_to" name="dest_to" placeholder="Enter City"
                    maxlength="15" value="" autocomplete="off">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="doj">Date of Journey</label>
                        <input type="text" class="datepicker form-control hasDatepicker" id="doj" name="doj"
                            data-date-format="dd/mm/yyyy" placeholder="Pick a date" value="" readonly="true"><img
                            class="ui-datepicker-trigger" src="/img/calendar.png" alt="..." title="...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="doj">Date of Return<span> (Optional)</span></label>
                        <input type="text" class="datepicker form-control  hasDatepicker" id="dor" name="dor"
                            data-date-format="dd/mm/yyyy" placeholder="Pick a date" value=""><img
                            class="ui-datepicker-trigger" src="/img/calendar.png" alt="..." title="...">
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:50px;">
                <!-- Eid Change : margin top made 50px from 25px. -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-block" style="background: #992;"><span
                            class="glyphicon glyphicon-search"></span>
                        Search Buses </button>
                </div>
                <!--                        <div class="col-md-12">
                                <div class="col-md-12 bg-warning" style="padding:5px 5px;margin-top:20px;border:1px solid #079d49;">
                                    <b style="color:#fc0202;">Important Notice:</b> Bus Operators may decide to cancel the scheduled trips at the last moment due to the current political situation. In such cases, Shohoz.com may not be able to notify users beforehand. Trip operations/ scheduling is at the complete discretion of the bus operators.                            </div>
                            </div>-->
            </div>

            <!--bKas Modal  -->



        </ul>
    </form>
</div>
