<?php 
if(!empty($msg))
{
      echo $msg;
}

if(!empty(validation_errors()))
{
    echo validation_errors();
}
?>
<ul class="nav nav-pills nav-justified">
	<li class="active"><a href="#general" data-toggle="tab">General info</a></li>
	<li><a href="#contact" data-toggle="tab">Contact info</a></li>
	<li><a href="#contract" data-toggle="tab">Contract</a></li>
	<li><a href="#warehouse" data-toggle="tab">Warehouse</a></li>
	<li><a href="#category" data-toggle="tab">Category</a></li>
	<li><a href="#login" data-toggle="tab">Login</a></li>
</ul>
<div class="tab-content" id="info-tab-content">
	<div class="tab-pane active" id="general">
		<ul class="list-group">
			<li class="list-group-item"><b>Company</b>: <?php echo $info['sup_name'] ?></li>
			<li class="list-group-item"><b>Phone</b>: <?php echo $info['sup_telephone'] ?></li>
			<li class="list-group-item"><b>Joining date</b>: <?php echo $info['sup_joindate'] ?></li>
			<li class="list-group-item"><b>Bank</b>: <?php echo $info['sup_bank'] ?></li>
			<li class="list-group-item"><b>Branch</b>: <?php echo $info['sup_bank_branch'] ?></li>
			<li class="list-group-item"><b>Account</b>: <?php echo $info['sup_bank_accountname'] ?></li>
			<li class="list-group-item"><b>Acount number</b>: <?php echo $info['sup_bank_accountnum'] ?></li>
			<li class="list-group-item"><b>B2C agent</b>: #</li>
		</ul>
	</div>
	<div class="tab-pane" id="contact">
		<ul class="list-group">
			<li class="list-group-item"><b>Name</b>: <?php echo $info['sup_contact_name'] ?></li>
			<li class="list-group-item"><b>Title</b>: <?php echo $info['sup_contact_title'] ?></li>
			<li class="list-group-item"><b>Phone</b>: <?php echo $info['sup_contact_cellphone'] ?></li>
			<li class="list-group-item"><b>Email</b>: <?php echo $info['sup_contact_email'] ?></li>
		</ul>
	</div>
	<div class="tab-pane" id="contract">
		<ul class="list-group">
			<li class="list-group-item"><b>Contract type</b>: <?php echo $info['sup_contracttype_name'] ?></li>
			<li class="list-group-item"><b>Sign date</b>: <?php echo $info['sup_contract_signdate'] ?></li>
			<li class="list-group-item"><b>End date</b>: <?php echo $info['sup_contract_enddate'] ?></li>
			<li class="list-group-item"><b>Amount</b>: <?php echo $info['sup_contract_percentage'] ?></li>
		</ul>
	</div>
	<div class="tab-pane" id="warehouse">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Street</th>
					<th>District</th>
					<th>City</th>
					<th>Country</th>
					<th>Contact</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Default</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($info['warehouses'] as $key => $warehouse): ?>
					<tr>
						<td><?php echo $warehouse['sup_warehouse_name'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_street'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_district'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_city'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_country'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_contactperson'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_contactphone'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_contactmail'] ?></td>
						<td><?php echo $warehouse['sup_warehouse_default'] ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="tab-pane" id="category">
		category
	</div>
	<div class="tab-pane" id="login">
		<ul class="list-group">
			<li class="list-group-item"><b>Email</b>: <?php echo $info['sup_contact_email'] ?></li>
			<li class="list-group-item"><a href="javascript(0);" data-toggle="modal" data-target="#myModal">Change password</a></li>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			    <form action="<?php echo base_url() . 'information' ?>" method="POST"/>
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Change password</h4>
			      </div>
			      <div class="modal-body">
				    <div class="form-group">
						<label class="control-label" for="old-password">Current password: </label>
			        	<input class="form-control" type="password" name="old_password" id="old-password"/>
			        </div>
			        <div class="form-group">
						<label class="control-label" for="new-password">New password: </label>
			        	<input class="form-control" type="password" name="new_password" id="new-password"/>
			        </div>
			        <div class="form-group">
						<label class="control-label" for="renew-password">Confirm new password: </label>
			        	<input class="form-control" type="password" name="renew_password" id="renew-password"/>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <input type="submit" name="change" value="Change" class="btn btn-primary"/>
			      </div>
			     </form>
			    </div>
			  </div>
			</div>
		</ul>
	</div>
</div>
