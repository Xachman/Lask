<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tasks App</title>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" href="css/foundation.min.css" />
  </head>
  <body>
	<form id="signUp" action="new-user-processor" method="post">
	  <div class="row">
	   <div class="medium-4 columns">
	   &nbsp;
	   </div>
	    <div class="medium-4 columns">
	    <br><br><br>
	    <div id="error" style="color: red"></div>
			<lable>First Name</lable>
			<input type="text" name="first_name" placeholder="First Name" />
			<lable>Last Name</lable>
			<input type="text" name="last_name" placeholder="Last Name" />
	      	<label>Username</label>
	      	<input type="text" name="user" placeholder="Username" />
	      	<label>Email</label>
	      	<input type="text" name="email" placeholder="Example@example.com" />
	      	<label>Password</label>
	      	<input type="password" name="addpass" placeholder="Password" />
	      	<label>Re-Type Password</label>
	      	<input type="password" name="checkpass" placeholder="Password" />
	      	<button type="submit" id="formSubmit">Submit</button>
	    </div>
	    <div class="medium-4 columns">
	    &nbsp;
	   </div>
	  </div>
	</form>
    
    <script>
    $('#formSubmit').click(function(e){
    	e.preventDefault();
      $.post('new-user-processor', $('#signUp').serialize(), function(data){
      	console.log(data);
      	if(data == 'signup_success') {
      		window.location = '/login';
      	}else{
      		$('#error').html(data);
      	}
      });
  	});
    </script>
  </body>
</html>