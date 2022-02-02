$(function(){
    $('.deleteBtn').click(function(){
        temp = $(this).parent().parent();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "DELETE",
            url: deleteUrl + $(this).data("id")
        })
        .done(function(response){
            temp.remove();
            $('#alerts').append('<div class="alertSuccess">' + response.message + '</div>');
        })
        .fail(function(response){
            $('#alerts').append('<div class="alertDanger">' + response.message + '</div>');
        })
    });
});