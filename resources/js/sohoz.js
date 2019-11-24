$(document).ready(function() {
    $(".btnClose").on("click", function() {
        releaseAllSeats($(this).closest(".trseats"));
        // $(this).closest('table').find('td').css('border-bottom', '15px solid #F7F7F7');
        // $('.list_rows table td.border-fix-seat').css('border-bottom', '15px solid #F7F7F7');
    });
    $(window).on("unload", function() {
        releaseAllSeats();
    });
    $(".view_seat_bg")[0].scrollIntoView();
});
function toTitleCase(str) {
    return str.replace(/\b\w/g, function(txt) {
        return txt.toUpperCase();
    });
}
function submitConfirm(objContBtn) {
    var allOkay = true;
    var is_eid_ticket = "0";
    $("#errormsg").addClass("hidden");
    $("#errormsg2").addClass("hidden");
    if (
        $("#tbl_price_details")
            .find("table#tbl_seat_list")
            .find("tbody:eq(0)")
            .find("tr").length < 1
    ) {
        $("#errormsg")
            .text("Please choose your seat before you continue.")
            .removeClass("hidden");
        allOkay = false;
    } else if ($("#boardingpoint").val() < 1) {
        $("#errormsg")
            .text("Please choose a boarding point")
            .removeClass("hidden");
        allOkay = false;
    } else if (is_eid_ticket == 1 && $("#dropingpoint").val() < 1) {
        $("#errormsg2")
            .text("Please choose a droping point")
            .removeClass("hidden");
        allOkay = false;
    } else if (
        showReturn == 1 &&
        $("#tbl_price_details")
            .find("table#tbl_seat_list")
            .find("tbody:eq(0)")
            .find("tr").length < maxTickets
    ) {
        $("#errormsg")
            .text("You need to select " + maxTickets + " seats.")
            .removeClass("hidden");
        allOkay = false;
    }

    if (allOkay) {
        $(window).off("unload");
        $("#searchid").val($("#www-search-id").val());

        // Start of CleverTap Integration
        // Event: Journey Seats Selected, Return Seats Selected
        var $contObj = $(objContBtn);
        var tripData = $contObj
            .closest("tr.trip-row-amenities")
            .prev()
            .data("trip");

        //console.log($('#tbl_price_details').find('table#tbl_seat_list').find('tbody:eq(0)').find('tr').length); return;
        // var journeyDate = $.datepicker.formatDate('d-M-yy', new Date(tripData.tripRoute.departure_date));
        var noOfSeats = $("#tbl_price_details")
            .find("table#tbl_seat_list")
            .find("tbody:eq(0)")
            .find("tr").length;
        // var returnDate = $.datepicker.formatDate('d-M-yy', new Date($('#dor').val()));
        var bp = $("#boardingpoint option:selected").text();
        var bpName = bp.split(" (");
        var fareString = $("#tickets_total")
            .find("p")
            .find("b")
            .text();
        var fare = fareString.split(": ");

        var cleverTapData = {
            Origin: toTitleCase(tripData.details.origin_city_name),
            Destination: toTitleCase(tripData.details.destination_city_name),
            // 'Journey Date': new Date($('div.oneway p#search_list_title').text().match(/(\d{2}\-\w*,\s\d{4}$)/g)[0]),
            "Event Source": "Web"
        };

        if ($("div#search_list_sec ul.nav-tabs li").length == 2) {
            var now = new Date();

            cleverTapData["Return Date"] = new Date(
                $("div.roundtrip p#search_list_title")
                    .text()
                    .match(/(\d{2}\-\w*,\s\d{4}$)/g)[0] +
                    " " +
                    now.getHours() +
                    ":" +
                    now.getMinutes() +
                    ":" +
                    now.getSeconds()
            );
        }

        if (
            $("div#search_list_sec ul.nav-tabs li.active a").text() ==
            "Departure"
        ) {
            cleverTapData["Journey Date"] = new Date(
                tripData.tripRoute.departure_date +
                    " " +
                    tripData.tripRoute.departure_time
            );

            cleverTapData["Journey Operator Name"] =
                tripData.operator.company_name;
            cleverTapData["Journey Operator ID"] = tripData.operator.company_id;
            // cleverTapData['Journey Trip Time'] = tripData.tripRoute.departure_time;
            cleverTapData["Journey Trip No"] = tripData.details.trip_number;
            cleverTapData["Journey Seats Available"] =
                tripData.details.available_seats;
            cleverTapData["Journey No of Seats"] = noOfSeats;
            cleverTapData["Journey Boarding Point"] = bpName[0];
            cleverTapData["Journey Ticket Fare"] = fare[1];
        } else {
            tempCleverTapData = JSON.parse(
                localStorage.getItem("tempCleverTapData")
            );

            // if (new Date() < tempCleverTapData.exp) {
            //cleverTapData['Journey Date'] = tempCleverTapData.journeyDate;
            // }

            localStorage.removeItem("tempCleverTapData");

            cleverTapData["Return Date"] = new Date(
                tripData.tripRoute.departure_date +
                    " " +
                    tripData.tripRoute.departure_time
            );
            cleverTapData["Return Operator Name"] =
                tripData.operator.company_name;
            cleverTapData["Return Operator ID"] = tripData.operator.company_id;
            // cleverTapData['Return Trip Time'] = tripData.tripRoute.departure_time;
            cleverTapData["Return Trip No"] = tripData.details.trip_number;
            cleverTapData["Return Seats Available"] =
                tripData.details.available_seats;
            cleverTapData["Return No of Seats"] = noOfSeats;
            cleverTapData["Return Boarding Point"] = bpName[0];
            cleverTapData["Return Ticket Fare"] = fare[1];
        }

        if ($("#dropingpoint").val() > 0) {
            var dp = $("#dropingpoint option:selected").text();
            var dpName = dp.split(" (");

            cleverTapData["Dropping Point"] = dpName[0];
        }

        if (
            $("div#search_list_sec ul.nav-tabs li.active a").text() ==
            "Departure"
        ) {
            clevertap.event.push("Journey Seats Selected", cleverTapData);
        } else {
            clevertap.event.push("Return Seats Selected", cleverTapData);
        }
        // End of CleverTap Integration

        //Track Facebook Event - InitiateCheckout
        var totalTixPrice = $("#tickets_total")
            .find("p")
            .find("b")
            .text();
        //alert(totalTixPrice.substr(7));
        fbq("track", "InitiateCheckout", {
            value: totalTixPrice.substr(7),
            currency: "BDT",
            num_items: $("#tbl_price_details")
                .find("table#tbl_seat_list")
                .find("tbody:eq(0)")
                .find("tr").length
        });

        /* var r = confirm("Due to current traffic conditions, the trip may get cancelled. Are you sure you want to proceed?");
            if (r == false) {
                return false;
            } */
        //////////////////////
        $("form#confirmbooking").submit();
    }
}
function chooseSeat(seatObj) {
    $("#seatError").addClass("hidden");
    var $seatObj = $(seatObj);
    var $seatTableBody = $("#tbl_price_details")
        .find("table#tbl_seat_list")
        .find("tbody:eq(0)");
    var sData = $seatObj.parent().data("seat");
    var tripData = $seatObj
        .closest("tr.trip-row-amenities")
        .prev()
        .data("trip");
    var discountAmount = 0;

    if ($seatObj.hasClass("selected")) {
        //un select a seat
        $seatObj.removeClass("selected");
        //alert('#' + sData.ticket_id);
        $("#" + sData.ticket_id).remove();
        $.ajax({
            url: "/booking/bus/seat/release",
            type: "POST",
            data: {
                ticketid: sData.ticket_id,
                routeid: tripData.tripRoute.trip_route_id,
                searchid: $("#www-search-id").val()
            }
        }).done(function(data) {});

        var ticketPrice = 0;
        var discountValue = 0;
        var discountType = 1;

        switch (parseInt(sData.fare_type_id)) {
            case 1:
                ticketPrice = tripData.tripRoute.economy_class_fare;
                if (discountType == 1) {
                    discountAmount = Math.floor(
                        (ticketPrice / 100) * discountValue
                    );
                } else {
                    discountAmount = discountValue;
                }
                break;
            case 2:
                ticketPrice = tripData.tripRoute.business_class_fare;
                discountAmount = 0;
                if (discountType == 1) {
                    discountAmount = Math.floor(
                        (ticketPrice / 100) * discountValue
                    );
                } else {
                    discountAmount = discountValue;
                }

                break;
            case 3:
                ticketPrice = tripData.tripRoute.special_class_fare;
                discountAmount = 0;
                if (discountType == 1) {
                    discountAmount = Math.floor(
                        (ticketPrice / 100) * discountValue
                    );
                } else {
                    discountAmount = discountValue;
                }
                break;
        }

        doTicketsTotal(discountAmount);
    } else {
        if (searchtocity == "kolkata" && companyId == soudiaOperatorID) {
            maxTickets = maxSoudiaKolTix;
        }
        if (companyId == emadOperatorId) {
            maxTickets = maxEmadTix;
        }
        if ($seatTableBody.find("tr").length < maxTickets) {
            //select a seat
            $seatObj.addClass("selected");
            var ticketPrice = 0;
            var discountTicketPrice = 0;
            var ticketPriceString = "";
            var discountValue = 0;
            var discountType = 1;
            switch (parseInt(sData.fare_type_id)) {
                case 1:
                    ticketPrice = tripData.tripRoute.economy_class_fare;
                    if (discountType == 1) {
                        discountAmount = Math.floor(
                            (ticketPrice / 100) * discountValue
                        );
                    } else {
                        discountAmount = discountValue;
                    }
                    discountTicketPrice =
                        tripData.tripRoute.economy_class_fare - discountAmount;
                    break;
                case 2:
                    ticketPrice = tripData.tripRoute.business_class_fare;
                    discountAmount = 0;
                    if (discountType == 1) {
                        discountAmount = Math.floor(
                            (ticketPrice / 100) * discountValue
                        );
                    } else {
                        discountAmount = discountValue;
                    }
                    discountTicketPrice =
                        tripData.tripRoute.business_class_fare - discountAmount;
                    break;
                case 3:
                    ticketPrice = tripData.tripRoute.special_class_fare;
                    discountAmount = 0;
                    if (discountType == 1) {
                        discountAmount = Math.floor(
                            (ticketPrice / 100) * discountValue
                        );
                    } else {
                        discountAmount = discountValue;
                    }
                    discountTicketPrice =
                        tripData.tripRoute.special_class_fare - discountAmount;
                    break;
            }
            if (0 > 0) {
                ticketPriceString =
                    '<strike style="color:red; font-size: 10px;">' +
                    ticketPrice +
                    "</strike> " +
                    discountTicketPrice +
                    ".00";
            } else {
                ticketPriceString = ticketPrice;
            }
            var tr =
                '<tr id="' +
                sData.ticket_id +
                '"><td width="115">' +
                sData.seat_number +
                '</td><td width="100">' +
                ticketPriceString +
                "</td><td>" +
                sData.fare_type_name +
                '<input type="hidden" name="ticket[]" value="' +
                sData.ticket_id +
                '"/><input type="hidden" name="triproute[]" value="' +
                tripData.tripRoute.trip_route_id +
                '"/></td></tr>';
            $seatTableBody.append(tr);
            $.ajax({
                url: "/booking/bus/seat/reserve",
                type: "POST",
                data: {
                    ticketid: sData.ticket_id,
                    routeid: tripData.tripRoute.trip_route_id,
                    searchid: $("#www-search-id").val()
                }
            }).done(function(response) {
                if (response.ack != 1) {
                    $seatObj.removeClass("selected");
                    alert("#" + sData.ticket_id);
                    $("#" + sData.ticket_id).remove();
                    $("#seatError").text(
                        "Sorry! this ticket is not available now."
                    );
                    $("#seatError").removeClass("hidden");
                    $seatObj.addClass("booked");
                    $seatObj.removeAttr("onclick");
                }
            });

            doTicketsTotal(discountAmount);
        } else {
            $("#seatError").html(
                '<div class="error-partial col-lg-12" style="padding:5px 20px;margin-top:0px;"><i class="fa fa-exclamation-triangle" style="font-size:20px;"></i><div class="error-message-div" style="padding:2px;">Maximum of ' +
                    maxTickets +
                    " seat(s) can be booked at-a-time.</div></div>"
            );
            $("#seatError").removeClass("hidden");
        }
    }
}
function doTicketsTotal(discountAmount) {
    var ticketsTotal = 0;
    var $seatTableBody = $("#tbl_price_details")
        .find("table#tbl_seat_list")
        .find("tbody:eq(0)");
    var $seatTableTr = $seatTableBody.find("tr");
    $.each($seatTableTr, function(index, trObj) {
        ticketsTotal +=
            parseFloat(
                $(trObj)
                    .find("td:eq(1)")
                    .text()
            ) - discountAmount;
    });
    $("div#tickets_total").html("<p><b>Total: " + ticketsTotal + "</b></p>");
}
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
