<div class="wrapper row">
  <form id="login" action="login-processor" method="post">
    <div class="">
     <div class="medium-4 columns">
     &nbsp;
     </div>
      <div class="medium-4 columns">
      <br><br><br>
        <div id="error"></div>
        <label>Email</label>
        <input type="text" name="email" placeholder="Username" />
        <label>Password</label>
        <input type="password" name="password" placeholder="Password" />
        <div class="row">
        <div class="small-6 columns">
        <button id="submit" type="submit" class="tiny">Login</button>
        </div>
        <div style="text-align: right;" class="small-6 columns">
        </div>
        </div>
      </div>
      <div class="medium-4 columns">
      &nbsp;
     </div>
    </div>
  </form>
  <div id="status"></div>
  </div>
        <script type="text/javascript">
$('#submit').click(function(e){
  e.preventDefault();
  console.log($('#login').serialize);
  $.post('login-processor', $('#login').serialize(), function(data){
    console.log(data);
    if(data == 'success'){
      window.location = '<?php echo $sc->siteURL; ?>';
    }else{
      $('#error').html(data);
    }
  });
})
</script>
