$('document').ready(function(){
    $('.calendar-day').hover(
        function(){ $(this).addClass('select-date') },
        function(){ $(this).removeClass('select-date') }
    );
    $('.note').closest('.calendar-day').addClass('note-days');
    //loading modal
    $('.calendar-day').click(function(){
        var day = $('.select-date .day-number').text();
        var chosen = $('#input-date-'+ day + ' ' + '.note-wrapper').html();
        $('.note-view').html(chosen);
        $('#input-date').val($('#select-year').text() + '-' + $('#select-month').text() + '-' + day);
        $('#myModalLabel').text($('#select-month').text() +' / '+ day +' / '+ $('#select-year').text());
       //Bootstrap API
        $('#Modal').modal('show');
        //delete ajax
        $('.delete-button').click(function (e) {
            var id = $(this).attr('data-id');
            var deleteData = {
                action: 'delete',
                id: id
            };
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "note",
                data: deleteData,
                success:function(response){
//                    $('.note#'+id).fadeOut();
                    $('#Modal .note#'+id).fadeOut();
                    alert("Success! Refresh to see deletions.");
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
            });
        });//end delete
    });
        //submit note
        $("#form-submit").click(function (e) {
            e.preventDefault();
            if( $("#title").val() === '' || $('#body').val() === '')
            {
                alert("Please enter some text!");
                return false;
            }
            var myData = {
                action: 'new',
                date: $('#input-date').val(),
                title: $('#title').val(),
                body: $('#body').val()
            }
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "note",
                data: myData,
                success:function(response){
                    $("#title, #body").val('');
                    alert("Success! Refresh to see additions.");
                },
                error:function (xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
            });
        }); //end note
});
