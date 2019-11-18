
    var filterOperatorsArr = new Array();
    var filterBusTypesArr = new Array();
    var filterBoardingsArr = new Array();
    var filterBoardingsArr = new Array();
    var filterFacilityArr = new Array();
    var filterDroppingPointsArr = new Array();
    var filterDeptTimeArray = new Array();
    var filterArrivalTimeArray = new Array();
    var modalSelection;
    $(document).ready(function() {
        //Hide Seats Row and Modify Search on loading and toggle on click//
        $('.trseats').hide();
        $(".srch_container,.srch_container_head").hide();
        $(".mod_search").click(function() {
            $(".srch_container,.srch_container_head").show();
            $('.ticket-picker').hide();
        });

        $(".seach_header_container").click(function() {
            $(".srch_container,.srch_container_head").hide();
            $('.ticket-picker').show();

        });

        $(".return_button").click(function() {
            $(".srch_container,.srch_container_head").show();
            $('.ticket-picker').hide();
            $('#dor').focus()
        });

      
        //Bind Autoselect Dropdowns//
        $('.filter_menu[name=bustype]').multiselect({
            selectedText: "Bus Type",
            noneSelectedText: "Bus Type",
            click: function(event, ui){
                var checked = (ui.checked ? true : false);
                filterTripsByBusType(ui.value, checked);
            },
            checkAll: function(){
                uncheckAllBusTypes();
                $('#bustype option').each(function() {
                    var busTypeId = $(this).attr('value');
                    filterTripsByBusType(busTypeId, true);
                });
            },
            uncheckAll: uncheckAllBusTypes
        });
        $('.filter_menu[name=operator]').multiselect({
            selectedText: "Operator",
            noneSelectedText: "Operator",
            click: function(event, ui){
                var checked = (ui.checked ? true : false);
                filterTripsByOperator(ui.value, checked);
            },
            checkAll: function(){
                uncheckAllOperators();
                $('#operator option').each(function() {
                    var operatorId = $(this).attr('value');
                    filterTripsByOperator(operatorId, true);
                });
            },
            uncheckAll:uncheckAllOperators
        });
        $('.filter_menu[name=boarding]').multiselect({
            selectedText: "Boarding",
            noneSelectedText: "Boarding",
            click: function(event, ui){
                var checked = (ui.checked ? true : false);
                filterTripsByBoarding(ui.value, checked);
            },
            checkAll: function(){
                uncheckAllBoardings();
                $('#boarding option').each(function() {
                    var boardingId = $(this).attr('value');
                    filterTripsByBoarding(boardingId, true);
                });
            },
            uncheckAll: uncheckAllBoardings
        });
        $('table').tablesorter({
            //widgets        : ['zebra', 'columns'],
            usNumberFormat: false,
            sortReset: true,
            sortRestart: true,
            cssChildRow: "expand-child"
        });
        function toTitleCase(str)
        {
            return str.replace(/\b\w/g, function (txt) { return txt.toUpperCase(); });
        }
        //Toggle Seats Row on view and close click//
        $('.seatsLayout').on('click', function () {
            var $seatLayout = $(this).parent().parent().closest('tr').next().find('.trseats');
            releaseAllSeats($('.trseats'));
            // $(this).closest('tr').find('td').css('border-bottom', '0 solid #F7F7F7');
            // $(this).closest('tr').css('border-bottom', '15px solid #F7F7F7');

            if (!$seatLayout.is(':visible')) {
                $('.trseats').hide();
                $seatLayout.toggle();
                var $seatLayoutTd = $seatLayout.find('td:eq(0)');
                var imgUrl = window.location.protocol + '//' + window.location.host;
                $seatLayoutTd.html('<div style="text-align:center;height:200px;width:100%"><img src="' + imgUrl + '/img/shohoz_loader.gif" alt="Please wait" /></div>');
                companyId = $(this).attr('operatorid');
                searchtocity = $(this).attr('tocity').toLowerCase();
                $.ajax({
                    url: '/booking/trip/' + $(this).attr('id') + '/' + $(this).attr('triproute') + '/seat-selection/' + $('#www-search-id').val(),
                    type: 'POST',
                    data: {"trip": "onward" }
                }).done(function(data) {
                    $seatLayoutTd.html(data);

                    // Start of CleverTap Integration
                    // Event: Journey Seat Layout Viewed, Return Seat Layout Viewed
                    var tripData = JSON.parse($(this).parent().parent().closest('tr').attr('data-trip'));
                    // var journeyDate = $.datepicker.formatDate('d-M-yy', new Date(tripData.tripRoute.departure_date));

                    var cleverTapData = {
                        'Origin' : toTitleCase(tripData.details.origin_city_name),
                        'Destination' : toTitleCase(tripData.details.destination_city_name),
                        // 'Journey Date' : new Date(journeyDate),
                        'Event Source' : 'Web',
                    };

                    // if ($('div#search_list_sec ul.nav-tabs li').length == 2) {
                    //     cleverTapData['Return Date'] = new Date($('div.roundtrip p#search_list_title').text().match(/(\d{2}\-\w*,\s\d{4}$)/g)[0]);
                    // }

                    if (1 != 0) {
                        cleverTapData['Journey Date'] = new Date(tripData.tripRoute.departure_date + ' ' + tripData.tripRoute.departure_time);

                        // Return trip exists
                        if ($('div#search_list_sec ul.nav-tabs li').length == 2) {
                            now = new Date();

                            // Expires in 5 minutes
                            exp = now.setMinutes(now.getMinutes() + 5);

                            // Store it to localStorage
                            localStorage.setItem('tempCleverTapData', JSON.stringify({
                                'journeyDate': cleverTapData['Journey Date'],
                                'exp': exp
                            }));

                            now = new Date();

                            cleverTapData['Return Date'] = new Date($('div.roundtrip p#search_list_title').text().match(/(\d{2}\-\w*,\s\d{4}$)/g)[0] + ' ' + now.getHours() + ':' + now.getMinutes() + ':' + now.getSeconds());
                        }

                        cleverTapData['Journey Operator Name'] = tripData.operator.company_name;
                        cleverTapData['Journey Operator ID'] = tripData.operator.company_id;
                        // cleverTapData['Journey Trip Time'] = tripData.tripRoute.departure_time;
                        cleverTapData['Journey Trip No'] = tripData.details.trip_number;
                        cleverTapData['Journey Seats Available'] = tripData.details.available_seats;
                        cleverTapData['Journey Bus Type'] = tripData.bus.bus_type == 1 ? 'AC' : 'NAC';

                        clevertap.event.push('Journey Seat Layout Viewed', cleverTapData);
                    } else {
                        tempCleverTapData = JSON.parse(localStorage.getItem('tempCleverTapData'));

                        // if (new Date() < tempCleverTapData.exp) {
                        cleverTapData['Journey Date'] = tempCleverTapData.journeyDate;
                        // }

                        cleverTapData['Return Date'] = new Date(tripData.tripRoute.departure_date + ' ' + tripData.tripRoute.departure_time);
                        cleverTapData['Return Operator Name'] = tripData.operator.company_name;
                        cleverTapData['Return Operator ID'] = tripData.operator.company_id;
                        // cleverTapData['Return Trip Time'] = tripData.tripRoute.departure_time;
                        cleverTapData['Return Trip No'] = tripData.details.trip_number;
                        cleverTapData['Return Seats Available'] = tripData.details.available_seats;
                        cleverTapData['Return Bus Type'] = tripData.bus.bus_type == 1 ? 'AC' : 'NAC';

                        clevertap.event.push('Return Seat Layout Viewed', cleverTapData);
                    }
                    // End of CleverTap Integration
                }.bind(this));
            } else {
                $('.trseats').hide();
            }
        });
        var operator = decodeURIComponent((new RegExp('[?|&]operator=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [, ""])[1].replace(/\+/g, '%20')) || null;
        operator = parseInt(operator);
        if (operator > 0) {
            $("#operator").multiselect("widget").find(":checkbox[value='" + operator + "']").each(function() {
                this.click();
            });
        }
    });
    function onBusOperatorSelect(id,busTypeName){
         let isChecked = document.getElementById(`${id}filter`).checked;
         //filterTripsByBusType(id, isChecked,busTypeName);
         filterTripsByOperator(id, isChecked,busTypeName)
    }
    function onBusTypeSelect(id,busTypeName){
         let isChecked = document.getElementById(`${id}typefilter`).checked;
         filterTripsByBusType(id, isChecked,busTypeName)
    }
    function onBoardingPointSelect(id,busTypeName){
         let isChecked = document.getElementById(`${id}boardingfilter`).checked;
         filterTripsByBoarding(id, isChecked,busTypeName)
    }
    function onFacilitySelect(id,pointName){
         let isChecked = document.getElementById(`${id}facilityFilter`).checked;
         filterTripsByFacility(id, isChecked,pointName);
    }
    function onDroppingPointSelection(id,pointName){
         let isChecked = document.getElementById(`${id}dropppingFilter`).checked;
         filterTripsByDroppingPoints(id, isChecked,pointName);
    }
    function onDepartureSelection(id,text){
        let isChecked;
        isChecked = document.getElementById(`${id}`).checked;
        filterTripsByDeptTime(id, isChecked,text);
       
    }
    function onArrivalSelection(id,text){
        let rowId= id.slice(0,id.length-2);
        let isChecked;
        isChecked = document.getElementById(`${id}`).checked;
        filterTripsByArrivalTime(rowId, isChecked,text);
    }
    function filterTripsByDeptTime(typeId, selected,timeText)
    {
        if (selected) {+
            filterDeptTimeArray.push(parseInt(typeId));
            var filterText = '<li class="bustypetripfilter" id="deptTime' + typeId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByDeptTime(' + typeId + ', false)">' + timeText + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterDeptTimeArray = removeValueFromArray(typeId, filterDeptTimeArray);
            $('#deptTime' + typeId).remove();
            $(`#${typeId}`).prop('checked', false);
            $('#deptTime').find('option[value=' + typeId + ']').removeAttr('selected');
            $('#deptTime').multiselect('refresh');
            
        }
        
        filterTrips();
    }
    function filterTripsByArrivalTime(typeId, selected,timeText)
    {
        if (selected) {+
            filterArrivalTimeArray.push(parseInt(typeId));
            var filterText = '<li class="bustypetripfilter" id="arrival' + typeId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByArrivalTime(' + typeId + ', false)">' + timeText + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterArrivalTimeArray = removeValueFromArray(typeId, filterArrivalTimeArray);
            $('#arrival' + typeId).remove();
            $(`#${typeId}id`).prop('checked', false);
        }
        
        filterTrips();
    }
    function filterTripsByBusType(busTypeId, selected,busTypeName)
    {
        if (selected) {+
            filterBusTypesArr.push(parseInt(busTypeId));
            var filterText = '<li class="bustypetripfilter" id="bustype' + busTypeId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByBusType(' + busTypeId + ', false)">' + busTypeName + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterBusTypesArr = removeValueFromArray(busTypeId, filterBusTypesArr);
            $('#bustype' + busTypeId).remove();
            $(`#${busTypeId}typefilter`).prop('checked', false);
            $('#bustype').find('option[value=' + busTypeId + ']').removeAttr('selected');
            $('#bustype').multiselect('refresh');
            
        }
        filterTrips();
    }
    function showTripPolicies(tripId, selectedItem='cancelPolicy')
    {  
        $.ajax({
            url:"/booking/trip/" + tripId + "/policy/?selectedItem="+selectedItem,
            type: 'GET'
        }).done(function(data) {
            $('body').append(data);
            $('#myModal').modal({keyboard: true});
           $('#myModal').on('hidden.bs.modal', function (e) {
                $(this).remove();
            });
        });
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
                    "routeid":tripRouteId,
                    "searchid":$('#www-search-id').val()}
            }).done(function(data) {});
        });

