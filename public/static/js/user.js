$('#user_login_form').submit(function(event) {
    event.preventDefault();

    // disabledBtn("posting...", "dynamicBtnSubmitForm");
    // disabledBtn("posting...", "dynamicBtnSubmitForm2");
    var values = $('#user_login_form').serialize();



    $.ajax({
        url: "/authentication/user_auth",
        type: "POST",

        data: values,
        success: function(response) {
            // console.log(response);

            var data = JSON.parse(response);
            //  enableBtn("<i class=\"fas fa-plus-circle\"></i> Post", "dynamicBtnSubmitForm");
            // console.log(data.error);
            if (data.success) {
                // if(data.user_data){
                //     // alert(data.user_data);

                //     var usertype = data.user_data.type;
                //     // document.cookie = "admintype = "+ usertype;

                //     var user_info = {
                //         "user_id" : data.user_data.id,
                //         "driver_id" : data.user_data.driver_id,
                //         "user_first_name" : data.user_data.first_name,
                //         "user_last_name" : data.user_data.last_name,
                //         "user_email" : data.user_data.email,
                //         "user_email_auth_code" : data.user_data.email_auth_code,
                //         "user_birth_date" : data.user_data.birth_date,
                //         "user_phone" : data.user_data.phone,
                //         "user_address" : data.user_data.address,
                //         "user_city" : data.user_data.city,
                //         "user_create_at" : data.user_data.create_at,
                //         "user_update_at" : data.user_data.update_at,
                //         "user_state" : data.user_data.state,
                //         "user_type" : data.user_data.type,
                //         "user_wages" : data.user_data.wages
                //     }

                    
                //     var storage_save = localStorage.setItem('user_info', JSON.stringify(user_info));
                    
                //     if (typeof localStorage.user_info !== 'undefined') {
                //         // console.log(user_info);
                //         // window.location.replace("/account/");

                //         if (usertype == "Driver") {
                //             window.location.replace("/employee/");
                //         } else {
                //             window.location.replace("/account/");
                //         }

                        
                //     } else {
                //         alert('nothing Saved');
                //     }


                    
                // }else{
                //     alert("No user came and conquered")

                // }
                window.location.replace("/account/");


            } else if (data.error) {
                console.log(data.error);
                $("#display_errors").html("<div class=\"msg msg-error z-depth-3 scale-transition\"> " + data.error.msg + " </div>");

                if (data.error.msg.status == "INACTIVE") {
                    $("#msg-div").html("<div class=\"msg msg-error z-depth-3 scale-transition font-weight-bold\"> " + data.error.msg.msg + " </div>");
                    $(".alert-warning").slideDown("slow");
                    
                    $('#resend').on({click: function (e) {
                        $.ajax({
                            url: "/authentication/reauthenticate",
                            type: "POST",
                    
                            data: values,
                            success: function(response) {
                    
                                var data = JSON.parse(response);
                                //  enableBtn("<i class=\"fas fa-plus-circle\"></i> Post", "dynamicBtnSubmitForm");
                                console.log(response);
                    
                                if (data.success) {
                                    // $("#user_register_form").hide();
                                    // $("#success_div").show();
                                    // alert('ok');
                    
                                } else if (data.error) {
                                    $("#display_errors").html("<div class=\"msg msg-error z-depth-3 scale-transition\"> " + data.error.msg + " </div>");
                    
                    
                    
                                }
                    
                    
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                // console.log(textStatus, errorThrown);
                            }
                    
                    
                        });
                        return false;

                    }})
                    
                }

            }
            // you will get response from your php page (what you echo or print)

        },
        error: function(jqXHR, textStatus, errorThrown) {
            // console.log(textStatus, errorThrown);
        }


    });
    return false;
});




$('#user_register_form').submit(function(event) {
    event.preventDefault();

    // disabledBtn("posting...", "dynamicBtnSubmitForm");
    // disabledBtn("posting...", "dynamicBtnSubmitForm2");
    var values = $('#user_register_form').serialize();



    $.ajax({
        url: "/authentication/user_registration",
        type: "POST",

        data: values,
        success: function(response) {

            var data = JSON.parse(response);
            //  enableBtn("<i class=\"fas fa-plus-circle\"></i> Post", "dynamicBtnSubmitForm");
            console.log(response);

            if (data.success) {
                $("#user_register_form").hide();
                $("#success_div").show();
                // alert('ok');

            } else if (data.error) {
                $("#display_errors").html("<div class=\"msg msg-error z-depth-3 scale-transition\"> " + data.error.msg + " </div>");



            }


        },
        error: function(jqXHR, textStatus, errorThrown) {
            // console.log(textStatus, errorThrown);
        }


    });
    return false;
});