@extends('master.public')

@section('page-title')
Online Bus Ticket Reservation System
@endsection
@section('main-content')
{{-- {{dd($data)}} --}}
<div class="container-fluid">
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
                <div class="padding-left-15">
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
                                <tr id="{{$detail->trip_id}}" class="trip-row">
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
                                            <li class="seats-button"><button type="submit" id="{{$detail->trip_id}}"
                                                    triproute="{{$detail->trip_route_id}}"
                                                    operatorid="{{$detail->operator_id}}"
                                                    tocity="{{$detail->destination_city_name}}"
                                                    class="btn btn-default btn-sm btnSubmit seatsLayout"
                                                    data-toggle="modal" data-target="#bus_seat">View
                                                    Seats</button>
                                            </li>

                                        </ul>
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
</div>
<!-- Modal -->
<div class="modal fade" id="bus_seat" tabindex="-1" role="dialog" aria-labelledby="bus_seat" aria-hidden="true">
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
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10 seat" data-toggle="tooltip" onclick="chooseSeat(this)">
                                    {{$seatRow[$i].'1'}}
                                </div>
                            </td>
                            <td style="width: 50px; margin:5px;">
                                <div class="text-center p-10 seat">{{$seatRow[$i].'2'}}</div>
                            </td>
                            <td style=" width: 50px; margin:5px;">
                                <div class="text-center p-10" style="display: none">{{$seatRow[$i].'1'}}</div>
                            </td>
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10 seat">{{$seatRow[$i].'3'}}</div>
                            </td>
                            <td style="width: 50px; margin:5px">
                                <div class="text-center p-10 seat">{{$seatRow[$i].'4'}}</div>
                            </td>

                            </tr>
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
                            <p><b>Total: 480</b></p>
                        </div>
                        <div class="form-group">
                            <label for="bpt">Choose Boarding Point <span>*</span></label>
                            <select id="boardingpoint" name="boardingpoint" class="form-control">
                                <option value="0"> -- Boarding points -- </option>
                                <option value="52418971">Mohakhali Bus Point (10:30 PM)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p id="tripAlert" class="" style="color: #ccc; margin-top:15px; text-align:center;"><i
                        class="fa fa-exclamation-triangle"></i> <i>Due to traffic condition, the trip may get
                        canceled.</i> </p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Continue</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('additional_script')
<script>
    function chooseSeat(seatObj) {
        $('#seatError').addClass('hidden');
        var $seatObj = $(seatObj);
        var $seatTableBody = $('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)');
        console.log($seatObj);
        console.log($seatTableBody);
    }
</script>
@endsection
@section('addition-styles')
<style>
    div.seat {
        cursor: pointer;
        background: #d3d3d3;
    }

    div.seat:hover {
        background: #54c581;
    }

    .t_total {
        padding: 5px;
        border: #dbdbdb 1px solid;
        font-size: 14px;
        margin-bottom: 20px;
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
