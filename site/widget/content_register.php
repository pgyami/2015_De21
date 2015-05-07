
<!doctype html>
<html>

<?php

   $fields = [
        'user_name' => [
            'type' => 'text',
            'label' => 'Username',
            'icon' => 'fa fa-fw fa-edit',
            'validator' => [
                'minLength' => 1,
                'maxLength' => 25,
                'label' => 'Username'
            ],
            'placeholder' => 'User name'
        ],
        'display_name' => [
            'type' => 'text',
            'label' => 'Display Name',
            'icon' => 'fa fa-fw fa-edit',
            'validator' => [
                'minLength' => 1,
                'maxLength' => 50,
                'label' => 'Display name'
            ],
            'placeholder' => 'Display name'
        ],          
        'email' => [
            'type' => 'text',
            'label' => 'Email',
            'icon' => 'fa fa-fw fa-envelope',
            'validator' => [
                'minLength' => 1,
                'maxLength' => 150,
                'email' => true,
                'label' => 'Email'
            ],
            'placeholder' => 'Email address'
        ],
        'password' => [
            'type' => 'password',
            'label' => 'Password',
            'icon' => 'fa fa-fw fa-key',
            'validator' => [
                'minLength' => 8,
                'maxLength' => 50,
                'label' => 'Password',
                'passwordMatch' => 'passwordc'
            ],
            'placeholder' => '8-50 characters'
        ],
        'passwordc' => [
            'type' => 'password',
            'label' => 'Confirm password',
            'icon' => 'fa fa-fw fa-key',
            'validator' => [
                'minLength' => 8,
                'maxLength' => 50,
                'label' => 'Password'
            ],
            'placeholder' => 'Re-enter your password'
            
        ],
        'captcha' => [
            'type' => 'text',
            'label' => 'Confirm Security Code',
            'icon' => 'fa fa-fw fa-eye',
            'validator' => [
                'minLength' => 1,
                'maxLength' => 50,
                'label' => 'Security code'
            ],
            'placeholder' => "Enter the code below, human!"            
        ]
    ];
    
    $captcha = generateCaptcha();
    
    $template = "
        <form name='newUser' class='form-horizontal' id='newUser' role='form' action='admin/api/create_user.php' method='post'>
		  <div class='row'>
			<div id='display-alerts' class='col-lg-12'>
		  
			</div>
		  </div>		
		  <div class='row'>
			<div class='col-sm-12'>
                {{user_name}}
            </div>
		  </div>
		  <div class='row'>
            <div class='col-sm-12'>
                {{display_name}}
            </div>
		  </div>
		  <div class='row'>
			<div class='col-sm-12'>
                {{email}}
            </div>
		  </div>		  
		  <div class='row'>
            <div class='col-sm-12'>
                {{password}}
            </div>
		  </div>
		  <div class='row'>
            <div class='col-sm-12'>
                {{passwordc}}
            </div>
		  </div>
		  <div class='row'>
            <div class='col-sm-12'>
                {{captcha}}
            </div>
          </div>
          <div class='form-group'>
            <div class='col-sm-12'>
                <img src='$captcha' id='captcha'>
            </div>
		  </div>
		  <br>
		  <div class='form-group'>
			<div class='col-sm-12'>
			  <button type='submit' class='btn btn-success submit' value='Register'>Register</button>
			</div>   
		  </div>
          <div class='collapse'>
            <label>Spiderbro: Don't change me bro, I'm tryin'a catch some flies!</label>
            <input name='spiderbro' id='spiderbro' value='http://'/>
          </div>          
		</form>";
    
    $fb = new FormBuilder($template, $fields, [], [], true);
    
  ?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="public/css/bootstrap-theme.min.css" />
<title>Registration Form</title>
</head>
<body>


    <div class="panel panel-success">
      <div class="panel-heading">New Registration</div>
      <div class="panel-body"> <?php echo $fb->render(); ?></div>
    </div>
 

<script>
	$(document).ready(function() {
		// Load navigation bar
	/*	$(".navbar").load("header-loggedout.php", function() {
            $(".navbar .navitem-register").addClass('active');
        });
		*/
		// Process submission
        $("form[name='newUser']").submit(function(e){
			e.preventDefault();
            var form = $(this);
            var errorMessages = validateFormFields('newUser');
			if (errorMessages.length > 0) {
				$('#display-alerts').html("");
				$.each(errorMessages, function (idx, msg) {
					$('#display-alerts').append("<div class='alert alert-danger'>" + msg + "</div>");
				});	
			} else {
                // Process form                    
                // Serialize and post to the backend script in ajax mode
                var serializedData = form.serialize();
                serializedData += '&ajaxMode=true';     
                //console.log(serializedData);
            
                var url = APIPATH + "create_user.php";
                $.ajax({  
                  type: "POST",  
                  url: url,  
                  data: serializedData
                }).done(function(result) {
                  var resultJSON = processJSONResult(result);
                  if (resultJSON['errors'] && resultJSON['errors'] > 0){
                        console.log("error");
						// Reload captcha
						var img_src = APIPATH + 'generate_captcha.php?' + new Date().getTime();
                        $.ajax({  
                          type: "GET",  
                          url: img_src,  
                          dataType: "text"
                        }).done(function(result) { 
                            $('#captcha').attr('src', result);
                            form.find('input[name="captcha"]' ).val("");
                            alertWidget('display-alerts');
                            return;
                        });
                  } else {
                    window.location.replace('');
                  }
                });   
            }
		});
	});
</script>
</body>
</html>