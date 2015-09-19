<?php


?>
<div class="wrapper row first-user">
	<div class="columns medium-offset-4 medium-6"><h3>Please add the frist user</h3></div>
	<form id="signUp" action="new-user-processor" method="post">
	  <div class="row">
	   <div class="medium-4 columns">
	   &nbsp;
	   </div>
	    <div class="medium-4 columns">
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
</div> 
    <script>
    $('#formSubmit').click(function(e){
    	e.preventDefault();
      $.post('<?php echo $sc->siteURL ?>', $('#signUp').serialize(), function(data){
      	console.log(data);
      	if(data == 'signup_success') {
      		window.location = '<?php echo $sc->siteURL ?>';
      	}else{
      		$('#error').html(data);
      	}
      });
  	});
    </script>
