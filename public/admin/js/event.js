var Event = function () {
  this.__construct = function () {
    this.loader();
    this.commonForm();
    this.deleteItem();
    this.imageCommonFormNew();
    this.changeStatus();
    this.contentWrapper();
    this.getSettingWrapper();
    this.getFaqWrapper();
    this.getViewJobWrapper();
    this.logout();
    this.states();
    this.cities();
    this.sendNotificationSubmit();
    this.addsection();
  };

    this.loader = function () {
        $(document).ready(function () {
            $(".loader-admin").fadeOut("slow");
        });
    };
    
    this.commonForm = function(){
        $(document).on('submit', '#common-form', function(e){
              e.preventDefault();
            var url = $(this).attr("action");
            var postdata = $(this).serialize();
            $.post(url, postdata, function (out) {
                $(".form-group > .error").remove();
                if (out.result === 0) {
                    var a = 1;
                    for (var i in out.errors) {
                        $("#" + i).parents(".form-group").append('<span class="error text-danger">' + out.errors[i] + '</span>');
                        if(a == 1){
                            $("#" + i).focus();
                        }
                        a++;
                    }
                }
                if (out.result === -1) {
                    var message = '<button type="button" class="btn close" data-dismiss="alert" aria-label="Close"></button>';
                    $("#error_msg").removeClass('alert-warning alert-success admin_chk_suc').addClass('alert alert-danger alert-dismissable admin_chk_dng').show();
                    $("#error_msg").html(message + out.msg);
                    $("#error_msg").fadeOut(5000);
                }
                if (out.result === -2) {
                    var message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    $("#error_msg").removeClass('alert-danger alert-success').addClass('alert alert-danger alert-dismissable').show();
                    $("#error_msg").html(message + out.msg);
                    $("#error_msg").fadeOut(2000);
                    window.setTimeout(function () {
                        window.location.href = out.url;
                    }, 1000);
                }
                if (out.result === 1) {
                    var message = '<button type="button" class="btn close" data-dismiss="alert" aria-label="Close"></button>';
                    $("#error_msg").removeClass('alert-danger alert-danger admin_chk_dng').addClass('alert alert-success alert-dismissable admin_chk_suc').show();
                    $("#error_msg").html(message + out.msg);
                    $("#error_msg").fadeOut(5000);
                    window.setTimeout(function () {
                        window.location.href = out.url;
                    }, 2000);
                }
            });
        })
    }
    
    this.deleteItem = function(){
        $(document).on('click', '.delete-item', function(e){
            e.preventDefault();
            var url = $(this).attr("href");
            swal({
                title: "Do you really want to Delete?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post(url, '', function (out) {
                        if (out.result === 1) {
                            window.location.href = out.url;
                        }
                    });
                }
            });
        });
    };

    this.imageCommonFormNew = function () {
        $(document).on('submit', '#image-common-form-new', function (evt) {
            evt.preventDefault();
            $(".loader").fadeIn("slow");
            $.ajax({
                url: $(this).attr("action"),
                type: "post",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (out) {
                    $(".loader").fadeOut("slow");
                    $(".form-group > .error").remove();
                    if (out.result === 0) {
                        for (var i in out.errors) {
                            $("#" + i).parents(".form-group").append('<span class="error text-danger">' + out.errors[i] + '</span>');
                            $("#" + i).focus();
                        }
                    }
                    if (out.result === -1) {
                        var message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        $(".error_msg").removeClass('alert-warning alert-success').addClass('alert alert-danger alert-dismissable').show();
                        $(".error_msg").html(message + out.msg);
                        $(".error_msg").fadeOut(5000);
                        $('html, body').animate({
                            scrollTop: 0
                        }, 800);
                        return false;
                        if (out.url) {
                            window.location.href = out.url;
                        }
                    }

                    if (out.result === 1) {
                        var message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        $(".error_msg").removeClass('alert-warning alert-success').addClass('alert alert-success alert-dismissable').show();
                        $(".error_msg").html(message + out.msg);
                        window.setTimeout(function () {
                            $('.error_msg').slideUp();
                            if (out.url) {
                                window.location.href = out.url;
                            }
                        }, 2000);
                    }
                }
            });
        });
    };

    this.changeStatus = function () {
        $(document).on('click', '.change-status', function (e) {
            e.preventDefault();
            var url = $(this).attr("href");
            $.post(url, function (out) {
                if (out.result === 1) {
                    $('html, body').animate({
                        scrollTop: $(".card").offset().top
                    }, 500);
                    var message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>';
                    $("#res_status").removeClass('alert-warning alert-danger').addClass('alert alert-success alert-dismissable').show();
                    $("#res_status").html(message + out.msg);
                    $("#res_status").fadeOut(2000);
                    window.setTimeout(function () {
                       location.reload();
                    }, 2000);
                }
            });
        });
    };

    this.contentWrapper = function () {
        $(document).ready(function () {
            var url = $('#content-wrappers').data('url');

            $.post(url, '', function (out) {
                if (out.result === 1) {
                    $('#content-wrappers').html(out.content_wrapper);
                     $('#dataTable').DataTable({
                        responsive: true,
                        destroy: true
                    });
                }
            });
        });
    };

    this.getSettingWrapper = function () {
        $(document).on('click', '.edit_settings', function(evt){
            evt.preventDefault();
            $("#settings").modal('show');
            var url = $(this).data("url");
            $.post(url, '', function (out) {
                $("#set_wrap").html(out.content_wrapper);
                CKEDITOR.replace('description');
            });
        })
    }

    this.getFaqWrapper = function () {
        $(document).on('click', '.edit_faqs', function(evt){
            evt.preventDefault();
            $("#add_faq").modal('show');
            var url = $(this).data("url");
            $.post(url, '', function (out) {
                $("#faq_wrap").html(out.content_wrapper);
                CKEDITOR.replace('description');
            });
        })
    }

    this.getViewJobWrapper = function () {
        $(document).on('click', '.view_job', function(evt){
            evt.preventDefault();
            $("#viewjob").modal('show');
            var url = $(this).data("url");
            $.post(url, '', function (out) {
                $("#viewjob_wrapper").html(out.content_wrapper);
            });
        })
    }

    this.logout = function(){
        $(document).on('click', '.logout', function(evt){
            evt.preventDefault();
            var url = $(this).attr('href');
            swal({
                title: "Are you sure you want to logout?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            })
            .then((willDelete) => {
                if (willDelete){
                    $.post(url, '', function(out){
                        if(out.result === 1){
                            window.location.href = out.url;
                        }
                    });
                }
            });
        });
    }

    this.states = function () {
        $(document).on('change', '#country', function (e) {
            e.preventDefault();
            var val = $(this).val();
            var url = $(this).data('url');
            $.post(url, {val: val}, function (out) {
                if (out.result === 1) {
                    var html = '<option value"">--Select State--</option>';
                    for (var i in out.state) {
                        html += "<option value='" + i + "'>" + out.state[i] + "</option>";
                    }
                    $('#state').html(html);
                }
            });
        });
    };

    this.cities = function () {
        $(document).on('change', '#state', function (e) {
            e.preventDefault();
            var val = $(this).val();
            var url = $(this).data('url');
            $.post(url, {val: val}, function (out) {
                if (out.result === 1) {
                    var html = '<option value"">--Select City--</option>';
                    for (var i in out.city) {
                        html += "<option value='" + i + "'>" + out.city[i] + "</option>";
                    }
                    $('#city').html(html);
                }
            });
        });
    };

    this.sendNotificationSubmit = function () {
        $(document).on('click', '.notify', function (evt) {
            evt.preventDefault();
            if ($('.users_id:checked').length > 0) {
                var url = $(this).attr('href');
                var user_id = [];
                $.each($(".users_id:checked"), function () {
                    user_id.push($(this).val());
                });
                $.post(url, {user_id: user_id}, function (out) {
                    if (out.result === 1) {
                        $('#send-notification-wrapper').html(out.notification_wrapper);
                        $('#notificationModal').modal('show');
                    }
                });
            } else {
                alert('Please select a user to send notification');
            }
        });

        $(document).on('click', '.check', function () {
            if ($(this).prop("checked") === true) {
                $(".users_id").prop("checked", true);
            } else if ($(this).prop("checked") === false) {
                $(".users_id").prop("checked", false);
            }
        });

        $(document).on('submit', '#send-notification', function (evt) {
            evt.preventDefault();
            var url = $(this).attr("action");
            var postdata = $(this).serialize();
            $.post(url, postdata, function (out) {
                $(".loader").fadeOut("slow");
                $(".form-group > .text-danger").remove();
                if (out.result === 0) {
                    for (var i in out.errors) {
                        $("#" + i).parents(".form-group").append('<span class="text-danger">' + out.errors[i] + '</span>');
                    }
                }
                if (out.result === 1) {
                    var message = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    $(".error_msg").removeClass('alert-danger alert-danger').addClass('alert alert-success alert-dismissable').show();
                    $(".error_msg").html(message + out.msg);
                    $(".error_msg").fadeOut(2000);
                    $('#notificationModal').modal('hide');
                }
            });
        });
    };

    this.addsection = function(){
        $(document).on('click', "#addsection", function(){
            if($(".fa-minus-square:last").data("active")){
                var a = parseInt($(".fa-minus-square:last").data("active"))+parseInt(1);
            }else{
                var a = 3;
            }
            var data = $(".newsection_chk").html();
            data = data.replace("course","course"+a);
            data = data.replace("fee","fee"+a);
            data = data.replace('id="fee"','id="fee'+a+'"');
            data = data.replace('for="fee"','for="fee'+a+'"');
            data = data.replace('name="fee"','name="fee'+a+'"');
            data = data.replace('id="course"', 'id="course'+ a +'" ');
            data = data.replace('name="err_chk[]" value=""','name="err_chk[]" value="'+a+'"');
            data = data.replace('err_chk"',"err_chk"+a+'"');
            data = data.replace('data-select2-id="course"', 'data-select2-id="course'+ a +'"');
            data = data.replace("select1231","sel"+a);
            $(".sectionMore").append("<div class='row newsection'>" + data + "<a href='javascript:void(0);' class='remove'><i class='fa fa-minus-square pull-right' data-active='"+ a +"' aria-hidden='true'></i></a></div>"); 
            $('.sel'+a).select2();
        });
        $(document).on("click", "a.remove" , function() {
            $(this).parent().remove();
        });
    }
  
  this.__construct();
};
var obj = new Event();