<script>
    $('.datepicker').datepicker({
    showOn: "both",
    buttonImage: "/img/calendar.png",
    buttonImageOnly: true,
    dateFormat: "dd-M-yy",
    minDate: 0,
    maxDate: "+1M",
    onSelect:function(date, dtObj) {
    if($(this).attr('id') == 'doj') {
    $( "#dor" ).datepicker( "option", "minDate", date);
    // Eid date selection
    /* var date1 = new Date(date);
    var date2 = new Date("15-sept-2015");
    var timeDiff = (date1.getTime()-date2.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if(diffDays>=0)
    {
    $('#dor').val('');
    $('#dor').parent('.form-group').hide();
    }else
    {
    $('#dor').val('');
    $('#dor').parent('.form-group').show();
    } */
    // End date selection
    }
    }
    });
</script>