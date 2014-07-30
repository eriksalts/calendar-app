$('document').ready(function(){




//   $('#calendar').find('.note').hide('.note');
//   $('#calendar').find('button').hide('button');
//    $('.note-present').find('.note').show('.note');
//    $('.note-present').find('button').show('button');



    $('.calendar-day').hover(
        function(){ $(this).addClass('select-date') },
        function(){ $(this).removeClass('select-date') }
    );




    $('.calendar-day').click(function(){

        //$('.note-view').html( $('.note-wrapper').append());
        var day = $('.select-date .day-number').text();
        //$('.note-wrapper').attr('id','input-date-'+ day );
        var chosen = $('#input-date-'+ day + ' ' + '.note-wrapper').html();
        $('.note-view').html(chosen);


        $('#input-date').val($('#select-year').text() + '-' + $('#select-month').text() + '-' + day);

        $('#myModalLabel').text($('#select-month').text() +' / '+ day +' / '+ $('#select-year').text());
//        $('.note-view').append(chosen);
//        var chosen = $('#input-date-'+ day).html();

       //Bootstrap API
        $('#Modal').modal('show');


        $('.delete-button').click(function (e) {
            var id = $(this).attr('data-id');
            var deleteData = {
                action: 'delete',
                id: id
            };
            e.preventDefault();

            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "/note", //Where to make Ajax calls
                data: deleteData, //Form variables
                success:function(response){
                    //on success, hide  element user wants to delete.
                    console.log();
                    $('.note#'+id).hide();
                    $('.note#'+id).fadeOut();
                },
                error:function (xhr, ajaxOptions, thrownError){

                    //On error, we alert user
                    alert(thrownError);
                }
            });
        });


    });


//    $( ".note-view").replaceWith( "note" );


   // $( ".note-present" ).parent().addClass('note-background');


//    $('td').children('.note-wrapper').remove('.note-wrapper');

      //////////////////////////////////////////////////////////////
        $("#form-submit").click(function (e) {
            e.preventDefault();
            if( $("#title").val() === '' || $('#body').val() === '')
            {
                alert("Please enter some text!");
                return false;
            }

            $("#formsubmit").hide(); //hide submit button


            var myData = {
                action: 'new',
                date: $('#input-date').val(),
                title: $('#title').val(),
                body: $('#body').val()
            }

            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "/note", //Where to make Ajax calls
                data: myData, //Form variables
                success:function(response){
                    $("#responds").append(response);
                    $("#title, #body").val(''); //empty text field on successful
                    $("#formsubmit").show(); //show submit button

                    alert("Success!");

                },
                error:function (xhr, ajaxOptions, thrownError){

                    $("#formsubmit").show(); //show submit button
                    alert(thrownError);
                }
            });
        });


});
