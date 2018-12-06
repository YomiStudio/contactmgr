<!doctype html>
<?php 
    require_once 'app/connection.php';
    $db_con = new connection();
    if(!isset($_SESSION['user_id'])){
    	header("Location:login.php");
    }
?>
<html lang="en">
  <head>
    <title>Welcome: Contact Manager</title>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/b5bdd619d8.css"> 
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
        	<?php 
            		if($_SESSION['role'] == 1){
            			echo '<p class="p-3 mb-2 bg-secondary text-white"><a href="user.php">User Manager</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout.php">Logout</a></p>';
            		}
            		if($_SESSION['role'] == 2){
            			echo '<p class="p-3 mb-2 bg-secondary text-white"><button type="button" id="create-data" class="btn btn-primary" data-toggle="modal" data-target="#ChangePassword">Change Password </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout.php">Logout</a></p>';
            		}
            	?>
        <div class="panel panel-default">
		<div class="panel-heading">
        <div class="row">
            <div class="col-sm-9">
                <input type="text" placeholder="Search" id="search" name="search" class="form-control" >
            </div>
            <div class="col-sm-3">
                <div class="text-right">
<button type="button" id="create-data" class="btn btn-primary" data-toggle="modal" data-target="#AddModal"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Add </button></div>
            </div>
		</div>
		</div>
		<div id="contact-list" class="panel-body">
          <table cellspacing="0" width="100%" class="table table-hover">
          <tbody>
        <?php
        $stmt = $db_con->db->prepare("SELECT * FROM contact ORDER BY fullname ASC");
        $stmt->execute();
        if($stmt->rowCount() > 0){
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{ ?>
        <tr id="<?php echo $row['id']; ?>" class="view-link" title="View">
			<td>
				<?php echo $row['fullname'] . " ( " . $row['mobile']. " )"; ?> 
			</td>
			<td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
            </tr>
        <?php }}else echo "<tr><td>List is empty</td></tr>" ?>
    </tbody>
          </table>
          </div>
    </div>
    </div>
    <div class="col-sm-4"></div>
</div>
    <div class="row">
          <div class="col-sm-4"></div>
          <footer class="col-sm-4">
              <p class="text-center">&copy;2018 Contact Manager| All Rights Reserved  </p>
          </footer>
          <div class="col-sm-4"></div>
    </div>
    </div>
    <button type="button" id="view-data" class="none" data-toggle="modal" data-target="#ViewModal">View </button>
    <!-- Page Modals-->
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalLabel" aria-hidden="true">
  <div class="modal-dialog .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddModalLabel">New Contact</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="btn btn-danger" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
        </button>
      </div>
      <form id="formBox" action="" method="post">
      <div class="modal-body">
      	<div id="report"></div>
        <input type="hidden" name="type" value="addContact">
		<div class="form-group">
			<input type="text" placeholder="Fullname" id="fullname" name="fullname" class="form-control" required>
		</div>
		<div class="form-group">
			<input type="text" placeholder="Mobile" id="mobile" name="mobile" class="form-control" required>
		</div>
		<div class="form-group">
			<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseMore" aria-expanded="false" aria-controls="collapseMore">
    More Fields
  </button>
		</div>		
		<div class="collapse" id="collapseMore">
			<div class="form-group">
				<input type="email" placeholder="Email" id="email" name="email" class="form-control" >
			</div>
			<div class="form-group">
				<input type="text" placeholder="Company" id="company" name="company" class="form-control" >
			</div>
			<div class="form-group">
				<input type="text" placeholder="Street" id="street" name="street" class="form-control" >
			</div>
			<div class="form-group">
				<input type="text" placeholder="City" id="city" name="city" class="form-control" >
			</div>
			<div class="form-group">
				<input type="text" placeholder="State" id="state" name="state" class="form-control" >
			</div>
			<div class="form-group">
				<label for="birthday">Birthday: </label>
				<input type="date" placeholder="Birthday" id="birthday" name="birthday" class="form-control" >
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;Cancel</button>
        <button id="submit" type="button" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Save</button>
      </div>
  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="ViewModal" tabindex="-1" role="dialog" aria-labelledby="ViewModalLabel" aria-hidden="true">
  <div class="modal-dialog .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ViewModalLabel">Contact&nbsp;&nbsp;</h5>
        <button id="edit-link" type="button" class="btn btn-info"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button id="delete-link" type="button" class="btn btn-danger"><i class="fa fa-times fa-fw" aria-hidden="true"></i></button>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="btn btn-danger" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
        </button>
      </div>
      <form id="formUpload" action="" method="post">
      <div class="modal-body">
      	<div id="v-report"></div>
        <input type="hidden" name="type" value="updateContact">
		<div class="form-group">
			<input type="text" placeholder="Fullname" id="u_fullname" name="fullname" class="form-control" required>
		</div>
		<div class="form-group">
			<input type="text" placeholder="Mobile" id="u_mobile" name="mobile" class="form-control" required>
		</div>
		<div class="form-group">
			<input type="email" placeholder="Email"  id="u_email" name="email" class="form-control" >
		</div>
		<div class="form-group">
			<input type="text" placeholder="Company" id="u_company" name="company" class="form-control" >
		</div>
		<div class="form-group">
			<input type="text" placeholder="Street"  id="u_street" name="street" class="form-control" >
		</div>
		<div class="form-group">
			<input type="text" placeholder="City"  id="u_city" name="city" class="form-control" >
		</div>
		<div class="form-group">
			<input type="text" placeholder="State"   id="u_state" name="state" class="form-control" >
		</div>
		<div class="form-group">
			<label for="u_birthday">Birthday: </label>
			<input type="date" id="u_birthday" name="birthday" class="form-control" >
		</div>
		</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;Cancel</button>
        <button id="update" type="button" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Update</button>
      </div>
  </form>
    </div>
  </div>
