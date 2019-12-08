@extends('master.public')

@section('page-title')
Online Bus Ticket Reservation System
@endsection
@section('main-content')
{{-- {{dd($data)}} --}}
<input type="hidden" id="www-search-id" name="www-search-id" value="MA==">
<div class="container">
    {{-- <div class="row">
        <div class="col-md-8 mx-auto">
            @if (session()->has('success'))
            @include('public_user.success-alert')
            @endif
        </div>
    </div> --}}
    {{--  <div class="row">
        <div class="col-xs-12 col-sm-12 border-right-1">
            <div class="row d-flex">
                <div class="col-xs-12 col-sm-5 col-md-6 no-padding">
                    <div class="details">
                        <p class="bold_ticket_text" id=""> {{$data->fromcity}} to {{$data->tocity}} </p>

    <p class="bold_ticket_text">
        {{$data->doj}} </p>
</div>
</div>
</div>

</div>
</div> --}}
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- list_rows starts here -->
            <div id="bus_tckt_rows" class="list_rows 2 table-responsive">
                <div class="filter_value hidden">
                    <ul class="list-inline">
                        <li class="filters_text_style"> Filter(s): </li>
                    </ul>
                </div>
                <table id="trips" class="tablesorter tablesorter-default">
                    <thead style="border-bottom: 5px solid #F7F7F7; color: #828282;">
                        <tr>
                            <th class="tbl_th1 th_text_color header">
                                Operator <span style="font-weight: normal;">(Bus Type)</span>
                            </th>
                            <th class="tbl_th3 header" style="color: #828282;">
                                Dep. Time
                            </th>
                            <th class="tbl_th4 header" style="color: #828282;">
                                Arr. Time
                            </th>
                            <th class="tbl_th5 header" style="color: #828282;">
                                Seats Available
                            </th>
                            <th class="tbl_th6 header" style="color: #828282;">
                                Fare
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $detail)
                        <tr trip-id="{{$detail->trip_id}}" class="trip-row" data-trip="
                            {{$detail}}
                            " id="trip_id">
                            <td class="tbl_col1 border-fix-seat" data-title="Operator">

                                <ul>
                                    <li class="op_name">{{$detail->company_name}}</li>
                                    <li class="bus_type" style="margin-bottom: 5px;">{{$detail->bus_desc}}
                                    </li>
                                    <li class="bus_type"><b style="color:#757A7E;">Route:</b>
                                        {{$detail->trip_heading}}
                                    </li>

                                </ul>

                            </td>
                            <td class="tbl_col3 border-fix-seat" data-title="Dep. Time">
                                {{$detail->departure_time}} <br>

                            </td>
                            <td class="tbl_col4 border-fix-seat" data-title="Arr. Time">
                                {{$detail->arrival_time}} </td>
                            <td class="tbl_col5 border-fix-seat" data-title="Seats Available">
                                {{$detail->available_seats}} </td>
                            <td class="tbl_col6 border-fix-seat" data-title="Fare"
                                style="text-align:right;  position: relative;">
                                <ul class="list-inline">

                                    <li class="fare_li" style="text-align: right;float:none;font-size: 20px;">
                                        ৳ {{$detail->economy_class_fare}} </li>

                                </ul>
                                <div class="clearfix"></div>
                                <ul>
                                    <li class="seats-button"><button type="submit" trip_id="{{$detail->trip_id}}"
                                            triproute="{{$detail->trip_route_id}}" operatorid="{{$detail->operator_id}}"
                                            tocity="{{$detail->destination_city_name}}"
                                            class="btn btn-default btn-sm btnSubmit seatsLayout" data-toggle="modal"
                                            data-target="#bus_seat">View
                                            Seats</button>
                                    </li>

                                </ul>
                            </td>
                        </tr>
                        <tr id="trip{{$detail->trip_id}}-amenities" class="trip-row-amenities expand-child text-dark">
                            <td id="tbl_offer" colspan="6" style="border-bottom: 15px solid #f7f7f7;">
                                <span class="tr-bottom-policies" style="font-size: 14px;"><a
                                        class="text-dark badge badge-light" href="javascript:void(0)"
                                        onclick="showTripPolicies(4615110,'cancelPolicy')">Cancellation
                                        Policy</a><span></span>
                                    <span class="tr-bottom-policies"><a class="text-dark badge badge-light"
                                            href="javascript:void(0)"
                                            onclick="showTripPolicies(4615110,'boardingPoints')">Boarding
                                            point</a><span></span>.
                                        <span class="tr-bottom-policies"><a class="text-dark badge badge-light"
                                                href="javascript:void(0)"
                                                onclick="showTripPolicies(4615110,'droppingPoints')">Dropping
                                                point</a><span></span>.
                                            <span class="tr-bottom-policies"><a class="text-dark badge badge-light"
                                                    href="javascript:void(0)"
                                                    onclick="showTripPolicies(4615110,'facilities')">Facilities</a><span></span>
                                            </span></span></span></span>
                                <table>

                                    <tbody>
                                        <tr class="">
                                        </tr>

                                        <tr class="trseats" style="display: table-row;">
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
<!-- Modal -->
<div class="modal fade view_seat_bg" id="bus_seat" tabindex="-1" role="dialog" aria-labelledby="bus_seat"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="choose seat">Choose your seat(s)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 seat-layout">
                    <table class="border border-dark p-2">
                        @php
                        $seatRow = ['A','B','C','D','E','F','G','H','I','J'];
                        @endphp
                        <tr style="height: 30px !important;">
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10" style="display: none; background: #d3d3d3"></div>
                            </td>
                            <td style="width: 50px; margin:5px;">
                                <div class="text-center p-10" style="display: none; background: #cc5560"></div>
                            </td>
                            <td style="width: 50px; margin:5px;">
                                <div class="text-center p-10" style="display: none"></div>
                            </td>
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10" style="display: none; background: #54c581"></div>
                            </td>
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10 mb-3">
                                    <img src="{{asset('img/icon_steering.png')}}" width="50%" alt="">
                                </div>
                            </td>
                        </tr>
                        @for ($i = 0; $i < 10; $i++) <tr style="height: 30px !important">
                            @foreach ($result as $detail)
                            {{-- {{dd($detail->seatAvailable($detail->trip_id,$seatRow[$i].'2'))}} --}}
                            {{-- <td style="width: 50px; margin:5px" data-seat="{{$detail->trip_id.' '.$seatRow[$i].'1'}}">
                            --}}
                            {{-- {{dd($detail->findTicket(1,'A1'))}} --}}
                            @php
                            $arr_seat = $seatRow[$i].'1';
                            $data = $detail->findTicket($detail->trip_id,strval($arr_seat));
                            @endphp

                            <td style="width: 50px; margin:5px" data-trip="{{$detail}}" data-seat="{{$data}}">
                                <div class="text-center p-10 {{$detail->seatAvailable($detail->trip_id,$arr_seat)  === 0 ? 'booked' : 'seat' }}"
                                    title="{{$arr_seat}}" data-toggle="tooltip" onclick="chooseSeat(this)">
                                    {{$arr_seat}}
                                </div>
                            </td>
                            <td style="width: 50px; margin:5px;"
                                data-seat="{{$detail->findTicket($detail->trip_id,$seatRow[$i].'2')}}">
                                <div class="text-center p-10 seat" title="{{$seatRow[$i].'2'}}" data-toggle="tooltip"
                                    onclick="chooseSeat(this)">{{$seatRow[$i].'2'}}</div>
                            </td>
                            <td style=" width: 50px; margin:5px;">
                                <div class="text-center p-10" style="display: none">{{$seatRow[$i].'1'}}</div>
                            </td>
                            <td style="width: 50px; margin:5px"
                                data-seat="{{$detail->findTicket($detail->trip_id,$seatRow[$i].'3')}}">
                                <div class="text-center p-10 seat" title="{{$seatRow[$i].'3'}}" data-toggle="tooltip"
                                    onclick="chooseSeat(this)">{{$seatRow[$i].'3'}}</div>
                            </td>
                            <td style="width: 50px; margin:5px"
                                data-seat="{{$detail->findTicket($detail->trip_id,$seatRow[$i].'4')}}">
                                <div class="text-center p-10 seat" title="{{$seatRow[$i].'4'}}" data-toggle="tooltip"
                                    onclick="chooseSeat(this)">{{$seatRow[$i].'4'}}</div>
                            </td>

                            </tr>
                            @endforeach
                            @endfor
                    </table>
                    <p id="seatError" class="hidden">Sorry! this ticket is not available now.</p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-4">
                            <li style="background: #d3d3d3;text-align: center;">
                                <img src="{{ asset('img/seat.png') }}" width="54%" alt="seat.png">
                            </li>
                            <li>Available Seats</li>
                        </div>
                        <div class="col-sm-4">
                            <li style="background: #cc5560;text-align: center;">
                                <img src="{{ asset('img/seat.png') }}" width="54%" alt="seat.png">
                            </li>
                            <li>Booked Seats</li>
                        </div>
                        <div class="col-sm-4">
                            <li style="background: #54c581;text-align: center;">
                                <img src="{{ asset('img/seat.png') }}" width="54%" alt="seat.png">
                            </li>
                            <li>Selected Seats</li>
                        </div>
                    </div>
                    <div class="clearfix">
                        <div id="tbl_price_details">
                            <table class="table">
                                <thead>
                                    <th>Seats</th>
                                    <th>Fare</th>
                                    <th>Class</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                            <div class="t_data">
                                                <table id="tbl_seat_list">
                                                    <tbody>
                                                        {{-- <tr>
                                                            <td width="115">A3</td>
                                                            <td width="100">480</td>
                                                            <td>Economy</td>
                                                        </tr> --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="tickets_total" class="t_total">
                            <p><b>Total: 0</b></p>
                        </div>
                        <form id="confirmbooking" method="post" action="/booking/bus/confirm">
                            @csrf
                            <div class="form-group">
                                <label for="bpt">Choose Boarding Point <span>*</span></label>
                                <select id="boardingpoint" name="boardingpoint" class="form-control">
                                    <option value="0"> -- Boarding points -- </option>
                                    <option value="Mohakhali Bus Point (10:30 PM)">Mohakhali Bus Point (10:30 PM)
                                    </option>
                                </select>
                                <p id="errormsg" class="">Please choose your seat before you continue.</p>
                            </div>
                            <input type="hidden" id="searchid" name="searchid">
                            <a href="javascript:void(0)" onclick="submitConfirm(this)" class="btn btn-default btn-sm"
                                style="margin-top:20px;">Continue</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p id="tripAlert" class="" style="color: #ccc; margin-top:15px; text-align:center;"><i
                        class="fa fa-exclamation-triangle"></i> <i>Due to traffic condition, the trip may get
                        canceled.</i> </p>
                <button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Close</button>
                {{-- <button type="button" onclick="submitConfirm(this)" class="btn btn-primary">Continue</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional_script')
<script>
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $(document).ready(function() {
        $('.btnClose').on('click', function () {
            console.log($(this).closest('.trseats'));
        // releaseAllSeats($(this).closest('.trseats'));
        // $(this).closest('table').find('td').css('border-bottom', '15px solid #F7F7F7');
        // $('.list_rows table td.border-fix-seat').css('border-bottom', '15px solid #F7F7F7');
        });
        $(window).on('unload', function(){
        releaseAllSeats();
        });
        $(".view_seat_bg")[0].scrollIntoView();
        });
        function toTitleCase(str)
        {
        return str.replace(/\b\w/g, function (txt) { return txt.toUpperCase(); });
        }
    function submitConfirm(objContBtn) {
        var allOkay = true;
        $('#errormsg').addClass('hidden');
        if ($("#tbl_price_details").find("table#tbl_seat_list").find("tbody:eq(0)").find("tr").length < 1 ) {
            $("#errormsg") .text("Please choose your seat before you continue.") .removeClass("hidden");
            allOkay=false; 
        } else if ($("#boardingpoint").val() < 1) {
            $("#errormsg") .text("Please choose a boarding point")
            .removeClass("hidden"); allOkay=false; 
        } else if ($("#tbl_price_details") .find("table#tbl_seat_list") .find("tbody:eq(0)") .find("tr").length >maxTickets ) { 
            $("#errormsg") .text("You need to select " + maxTickets + " seats.") .removeClass("hidden");
            allOkay=false; 
        }
        if(allOkay) {
            $(window).off("unload");
            $("#searchid").val($("#www-search-id").val());
            var noOfSeats = $("#tbl_price_details")
            .find("table#tbl_seat_list")
            .find("tbody:eq(0)")
            .find("tr");
            $.each(noOfSeats,function(index,tr){
                $('#confirmbooking').append($(tr).contents()[2].childNodes[1]);
            });
            // $('#confirmbooking').append(noOfSeats[0].contents()[2].childNodes[2]);
            $('#confirmbooking').append($(noOfSeats[0]).contents()[2].childNodes[2]);
            $('form#confirmbooking').submit();
        }

    }
    function releaseAllSeats($trSeatsObj)
    {
    var $seatTableTr = $('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)').find('tr');
    $.each($seatTableTr, function(index, trObj) {
    //var ticketId = $(trObj).find('input[type="hidden"]').val();
    var ticketId = $(trObj).find('input[name="ticket[]"]').val();
    var tripRouteId = $(trObj).find('input[name="triproute[]"]').val();
    //console.log(ticketId);console.log(tripRouteId);
    $.ajax({
    url: '/booking/bus/seat/release',
    type: 'POST',
    data: {"ticketid":ticketId,
    "routeid":tripRouteId
}
    }).done(function(data) {});
    });
    
    if ($trSeatsObj) {
    $trSeatsObj.find('td:eq(0)').html('');
    }
    }
    function chooseSeat(seatObj) {
        $('#seatError').addClass('hidden');
        var $seatObj = $(seatObj);
        var sData = $seatObj.parent().data('seat');
        var tripData = $seatObj.parent().data('trip');
        var $seatTableBody = $('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)');
        var discountAmount = 0;
        // console.log(sData[0]);
        if($seatObj.hasClass('selected')) {
            $seatObj.removeClass("selected");
            $seatObj.addClass('seat');
            $('#'+sData[0].ticket_id).remove();
            $.ajax({
                url: '/booking/bus/seat/release',
                type: 'POST',
                data: {"ticketid":sData[0].ticket_id,
                    "routeid":tripData.trip_route_id,
                    "searchid":$('#www-search-id').val()}
            }).done(function(data) {
            });
            var ticketPrice = 0;
            var discountValue = 0;
            var discountType = 1;
            doTicketsTotal(discountValue);
        }else {
            maxTickets = 3;
            if ($seatTableBody.find('tr').length<maxTickets) {
                $seatObj.addClass('selected');
                $seatObj.removeClass('seat');
                var ticketPrice = 0;
                var discountTicketPrice = 0;
                var ticketPriceString = '';
                var discountValue = 0;
                var discountType = 1;
                ticketPrice = tripData.economy_class_fare -discountValue;
                if(0>0) {
                    ticketPriceString = '<strike style="color:red; font-size: 10px;">' + ticketPrice + '</strike> ' + discountTicketPrice + '.00';
                }else {
                    ticketPriceString = ticketPrice;
                }
                var tr = '<tr id="' + sData[0].ticket_id + '"><td width="115">' + sData[0].seat_number + '</td><td width="100">' + ticketPriceString + '</td><td>' + "Economy" + '<input type="hidden" name="'+sData[0].seat_number +'" value="'  + sData[0].ticket_id + '"/><input type="hidden" name="triproute[]" value="' + tripData.trip_route_id + '"/>'+ '<input type="hidden" name="trip_id" value="'  + sData[0].trip_id + '" /></td></tr>';
                $seatTableBody.append(tr);

                if($seatObj.hasClass("booked")) {
                    $seatObj.removeClass("selected");
                    // alert('#' + sData.ticket_id);
                    $("#" + sData[0].ticket_id).remove();
                    $("#seatError").text(
                    "Sorry! this ticket is not available now."
                    );
                    $("#seatError").removeClass("hidden");
                    $seatObj.addClass("booked");
                    $seatObj.removeAttr("onclick");
                }
                doTicketsTotal(discountValue);
            }else {
                $('#seatError').html('<div class="error-partial col-lg-12" style="padding:5px 20px;margin-top:0px;"><i class="fa fa-exclamation-triangle" style="font-size:20px;"></i><div class="error-message-div" style="padding:2px;">Maximum of ' + maxTickets + ' seat(s) can be booked at-a-time.</div></div>');
                $('#seatError').removeClass('hidden');
            }
        }
    }
    function doTicketsTotal(discountAmount)
    {
        var ticketsTotal = 0;
        var $seatTableBody = $('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)');
        var $seatTableTr = $seatTableBody.find('tr');
        $.each($seatTableTr, function(index, trObj) {
            ticketsTotal += parseFloat($(trObj).find('td:eq(1)').text()) - discountAmount;
        });
        $('div#tickets_total').html('<p><b>Total: ' + ticketsTotal + '</b></p>');
    }
</script>
@endsection
@section('addition-styles')
<style>
    .booked {
        background: #cc5560;
    }

    .hidden {
        display: none;
    }

    #tbl_offer {
        border-bottom: 1px dashed #97999b;
        font-size: 11px;
    }

    div.seat {
        cursor: pointer;
        background: #d3d3d3;
    }

    div.seat:hover {
        background: #54c581;
    }

    .selected {
        background: #54c581;
    }

    .t_total {
        border: #dbdbdb 1px solid;
        font-size: 14px;
        background: #f7f7f7;
    }

    .t_data {
        height: 150px;
        overflow-y: hidden;
    }

    .border-right-1 {
        border-right: 1px solid #D5D5D5;
    }

    .no-padding {
        padding: 0 !important;
    }

    .ticket-picker .details {
        padding: 15px 0 25px 0;
    }

    .ticket_text {
        font-size: 12.5px;
        line-height: 15px;
        color: #828282;
    }

    .ticket-picker p.bold_ticket_text {
        margin: 0;
    }

    .bold_ticket_text {
        font-weight: 500;
        font-size: 15px;
        line-height: 22px;
        color: #4f4f4f;
    }

    .button_set {
        position: absolute;
        bottom: 25px;
        right: 15px;
    }

    .next_prev_button {
        width: 87px;
        height: 30px;
        background: #ebf4ee;
        border-radius: 17px;
        border: 0;
        left: 788px;
        top: 202px;
        font-weight: bold;
        font-size: 9.5px;
        line-height: 11px;
        text-transform: uppercase;
        color: #9d6207;
        outline: none;
    }

    .return_left {
        align-self: center;
    }

    .return_button {
        width: 149px;
        height: 30px;
        background: #9d6207;
        border-radius: 3px;
        font-weight: 500;
        font-size: 12px;
        border: 0;
        text-align: center;
        color: #ffffff;
    }

    .mod_search {
        margin-top: 15px;
    }

    #search_list_sec p span {
        color: #9d6207;
        font-size: 10px;
    }
    }

    .modify_search {
        width: 107px;
        height: 9px;
        font-weight: bold;
        font-size: 10px;
        line-height: 12px;
        text-align: center;
        text-decoration-line: underline;
        text-transform: uppercase;
        color: #079d49;
        margin: 20px 0 0 0;
    }

    .bodytop {
        position: relative;
        top: 50px;
    }

    .selectcheckbox {
        position: relative;
        display: block;
        width: 100%;
        font-size: 15px;
        color: #079D49;
        font-weight: bold;
        text-align: left !important;
        background-color: white;
        padding-left: 15px;
        min-height: 43px;
    }

    button.selectcheckbox:focus,
    button.selectcheckbox:active {
        box-shadow: none;
        outline: 0;
    }

    .hidden_input {
        display: none;
    }

    .no-margin {
        margin-top: 0;
        margin-bottom: 0;
    }

    .label_class {
        cursor: pointer;
        font-size: 12px;
        color: #4F4F4F;
    }

    .hidden_input+.label_class:before {
        width: 13px;
        height: 13px;
        border-radius: 2px;
        background: #E6E6E6;
        position: relative;
        display: inline-block;
        margin-right: 1ex;
        content: "";
    }

    .hidden_input:checked+.label_class:before {
        background: #079D49;
    }

    .hidden_input:checked+.label_class {
        font-weight: bold;
    }

    .paddingcheckbox {
        padding-left: 10px;
    }

    .btn-default {
        background: #985;
    }
</style>
@endsection