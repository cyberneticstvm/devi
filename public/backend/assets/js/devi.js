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

    $('[data-bs-toggle="tooltip"]').tooltip();

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
    });
    $(document).on("click", ".dltRow", function(){
        $(this).parent().parent().remove();
        calculateTotal();
    });

    $(document).on("change", ".selPdct", function(){
        var dis = $(this);
        var pid = dis.val();
        $.ajax({
            type: 'GET',
            url: '/ajax/productprice/'+pid,
            dataType: 'json',
            success: function(res){
                dis.parent().parent().find(".qty").val('1');
                dis.parent().parent().find(".price, .total").val(parseFloat(res.selling_price).toFixed(2));
                calculateTotal()
            }
        });
    });

    $(document).on("change", ".qty, .discount, .advance", function(){
        calculateTotal();
    });

    $(document).on("keydown", ".readOnly", function(event) { 
        return false;
    });

});

function addStoreOrderRow(category){
    $.ajax({
        type: 'GET',
        url: '/ajax/product/'+category,
        dataType: 'json',
        success: function(res){
            var xdata = $.map(res, function(obj){
                obj.text = obj.name || obj.id;
                return obj;
            });
            //$('.selPdct').last().select2().empty();                      
            $('.selPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
    if(category === 'lens'){
        $(".powerbox").append(`<tr><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td><td><select class="border-0" name="eye[]"><option value="re">RE</option><option value="le">LE</option><option value="both">Both</option></select></td><td><input type="text" name='sph[]' class="w-100 border-0 text-center" placeholder="SPH" maxlength="6" /></td><td><input type="text" name='cyl[]' class="w-100 border-0 text-center" placeholder="CYL" maxlength="6" /></td><td><input type="number" name='axis[]' class="w-100 border-0 text-center" placeholder="AXIS" step="any" max="360" /></td><td><input type="text" name='add[]' class="w-100 border-0 text-center" placeholder="ADD" maxlength="6" /></td><td><input type="text" name='dia[]' class="w-100 border-0 text-center" placeholder="DIA" maxlength="6" /></td><td><select class="border-0" name="thickness[]"><option value="not-applicable">Not applicable</option><option value="thin">Thin</option><option value="maximum-thin">Maximum Thin</option><option value="normal-thick">Normal Thick</option></select></td><td><input type="text" name='ipd[]' class="w-100 border-0 text-center" placeholder="IPD" maxlength="6" /></td><td><select class="form-control select2 selPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name='qty[]' class="w-100 border-0 text-end qty" placeholder="0" min='1' step="1" required /></td><td><input type="number" name='unit_price[]' class="w-100 border-0 text-end price" placeholder="0.00" min='1' step="any" required readonly /></td><td><input type="number" name='total[]' class="w-100 border-0 text-end total" placeholder="0.00" min='1' step="any" required readonly /></td></tr>`);
    }
    if(category === 'frame'){
        $(".powerbox").append(`<tr><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td><td colspan="8"><select class="border-0" name="eye[]"><option value="frame">Frame</option></select><div class="d-none"><input type="hidden" name="sph[]" /><input type="hidden" name="cyl[]" /><input type="hidden" name="axis[]" /><input type="hidden" name="add[]" /><input type="hidden" name="dia[]" /><input type="hidden" name="ipd[]" /><input type="hidden" name="thickness[]" /></div></td><td><select class="form-control select2 selPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name='qty[]' class="w-100 border-0 text-end qty" placeholder="0" min='1' step="1" required /></td><td><input type="number" name='unit_price[]' class="w-100 border-0 text-end price" placeholder="0.00" min='1' step="any" required readonly /></td><td><input type="number" name='total[]' class="w-100 border-0 text-end total" placeholder="0.00" min='1' step="any" required readonly /></td></tr>`);
    }
    if(category === 'service'){
        $(".powerbox").append(`<tr><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td><td colspan="8"><select class="border-0" name="eye[]"><option value="service">Service</option></select><div class="d-none"><input type="hidden" name="sph[]" /><input type="hidden" name="cyl[]" /><input type="hidden" name="axis[]" /><input type="hidden" name="add[]" />
        <input type="hidden" name="dia[]" /><input type="hidden" name="ipd[]" /><input type="hidden" name="thickness[]" />
        </div></td><td><select class="form-control select2 selPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name='qty[]' class="w-100 border-0 text-end qty" placeholder="0" min='1' step="1" required /></td><td><input type="number" name='unit_price[]' class="w-100 border-0 text-end price" placeholder="0.00" min='1' step="any" required readonly /></td><td><input type="number" name='total[]' class="w-100 border-0 text-end total" placeholder="0.00" min='1' step="any" required readonly /></td></tr>`);
    }    
}

function calculateTotal(){
    var subtotal = 0; var nettot = 0;
    $(".powerbox tr").each(function(){ 
        var dis = $(this); 
        var qty = parseInt(dis.find(".qty").val()); var price = parseFloat(dis.find(".price").val()); var total = parseFloat(qty*price);
        dis.find(".total").val(total.toFixed(2));
        subtotal += (total > 0) ? total: 0;
    });
    $(".subtotal").val(parseFloat(subtotal).toFixed(2));
    var discount = parseFloat($(".discount").val());
    nettot = (discount > 0) ? subtotal - discount : subtotal;
    $(".nettotal").val(parseFloat(nettot).toFixed(2));
    var advance = parseFloat($(".advance").val());
    var balance = (advance > 0) ? nettot-advance : nettot;
    $(".balance").val(parseFloat(balance).toFixed(2));
}