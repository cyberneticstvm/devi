$(function(){
    "use strict";
    var today = new Date().toISOString().split('T')[0];
    if(document.getElementsByName("date")[0])
        document.getElementsByName("date")[0].setAttribute('min', today);

    $(document).on('click','.dlt',function(e){
        e.preventDefault();
        var link = $(this).attr("href");
        Swal.fire({
            title: 'Are you sure want to delete this record?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link
            }
          })
    });

    $('.select2').select2({
      placeholder: "Select",
      allowClear: true
    });

    $("#branchSelector").modal('show');

    $(document).on("change", ".appTime", function(e){
        e.preventDefault();
        var form = document.getElementById('frmAppointment');
        var formData = new FormData(form);
        $.ajax({
            type: 'POST',
            url: '/ajax/appointment/time',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(res){
                var xdata = $.map(res, function(obj){
                    obj.text = obj.name || obj.id;
                    return obj;
                });
                $('.selAppTime').select2().empty();            
                $('.selAppTime').select2({data:xdata});
            },
            error: function(res){
                failed(res);
                console.log(res);
            }
        });
    })
})