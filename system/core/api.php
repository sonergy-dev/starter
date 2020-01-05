<?php


require_once('rest.php');
   

    class Api extends Rest
    {
     public function __construct()
     {
         parent::__construct();
     }

     public function generate_token()
     {
       $email    = $this->validate_parameter("email", $this->param['email'], STRING);
       $password     = $this->validate_parameter("password", $this->param['password'], STRING);

       $auth_user = Signup::authenticate($email, $password);

            
        if(!$auth_user){
          $this->throw_error(INVALID_USER_PASS, "Username or password is incorrect.");
        } else {
           $check = check_if_obj_exits_table2("user_reg", "email", $email, "password", $password);
      
           if ($check == true) {
            $token = generate_token_with_time($auth_user->id);
            $data = ['token' => $token, 'user' => $auth_user];
            $this->return_response(SUCCESS_RESPONSE, $data);
           } else {
            $this->throw_error(NOT_ACTIVE, array('status' => "INACTIVE", 'msg' => "Sorry this account has not been activated."));
           }
        }
        

     }

     public function activate()
     {
       $email_code    = $this->validate_parameter("code", $this->param['code'], STRING);

       if(check_if_obj_exits_table("user_reg", "email_auth_code", $email_code)){
        
        $customer = Signup::findByDynamicFields("email_auth_code", $email_code);

        $customer->status = 1;

        if($customer->save()){
          // $msg =  "<br><p>Hi <b>" . $customer->first_name. " , ". $customer->last_name. "</b></p>
          // <p>The password for your Drivers Hood (".$customer->email.") has been successfully reset.\r\n</p>
          // <p>If you didn’t make this change or if you believe an unauthorized person has accessed your account,
          //   click <a href=\"http://drivershood.com/password/reset\">here</a> to reset your password immediately.";
          //   $html_email =  build_email($msg);
  
          // send_email(PASSWORD_RESET, $customer->email, $html_email);
  
  
          $data = ['message' =>  "Your account activation was successfully."];
          $this->return_response(SUCCESS_RESPONSE,  $data);
        }else{
          $this->throw_error(FAILED_QUERY,  " Unknown error has occurred. ");
        }

       }else{
        $this->throw_error(INVALID_USER_PASS,  "Authorization denied because you supplied invalid credentials.");
       }
       
     }

     public function change_password()
     {
       $code                = $this->validate_parameter("code", $this->param['code'], STRING);
       $new_password        = $this->validate_parameter("new_password", $this->param['new_password'], STRING);
       $confirm_password    = $this->validate_parameter("confirm_password", $this->param['confirm_password'], STRING);

       if(check_if_obj_exits_table("user_reg", "email_auth_code", $code)){
        if($new_password == $confirm_password){
          $customer = Signup::findByDynamicFields("email_auth_code", $code);

          $customer->password = sha1($new_password);

          if($customer->save()){
            $msg =  "<br><p>Hi <b>" . $customer->first_name. " , ". $customer->last_name. "</b></p>
            <p>The password for your Drivers Hood (".$customer->email.") has been successfully reset.\r\n</p>
            <p>If you didn’t make this change or if you believe an unauthorized person has accessed your account,
             click <a href=\"http://drivershood.com/password/reset\">here</a> to reset your password immediately.";
             $html_email =  build_email($msg);
    
            send_email(PASSWORD_RESET, $customer->email, $html_email);
    
    
            $data = ['message' =>  "A password changed successfully."];
            $this->return_response(SUCCESS_RESPONSE,  $data);
          }else{
            $this->throw_error(FAILED_QUERY,  " Unknown error has occurred. ");
          }
        }else{

          $this->throw_error(INVALID_USER_PASS,  "Password does not match");
    
        }
       }else{
        $this->throw_error(INVALID_USER_PASS,  "Authorization denied because you supplied invalid credentials.");
       }

     }


     public function reset_password()
     {
      $email = $this->validate_parameter("email", $this->param['email'], STRING);

      if(check_if_obj_exits_table("user_reg", "email", $email)){

        $token = generate_token_with_time($email);
        $email_generated_code  =  sha1($token);
        $customer = Signup::findByDynamicFields("email", $email);

        $customer->email_auth_code =  $email_generated_code;

        if($customer->save()){
          $msg =  "<br><p>Hi <b>" . $customer->user_name. "</b></p>
          <p>We recently received your request to reset your password.\r\n</p>
          <p>If you did not make this request, you can safely ignore this email. & it does not mean your account is in danger.
          </p>
  
          <p>But if you are the one that made the request, click on below link to reset your password
          
            <a href=\"https://drivershood.com/password/reset/".$email_generated_code."\">https://drivershood.com/password/reset/".$email_generated_code." </a>
          <p>If the above link can not click. Please copy the link to the browser's address bar to open it.</p>";
  
          $html_email =  build_email($msg);
  
          $weed = send_email(PASSWORD_RESET, $email, $html_email);
          // var_dump($weed);
  
          $data = ['message' =>  "A password reset link has been sent to your email address check your email for further instructions."];
          $this->return_response(SUCCESS_RESPONSE,  $data);
        }else{
          $this->throw_error(FAILED_QUERY,  " Unknown error has occurred. ");
        }
 
      }else{
        $this->throw_error(INVALID_USER_PASS, $email. " does not exist. check & try again. ");
      }
     
     }

     //register user and send activation email
     public function register_user()
     {


       $user_name = $this->validate_parameter("username", $this->param['user_name'], STRING);
      $email =      $this->validate_parameter("email", $this->param['email'], STRING);
      $password =   $this->validate_parameter("password", $this->param['password'], STRING);

      $token = generate_token_with_time($email);
      $email_generated_code  =  sha1($token);
      $customer = new Signup();

      $customer->email      =  $email;
      $customer->user_name =  $user_name;
      $customer->password   =  sha1($password);
      $customer->email_auth_code = $email_generated_code;
     
      if(check_if_obj_exits_table("user_reg", "email", $customer->email) == false){

      
        if( $customer->save()){
          $msg =  "<br><p>Hi <b>" . $customer->user_name. "</b></p>
                        <p>Thank you for choosing ".SITE_DOMAIN_NAME."!\r\n</p>
                        <p>Please click on the link below to complete the registration:</p>
                        
                          <a href=\"https://survey.com/activate/".$email_generated_code."\">https://survey.com/activate/".$email_generated_code." </a>
                        <p>If the above link can not click. Please copy the link to the browser's address bar to open it.</p>";

          $html_email =  build_email($msg);

          send_email(ACCOUNT_VERIFICATION, $customer->email, $html_email);
        
          $data = ['message' => "Your registration was successful!"];
          $this->return_response(SUCCESS_RESPONSE,  $data);
        }else{
          $this->throw_error(FAILED_QUERY, "Unknown error occurred.");
        }
      }else{
        $this->throw_error(FAILED_QUERY, "This email has already been asigned to a user.");
      }
     
     }

     public function resend_activation() {
      $email =      $this->validate_parameter("email", $this->param['email'], STRING);
      $password =   $this->validate_parameter("password", $this->param['password'], STRING);

      $check = getEmailCode("user_reg", "email", $email, "password", $password);

      if ($check) {
        $user_name = $check[0]['user_name'];
        $email_auth_code = $check[0]['email_auth_code'];

        $msg =  "<br><p>Hi <b>" .$user_name. "</b></p>
                      <p>Thank you for choosing ".SITE_DOMAIN_NAME."!\r\n</p>
                      <p>Please click on the link below to complete the registration:</p>
                      
                        <a href=\"https://survey.com/activate/".$email_auth_code."\">https://survey.com/activate/".$email_auth_code." </a>
                      <p>If the above link can not click. Please copy the link to the browser's address bar to open it.</p>";

        $html_email =  build_email($msg);

        send_email(ACCOUNT_VERIFICATION, $email, $html_email);
      
        $data = ['message' => "Activation email has been sent to your email address."];
        $this->return_response(SUCCESS_RESPONSE,  $data);

      }else{
        $this->throw_error(FAILED_QUERY, "Unknown error occurred.");
      }

     }

     public function check_api()
     {
      try {
        $token = $this->get_bearer_token();
        $payload = JWT::decode($token, SECRETE_KEY, ['HS256']);
        return $payload;
        //print_r($payload);
      } catch (\Throwable $th) {
        $this->throw_error(ACCESS_TOKEN_ERRORS, $th->getMessage());
      }

      // print_r($_SERVER);
     }
    }
    