<div class="col-xs-12">
		<div class="box box-danger">
            <form role="form" enctype="multipart/form-data" method="POST" action="<?php echo site_url('webtools/admin/editprocess/'.$admin->id); ?>">
              	<div class="box-body">

              		<?php if($error=='error'): ?>
                  <div class="alert alert-warning alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <?php echo $error_msg; ?>
                  </div>
                  <?php elseif($error=='success'): ?>
                  <div class="alert alert-success alert-dismissible">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    <h4><i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $success_msg; ?>
                  </div>
                  <?php endif; ?>

                  <div class="form-group">
                    <label for="group">Group</label>
                    <select class="form-control" name="group">
                      <?php foreach ($group as $v): ?>
                      <option value="<?php echo $v->id ?>" <?php echo $admin->group==$v->id ? 'selected' :'' ?> ><?php echo $v->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username" value="<?php echo $admin->username ?>" readonly disabled>
                  </div>

                  <div class="form-group">
                    <label for="group">Active?</label>
                    <select class="form-control" name="active">
                      <option value="0" <?php echo $admin->is_active==0 ? 'selected':'' ?> >No</option>
                      <option value="1" <?php echo $admin->is_active==1 ? 'selected':'' ?> >Yes</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="username">Change Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password">
                  </div>

	              </div>
              	<div class="box-footer">
                	<button class="btn btn-danger" type="submit">Edit</button>
                  <a class="btn btn-default" onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo site_url('webtools/admin/delete/'.$admin->id); ?>">Delete</a>
              	</div>
            </form>
          </div>
</div>