$(document).ready(function() { 
    
    //
    function sticky_relocate() {
        var window_top = $(window).scrollTop() ;
        var footer_top = $(".main-footer").offset().top - 30;
        var div_top = $('#sticky-anchor').offset().top;
        var div_height = $(".sideNavTab").height();
        var leftHeight = $('.left-container').height(); 

        if (window_top + div_height > footer_top){
            $('.sideNavTab').removeClass('stick');
          $('.sideNavTab').addClass('abs');
           $('.right-conatainer').css('min-height', leftHeight + 'px');
          }
        else if (window_top > div_top) {
            $('.sideNavTab').addClass('stick');
            $('.sideNavTab').removeClass('abs');
        } else {
            $('.sideNavTab').removeClass('stick');
            $('.sideNavTab').removeClass('abs');
        }
    }

    $(function () {
        $(window).scroll(sticky_relocate);
        sticky_relocate();
    });

    //
    $('.selectize-single').selectize({
      delimiter: ',',            
      persist: true,
      create: false
    });
      
    //
    $('.selectize-multiple').selectize({
      plugins: ['remove_button'],
      delimiter: ',',            
      persist: true,
      create: false
    });
    
    //
    $('.summernote').summernote({   
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview', 'help']]
      ]
    });

    //
    $('.expiry_date').datepicker({
    });
    
    //
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    //
    $("#btnNext").click(function(event) {
        $('#isNext').val("1");
    });

    $("#btnSave").click(function(event) {
        $('#isNext').val("0");
    });

    //

  }); 

//
$('#addCategoryForm').on('submit', function (e) {

    e.preventDefault();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $(':input[type="submit"]').prop('disabled', true);

    $("#WaitingCat").show();

    $.ajax({
        
        url:'/admin/categories/add',
        type:'POST',
        data: $('#addCategoryForm').serialize(), 
        
        success: function () {                  

            $("#WaitingCat").hide();                

            $('#addCategoryForm')[0].reset();               
            $('#addCategory').modal('hide');
            $(':input[type="submit"]').prop('disabled', false);

            //
            $.ajax({
                url: '/admin/categories/all',
                type: 'GET',                    
                contentType : "application/json; charset=utf-8",
                cache : true,
                success : function(getRestDept) {                        
                    
                    $('#category_id').selectize()[0].selectize.destroy()
                    var $select = $('#category_id').selectize({
                                plugins: ['remove_button'],
                                maxItems: null, 
                                valueField: 'id',
                                labelField: 'name',                                   
                                options: getRestDept,
                                create: false
                            });
                    var control = $select[0].selectize;
                    control.clear();       

                },
                error : function(data) {
                    //console.log(data)

                }

            });                
            
            //
            
        }
    });

});

/******************/

$('#addVerticalForm').on('submit', function (e) {

    e.preventDefault();

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
});

$(':input[type="submit"]').prop('disabled', true);

$("#WaitingVertical").show();

    $.ajax({
        
        url:'/admin/vertical/add',
        type:'POST',
        data: $('#addVerticalForm').serialize(), 
        
        success: function () {                  

            $("#WaitingVertical").hide();                

            $('#addVerticalForm')[0].reset();               
            $('#addVertical').modal('hide');
            $(':input[type="submit"]').prop('disabled', false);

            //
            $.ajax({
                url: '/admin/vertical/all',
                type: 'GET',                    
                contentType : "application/json; charset=utf-8",
                cache : true,
                success : function(getRestDept) {                        
                    
                    $('#vertical_id').selectize()[0].selectize.destroy()
                    var $select = $('#vertical_id').selectize({
                                plugins: ['remove_button'],
                                maxItems: null, 
                                valueField: 'id',
                                labelField: 'name',                                   
                                options: getRestDept,
                                create: false
                            });
                    var control = $select[0].selectize;
                    control.clear();       

                },
                error : function(data) {
                    //console.log(data)

                }

            });                
            
            //
            
        }
    });

});