</div>
<div class="modal fade" id="ChangePasswordModal" tabindex="-1" role="dialog" aria-labelledby="ChangePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog .modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ChangePasswordModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="btn btn-danger" aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
        </button>
      </div>
      <form id="formPass" action="" method="post">
      <div class="modal-body">
      	<div id="p-report"></div>
        <input type="hidden" name="type" value="changePass">
		<div class="form-group">
			<input type="password" placeholder="Current Password" id="password" name="password" class="form-control" required>
		</div>
		<div class="form-group">
			<input type="password" placeholder="New Password" id="upassword" name="upassword" class="form-control" required>
		</div>
		<div class="form-group">
			<input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" class="form-control" required>
		</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;Cancel</button>
        <button id="submit-pass" type="button" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;Change Password</button>
      </div>
  </form>
    </div>
  </div>
</div>
    <!-- Page Modals-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>-->
    <!-- <script src="bootstrap/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">

jQuery(document).ready( function($) {
	//scroll to div
	function scrollToById(id) {
		var etop = $('#' + id).offset().top;
		$('html, body').animate({
		  scrollTop: etop
		}, 1000);
	}

	function lockFields(){
		$('#u_fullname').prop('readonly', false);
		$('#u_mobile').prop('readonly', false);
		$('#u_email').prop('readonly', false);
		$('#u_company').prop('readonly', false);
		$('#u_street').prop('readonly', false);
		$('#u_city').prop('readonly', false);
		$('#u_state').prop('readonly', false);
		$('#u_birthday').prop('readonly', false);
	}

	function updateContactList(){
		var type="reloadContact",
		    url = "src/routes.php";
		$.post('src/routes.php', {'type':type}, function(data)
		{
			//console.log(data);
			$('#contact-list').empty().html(data);
		});

	}

	$('#AddModal').on('hidden.bs.modal', function () {
  		updateContactList();
	});

	$('#ViewModal').on('hidden.bs.modal', function () {
  		updateContactList();
	});

	$('#search').keyup(function(e){
		var search = $(this).val();
		//console.log(search);
		var type="searchContact",
		    url = "src/routes.php";
		$.post('src/routes.php', {'type':type,'key':search}, function(data)
		{
			console.log(data);
			$('#contact-list').empty().html(data);
		});
	});

	$('#create-data').click(function(){
		$('#report').empty();
	});

	$('#submit-pass').click(function(e){
		e.preventDefault();
		$(this).prop("disabled", true);
		$('#p-report').empty();

		var formdata = $('#formPass').serializeArray(),
		url = "src/routes.php";
	
		//perform AJAX request
		var posting =$.post(url,formdata);

		//posting was successfull
		posting.done(function(rdata){
			//console.log(rdata);		
			$('#p-report').empty().html(rdata).fadeIn(1000);
			scrollToById('p-report');		
			$('#formPass').trigger('reset')
		})
		$('#submit-pass').prop("disabled", false);
	});

   $("#submit").click(function(e){
		e.preventDefault();
		$('#submit').prop("disabled", true);
		$('#report').empty();

		var formdata = $('#formBox').serializeArray(),
		url = "src/routes.php";
	
	
		//perform AJAX request
		var posting =$.post(url,formdata);

		//posting was successfull
		posting.done(function(rdata){
			//console.log(rdata);		
			$('#report').empty().html(rdata);
			$('#report').fadeIn(1000);
			scrollToById('v-report');		
			$('#formBox').trigger('reset');

		});

		posting.fail(function(data){
	      	$('#report').empty().html('<p class="alert alert-danger" role="alert"><i class="fa fa-times-circle fa-fw"></i>Wrong URL specified, invalid index, some internal errors occurred</p>');
		});
		$('#submit').prop("disabled", false);
 });

  	/* Display Data for Update */
  	var record_id;
  	//$('.view-link').click(function() {
  	$('body').on('click','tr.view-link', function(){
  		$('#v-report').empty();
  		record_id = $(this).attr("id");
		var type = "view";
		//console.log(record_id + " : " + type );
		$.post('src/routes.php', {'id':record_id,'type':type}, function(data)
		{
			//console.log(data);
			data = JSON.parse(data);
			//console.log(data.fullname);
			$('#u_fullname').val(data.fullname).prop('readonly', true);			
			$('#u_mobile').val(data.mobile).prop('readonly', true);
			$('#u_email').val(data.email).prop('readonly', true);
			$('#u_company').val(data.company).prop('readonly', true);
			$('#u_street').val(data.street).prop('readonly', true);
			$('#u_city').val(data.city).prop('readonly', true);
			$('#u_state').val(data.state).prop('readonly', true);
			$('#u_birthday').val(data.birthday).prop('readonly', true);
			$('#update').hide();
			$('#view-data').trigger("click");
		});	
  	});

  	/* Enable the Text fields for editing */
  	$('#edit-link').click(function(e)
  	{
  		if(record_id != 0){
  			e.preventDefault();
	  		lockFields();
			$('#update').show();
  		}
  		else{
  			var rawhtml = '<div class="alert alert-warning alert-dismissible fade show" role="alert"><i class="fa fa-times-circle  fa-fw"></i>&nbsp;<strong>Error!</strong> Operation cannot be performed. Record does not exit. <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button></div>';
  				$('#v-report').empty().html(rawhtml);
				$('#v-report').fadeIn(1000);
				scrollToById('v-report');
  		}
  		
  	});
  	/* Update Data with fields*/
  	$('#update').click(function () {  			
		var type ="updateContact", data = $('#formUpload').serializeArray();
		data[0].value = type;
		data.push({"name":"id","value":record_id});
		
		//console.log(data);
		$.post('src/routes.php', data, function(data)
		{
			console.log(data);
			$('#v-report').empty().html(data);
			$('#v-report').fadeIn(1000);
			scrollToById('v-report');
			lockFields();
			$('#update').hide();
		});		
  	});
	/* Data Delete Starts Here */
	$('#delete-link').click(function(e)
	{
		e.preventDefault();
		$('#v-report').empty();
		//var del_id = $(this).attr("id");
		var del_id = record_id;
		var type = "deleteContact";
		if(record_id == 0){
			return false;
		}
		//console.log(del_id + " : " + type );
		if(confirm('Are you sure you want to delete = ?'))
		{
			$.post('src/routes.php', {'id':del_id,'type':type}, function(data)
			{
				//console.log(data);
				$('#v-report').empty().html(data);
  				$('#v-report').fadeIn(1000);
  				scrollToById('v-report');
  				$('#formUpload').trigger('reset');
  				record_id = 0;
			});	
		}
		return false;
	});
	/* Data Delete Ends Here */
});
</script>    
    </body>
  </html>