//          Following Lines are written by Ayon
//          $('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)').find('tr').each(function(index, trObj) {
//              hiddenVals = $(trObj).find('td').last().find('input');
//              ticketId = $(hiddenVals[0]).val();
//              tripRouteId = $(hiddenVals[1]).val();
//              //console.log(ticketId);
//              //console.log(tripRouteId);
//              $.ajax({
//                    url: '/booking/bus/seat/release',
//                            type: 'POST',
//                            data: {"ticketid":ticketId,
//                          "routeid":tripRouteId,
//                          "searchid":$('#www-search-id').val()}
//                    }).done(function(data) {});
//          });
//          Above Lines are written by Ayon

        if ($trSeatsObj) {
            $trSeatsObj.find('td:eq(0)').html('');
        }
    }
    function uncheckAllOperators()
    {
        filterOperatorsArr = new Array();
        $('.operatortripfilter').remove();
        filterTrips();
    }
    function uncheckAllBusTypes()
    {
        filterBusTypesArr = new Array();
        $('.bustypetripfilter').remove();
        filterTrips();
    }
    function uncheckAllBoardings()
    {
        filterBoardingsArr = new Array();
        $('.boardingtripfilter').remove();
        filterTrips();
    }
    var companyId = 0;
    var minTickets = 1;
    var maxTickets = 4;
    var maxSoudiaKolTix = 1;
    var soudiaOperatorID = 8;
    var maxEmadTix = 1;
    var emadOperatorId = 64;
    var searchtocity = '';
    var showReturn =  0 ;
    function getOperatorName(operatorId)
    {
        var $operatorBox = $('#operator');
        return $operatorBox.find('option[value=' + operatorId + ']').text();
    }
    function getBusTypeName(busTypeId)
    {
        var $busTypeBox = $('#bustype');
        return $busTypeBox.find('option[value=' + busTypeId + ']').text();
    }
    function getBoardingName(boardingId)
    {
        var $boardingBox = $('#boarding');
        return $boardingBox.find('option[value=' + boardingId + ']').text();
    }

    function  checkDeptTimeRange(input) {
        let isInRange = false;
        let hourFromTr = input.split(":")[0];
        if(filterDeptTimeArray.length<=0) return true;
        for(let i = 0 ; i<filterDeptTimeArray.length; i++){
            if ((hourFromTr >= (filterDeptTimeArray[i]-6)) && (hourFromTr <= filterDeptTimeArray[i])){
                isInRange = true;
                break;
            }
        }
        return isInRange;
    }
    function  checkArrivalTimeRange(input) {
        let isInRange = false;
        let hourFromTr = input.split(":")[0];
        if(filterArrivalTimeArray.length<=0) return true;
        for(let i = 0 ; i<filterArrivalTimeArray.length; i++){
            if ((hourFromTr >= (filterArrivalTimeArray[i]-6)) && (hourFromTr <= filterArrivalTimeArray[i])){
                isInRange = true;
                break;
            }
        }
        return isInRange;
    }
    function filterTrips()
    {
        
        hideAllTrips();
        $('.trseats').hide();
        $('table#trips tbody').find('tr#notrip').remove();
        var $trips = $('table  tr.trip-row');
        console.log($trips);
        var visibleTrips = 0;
        $trips.each(function(){
            var $trip = $(this);
            var $tripAmenities = $trip.next();
            var tripData = $trip.data('trip');
            var tripOperatorId = parseInt(tripData.details.company_id);
            var tripBusTypeId = parseInt(tripData.bus.bus_type);
            var tripBoardingsArr = tripData.boardingPoints;
            var tripFacilitesArr = tripData.tripFacilities;
            var tripDroppingsArr = tripData.dropingPoints;
            var timeFilter = tripData.details.departure_time;
            var arrivalTimes = tripData.details.arrival_time;
            
             var deptTimeFilter= true;
             var arrivalTimeFilter= true;
            
            //departure time wise filter
            if(typeof(timeFilter) !=="undefined"){
                deptTimeFilter = checkDeptTimeRange(timeFilter)
            } 
            //arrival time wise filter
            if(typeof(arrivalTimes) !=="undefined"){
                arrivalTimeFilter = checkArrivalTimeRange(arrivalTimes)
            } 
            var tripBoardingArr = new Array();
            var tripFacilityIdArr = new Array();
            var tripDroppingIdIdArr = new Array();

            for (var i = 0; i < tripBoardingsArr.length; i++) {
                tripBoardingArr.push(parseInt(tripBoardingsArr[i].location_id));
            }
            for (var i = 0; i < tripFacilitesArr.length; i++) {
                tripFacilityIdArr.push(parseInt(tripFacilitesArr[i].facility_id));
            }
            for (var i = 0; i < tripDroppingsArr.length; i++) {
                tripDroppingIdIdArr.push(parseInt(tripDroppingsArr[i].location_id));
            }
            var busTypeFilter = true;
            var boardingFilter = true;
            var operatorFilter = true;
            var facilityFilter = true;
            var droppingFilter = true;
            //filter bus type
            if (filterBusTypesArr.length > 0) {
                if ($.inArray(tripBusTypeId, filterBusTypesArr) == - 1) {
                    busTypeFilter = false;
                }
            } else {
                busTypeFilter = true;
            }

            //boarding
            if (filterBoardingsArr.length > 0) {
                boardingFilter = false;
                $.each(tripBoardingArr, function(key, value) {
                    if ($.inArray(value, filterBoardingsArr) > - 1 && boardingFilter == false) {
                        boardingFilter = true;
                    }
                });
            } else {
                boardingFilter = true;
            }
              //dropping
              if (filterDroppingPointsArr.length > 0) {
                droppingFilter = false;
                $.each(tripDroppingIdIdArr, function(key, value) {
                    if ($.inArray(value, filterDroppingPointsArr) > - 1 && droppingFilter == false) {
                        droppingFilter = true;
                    }
                });
            } else {
                droppingFilter = true;
            }
              //facility
              if (filterFacilityArr.length > 0) {
                facilityFilter = false;
                $.each(tripFacilityIdArr, function(key, value) {
                    if ($.inArray(value, filterFacilityArr) > - 1 && facilityFilter == false) {
                        facilityFilter = true;
                    }
                });
            } else {
                facilityFilter = true;
            }

            //operators
            if (filterOperatorsArr.length > 0) {
                if ($.inArray(tripOperatorId, filterOperatorsArr) == - 1) {
                    operatorFilter = false;
                }
            } else {
                operatorFilter = true;
            }
            //shows each row only if filter is true
            if (operatorFilter == true && arrivalTimeFilter ==true && busTypeFilter == true && busTypeFilter == true && boardingFilter == true && facilityFilter==true && droppingFilter == true  && deptTimeFilter==true) {
                $trip.show();
                $tripAmenities.show();
                visibleTrips++;
            }
        });
        showHideFilterDiv();
        if (visibleTrips < 1) {
            var noTripMsg = '<tr id="notrip"><td colspan="6">We couldn\'t find trips to match your filters</td></tr>';
            $('table#trips tbody').append(noTripMsg);
        }

    }
    function filterTripsByOperator(operatorId, selected,operatorName)
    {
        if (selected) {
            //add to filter values
           // var operatorName = getOperatorName(operatorId);    
            filterOperatorsArr.push(parseInt(operatorId));
            var filterText = '<li class="operatortripfilter filter-text-container" id="operator' + operatorId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByOperator(' + operatorId + ', false)">' + operatorName + ' <i class="fa fa-times"></i></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterOperatorsArr = removeValueFromArray(operatorId, filterOperatorsArr);
            $('#operator' + operatorId).remove();
            $(`#${operatorId}filter`).prop('checked', false);
            $('#operator').find('option[value=' + operatorId + ']').removeAttr('selected');
            $('#operator').multiselect('refresh');}
        filterTrips();
    }
    function filterTripsByFacility(facilityId, selected,facilityName)
    {
        if (selected) {
            filterFacilityArr.push(parseInt(facilityId));
            var filterText = '<li class="boardingtripfilter" id="facility' + facilityId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByFacility(' + facilityId + ', false)">' + facilityName + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterFacilityArr = removeValueFromArray(facilityId, filterFacilityArr);
            $('#facility' + facilityId).remove();
            $(`#${facilityId}facilityFilter`).prop('checked', false);
          
        }
        filterTrips();
    }
    function filterTripsByDroppingPoints(droppingId, selected,pointName)
    {
       
        if (selected) {
            filterDroppingPointsArr.push(parseInt(droppingId));
            var filterText = '<li class="boardingtripfilter" id="droppping' + droppingId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByDroppingPoints(' + droppingId + ', false)">' + pointName + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterDroppingPointsArr = removeValueFromArray(droppingId, filterDroppingPointsArr);
            $('#droppping' + droppingId).remove();
            $(`#${droppingId}dropppingFilter`).prop('checked', false);
          
        }
        filterTrips();
    }
    function filterTripsByBoarding(boardingId, selected,boardingName)
    {
        if (selected) {
            //add to filter values
           // var boardingName = getBoardingName(boardingId);
            filterBoardingsArr.push(parseInt(boardingId));
            var filterText = '<li class="boardingtripfilter" id="boarding' + boardingId + '"><a class="anchor_style" href="javascript:void(0)" onclick="filterTripsByBoarding(' + boardingId + ', false)">' + boardingName + ' <i class="fa fa-times"></a></li>';
            $('div.filter_value ul.list-inline').append(filterText);
        } else {
            //remove from filter values
            filterBoardingsArr = removeValueFromArray(boardingId, filterBoardingsArr);
            $('#boarding' + boardingId).remove();
            $(`#${boardingId}boardingfilter`).prop('checked', false);
            $('#boarding').find('option[value=' + boardingId + ']').removeAttr('selected');
            $('#boarding').multiselect('refresh');
        }
        filterTrips();
    }
    function hideAllTrips()
    {
        $('.trip-row,.trip-row-amenities').hide();
    }
    function showHideFilterDiv()
    {
        var filterCount = $('div.filter_value ul.list-inline').find('li').length;
        if (filterCount < 2) {
            $('div.filter_value').addClass('hidden');
        }
        if (filterCount > 1) {
            $('div.filter_value').removeClass('hidden');
        }
    }
    function removeValueFromArray(removeValue, arrObj)
    {
        var newArr = [];
        for (var i = 0; i < arrObj.length; i++) {
            if (arrObj[i] != removeValue) {
                newArr.push(arrObj[i]);
            }
        }
        return newArr;
    }

    function showNotification()
    {
        $('#my-modal-notice').modal();
        return false;
    }
