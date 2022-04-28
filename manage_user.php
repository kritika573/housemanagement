<?php 
include('db_connect.php');
session_start();
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM users where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>
<div class="container-fluid">
	<div id="msg"></div>
	
	<form action="" id="manage-user" name="myform" >	
		<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control">
			<span id="name"></span>

		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" class="form-control"  autocomplete="off">
			<span id="username"></span>

		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" class="form-control" value="" autocomplete="off">
			<span id="password"></span>

			<?php if(isset($meta['id'])): ?>
			<small><i>Leave this blank if you dont want to change the password.</i></small>
		<?php endif; ?>
		</div>
		<?php if(isset($meta['type']) && $meta['type'] == 3): ?>
			<input type="hidden" name="type" value="3">
		<?php else: ?>
		<?php if(!isset($_GET['mtype'])): ?>
		<div class="form-group">
			<label for="type">User Type</label>
			<select name="type" id="type" class="custom-select">
				<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected': '' ?>>Flat Owner</option>
				<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected': '' ?>>Admin</option>
			</select>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		

	</form>
</div>
<script>
    	function validation(){

			var name=document.myform.name.value;
			var username=document.myform.username.value;
			var password=document.myform.username.value;

			document.getElementById('name').innerHTML ="";
			document.getElementById('username').innerHTML ="";
			document.getElementById('password').innerHTML ="";



			var flag=true;
			if (name.length === 0){
				document.getElementById("name").innerHTML="Please Enter Name";
				document.getElementById("name").style.color="Red";
				flag=false;
			}
			if (username.length === 0){
				document.getElementById("username").innerHTML="Please Enter username";
				document.getElementById("username").style.color="Red";
				flag=false;
			}
			if (password.length <=3 || password.length >15 || password.length === 0){
				document.getElementById("password").innerHTML="Password must be strong ";
				document.getElementById("password").style.color="Red";
				flag=false;
			}

			return flag;
			}

	$('#manage-user').submit(function(e){
		e.preventDefault();
		if(validation()){
        start_load()
		$.ajax({
			url:'ajax.php?action=save_user',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_load()
				}else{
                    alert_toast("Data successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)
                }
			}
		})
	}
	})

</script>