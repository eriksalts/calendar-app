$('document').ready(function(){


    //$('.note-view').html( $('.note-wrapper').append());
    //$('.note-wrapper').attr('id', 'input-date');
    var day = $('.select-date').text();
    $('#input-date' + day + '#note-wrapper').html();
    $('#calendar').find('.note').hide('.note');
    $('#calendar').find('button').hide('button');


    $('.calendar-day').hover(
        function(){ $(this).addClass('select-date') },
        function(){ $(this).removeClass('select-date') }
    );

    $('.calendar-day').click(function(){
        $('#input-date').val($('#select-year').text() + '-' + $('#select-month').text() + '-' + $('.select-date').text());
        $('.modal-title').text($('#select-month').text() +' / '+ $('.select-date').text() +' / '+ $('#select-year').text());




       //Bootstrap API
        $('#Modal').modal('show');
    });





//    $( ".note-view").replaceWith( "note" );


   // $( ".note-present" ).parent().addClass('note-background');

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

            console.log(myData);
            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "note", //Where to make Ajax calls
                data: myData, //Form variables
                success:function(response){
                    console.log(response);
                    $("#responds").append(response);
                    $("#title, #body").val(''); //empty text field on successful
                    $("#formsubmit").show(); //show submit button

                    alert("Success!");

                },
                error:function (xhr, ajaxOptions, thrownError){
                    console.log(thrownError);
                    $("#formsubmit").show(); //show submit button
                    alert(thrownError);
                }
            });
        });

        var deleteData = {
            action: 'delete',
            id: $('#note').attr('id')
        };
        $("#delete-button").click(function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST", // HTTP method POST or GET
                url: "note", //Where to make Ajax calls
                dataType:"text", // Data type, HTML, json etc.
                data:deleteData, //Form variables
                success:function(response){
                    //on success, hide  element user wants to delete.
                    $('#note').fadeOut();
                },
                error:function (xhr, ajaxOptions, thrownError){
                    //On error, we alert user
                    alert(thrownError);
                }
            });
        });


//        //##### Send delete Ajax request to response.php #########
//        $("body").on("click", "#responds .del_button", function(e) {
//            e.preventDefault();
//            var clickedID = this.id.split('-'); //Split ID string (Split works as PHP explode)
//            var DbNumberID = clickedID[1]; //and get number from array
//            var myData = 'recordToDelete='+ DbNumberID; //build a post data structure
//
//            $('#item_'+DbNumberID).addClass( "sel" ); //change background of this element by adding class
//            $(this).hide(); //hide currently clicked delete button
//
//            jQuery.ajax({
//                type: "POST", // HTTP method POST or GET
//                url: "response.php", //Where to make Ajax calls
//                dataType:"text", // Data type, HTML, json etc.
//                data:myData, //Form variables
//                success:function(response){
//                    //on success, hide  element user wants to delete.
//                    $('#item_'+DbNumberID).fadeOut();
//                },
//                error:function (xhr, ajaxOptions, thrownError){
//                    //On error, we alert user
//                    alert(thrownError);
//                }
//            });
//        });
//
//    });
});
