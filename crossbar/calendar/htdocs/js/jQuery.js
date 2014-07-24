$('document').ready(function(){
    $(function() {
        $( "#datepicker" ).datepicker();
    });
    $('.calendar-day').hover(
        function(){ $(this).addClass('select-date') },
        function(){ $(this).removeClass('select-date') }
    );
    $('.calendar-day').click(function(){
        $('.modal-title').text($('.select-date').text())
        $('#Modal').modal('show');
    });


//    AJAX
    $.ajax({
        url:window.location,
        type:'POST',
        data:{
            date: 'select-date',
            title:,
            body:
        } ,
        success: function(){
//            close modal
//            add background-color to td
            location.reload();
        }
    });
});
