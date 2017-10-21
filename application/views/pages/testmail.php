<table class="table table-hover">
	<thead>
		<tr>
			<td>Template Name</td>
			<td>Template File</td>
			<td>Object ID</td>
			<td>Email Send</td>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<form method="post" action="<?php echo base_url().'new-order-admin'?>" name="form">
				<td>New Order Admin</td>
				<td>email/new_order_admin</td>
				<td><input type="" name=""></td>
				<td><input type="" name=""></td>
				<td><input type="submit" class="btn btn-success" id="action" name="action" value="Action"></td>
			</form>
		</tr>
		<tr>
			<form method="post" action="<?php echo base_url().'new-order-customer'?>" name="form">
				<td>New Order Customer</td>
				<td>email/new_order_customer</td>
				<td><input type="" name=""></td>
				<td><input type="" name=""></td>
				<td><input type="submit" class="btn btn-success" id="action" name="action" value="Action"></td>
			</form>
		</tr>
		<tr>
			<form method="post" action="<?php echo base_url().'create-new-customer'?>" name="form">
				<td>Create New Customer</td>
				<td>email/create_new_customer</td>
				<td><input type="" name=""></td>
				<td><input type="" name=""></td>
				<td><input type="submit" class="btn btn-success" id="action" name="action" value="Action"></td>
			</form>
		</tr>
		<tr>
			<form method="post" action="<?php echo base_url().'forgot-password-customer'?>" name="form">
				<td>Forgot Password Customer</td>
				<td>email/forgot_password_customer</td>
				<td><input type="" name=""></td>
				<td><input type="" name=""></td>
				<td><input type="submit" class="btn btn-success" id="action" name="action" value="Action"></td>
			</form>
		</tr>
		<tr>
			<form method="post" action="<?php echo base_url().'forgot-password-admin'?>" name="form">
				<td>Forgot Password Admin</td>
				<td>email/forgot_password_admin</td>
				<td><input type="" name=""></td>
				<td><input type="" name=""></td>
				<td><input type="submit" class="btn btn-success" id="action" name="action" value="Action"></td>
			</form>
		</tr>
	</tbody>
</table>