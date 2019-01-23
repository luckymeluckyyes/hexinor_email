<?php 
session_start();
 ?>
<?php 
include('header.php');
include ('config.php');
if(isset($_SESSION['user']) && $_SESSION['user'] != '') {
    $user = $_SESSION['user'];
    $query = mysqli_query($conn,"SELECT * FROM companies WHERE email = '".$user."' ");
    $q = mysqli_fetch_array($query);
}
 ?>
 <script>
$(document).ready(function(){
    $("#pass").keyup(function(){
        var pass = $('#pass').val();

        var reg = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!,%,&,@,#,$,^,*,?,_,~]).{6,}/i;
        var validPass = reg.test(pass);

        if(pass.length =='') {
            $('.pass_error').remove();
            $('#pass_below').after('<span class="pass_error error">Password is required</span>');
        }
        // else if(!validPass){
        //     $('.pass_error').remove();
        //     $('#pass_below').after('<span class="pass_error error">Invalid password</span>');
        //     // $('.pass_error').show();
        // }
         else {
            $('.pass_error').hide();
        }
    });
    $("#cpass").keyup(function(){
        var cpass = $('#cpass').val();
        var pass = $('#pass').val();

        if(cpass.length == 0) {
            $('.cpass_error').remove();
            $('#cpass_below').after('<span class="cpass_error error">Confirm Password is required</span>');
        }
        // else if(pass != cpass) {
        //     $('.cpass_error').remove();
        //     $('#cpass_below').after('<span class="cpass_error error">Password not match</span>');
        //     // $('.cpass_error').show();
        // }
         else {
            $('.cpass_error').hide();
        }
    });  
});
</script>
<script type="text/javascript">
	$(function(){
        $('#submit').click(function(){
            var s = $('#submit').val();
            var pass = $('#pass').val();
            var cpass = $('#cpass').val();

            // $('.error').remove();
            var reg = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!,%,&,@,#,$,^,*,?,_,~]).{6,}/i;
            var validPass = reg.test(pass);
            if(pass.length < 1) {
                $('.pass_error').remove();
                $('#pass_below').after('<span class="pass_error error">Password is required</span>');
                return false;
            }
            else if(!validPass) {
                $('.pass_error').remove();
                $('#pass_below').after('<span class="pass_error error">Invalid password</span>');
                return false;
            }
            else if(cpass.length < 1) {
                $('.cpass_error').remove();
                $('#cpass_below').after('<span class="cpass_error error">Confirm Password is required</span>');
                return false;
            }
            else if(pass != cpass) {
                $('.cpass_error').remove();
                $('#cpass_below').after('<span class="cpass_error error">Password not match</span>');
                return false;
            } else {
            console.log("Starting ajax");
            $.ajax({
                url: 'ajax_company_register_step_two.php',
                type: 'post',
                data: {
                    submit: s,
                    password: pass
                    // confirm_password: cpass
                },
                success:function(data) {
                    // alert('done');
                    window.location = "company_register_step_three.php";
                }
            });
        }
        });
    });

</script>
<link rel="stylesheet" type="text/css" href="css/company_register_step_two.css">
<a href="new_registration.php" class="new_user_reg">New User Registration</a>
<div class="container">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12 mx">
            <div class="heading"><h1>Registeration</h1></div>
        <form method="post" class="register_form_two">
			<div class="input-box">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<label for="Password">Password *</label>
				</div>
				<div class="col-md-8 col-sm-12 col-xs-12">
					<input type="password" id="pass" class="input-holder" name="password" placeholder="Password">
				</div>
                <div id="pass_below"></div>
			</div>
			<div class="input-box">
				<div class="col-md-4 col-sm-12 col-xs-12">
					<label for="Confirm Password">Confirm Password *</label>
				</div>
				<div class="col-md-8 col-sm-12 col-xs-12">
					<input type="password" id="cpass" class="input-holder" name="confirm_password" placeholder="Confirm Password">
                    <div id="cpass_below"></div>
				</div>
			</div>
			<div class="col-md-4 col-sm-12 col-xs-12">
				
			</div>
			<div class="col-md-8 col-sm-12 col-xs-12">
				<button class="btn btn-common log-btn" id="submit" name="submit" type="button">Create Account</button>
			</div>
        </form>
		</div>
	</div>
</div>



<?php 
include('footer.php');
 ?>