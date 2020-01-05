<?php require_once("public/page-parts/site-header.php") ?>
<style>
#send-again {
    display: none;
}

.alert-warning {
    display: none;
}
</style>

<div class="container">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="https://res.cloudinary.com/mhmd/image/upload/v1569543678/form_d9sh6m.svg" alt="" class="img-fluid mb-3 d-none d-md-block">
            <h1>Login to your Account</h1>
            
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <div class="alert alert-warning" id="success-alert">
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
                <button type="button" id="resend" class="text-success font-weight-bold mr-4 right">Resend email</button>
                <div id="msg-div">
                    
                </div>
                
            </div>
            <form id="user_login_form">
                <div class="row">

                    <!-- User Name -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-user text-muted"></i>
                            </span>
                        </div>
                        <input id="email" type="email" name="email" placeholder="Email address" class="form-control bg-white border-left-0 border-md">
                    </div>

                    <!-- Password -->
                    <div class="input-group col-lg-12 mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md">
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <button type="submit" class="btn btn-primary btn-block py-2">
                            <span class="font-weight-bold">Login</span>
                        </button>
                    </div>

                    <!-- Divider Text -->
                    <!-- <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                        <div class="border-bottom w-100 ml-5"></div>
                        <span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
                        <div class="border-bottom w-100 mr-5"></div>
                    </div> -->

                    <!-- Social Login -->
                    <!-- <div class="form-group col-lg-12 mx-auto">
                        <a href="#" class="btn btn-primary btn-block py-2 btn-facebook">
                            <i class="fa fa-facebook-f mr-2"></i>
                            <span class="font-weight-bold">Continue with Facebook</span>
                        </a>
                        <a href="#" class="btn btn-primary btn-block py-2 btn-twitter">
                            <i class="fa fa-twitter mr-2"></i>
                            <span class="font-weight-bold">Continue with Twitter</span>
                        </a>
                    </div> -->

                    <!-- Already Registered -->
                    <div class="text-center w-100">
                        <p class="text-muted m-0 font-weight-bold">Don't Have an Account? <a href="user/register" class="text-primary ml-2">Signup</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


</div>
</div>
<div class="overlay"></div>




<script src="/public/static/js/app.js"></script>
<script type="text/javascript">
	// For Demo Purpose [Changing input group text on focus]
// $(function () {
//     $('input, select').on('focus', function () {
//         $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
//     });
//     $('input, select').on('blur', function () {
//         $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
//     });
// });
</script>

</body>
<script src="/public/static/js/user.js?v=<?php echo STATIC_VERSION ?>"></script>

</html>