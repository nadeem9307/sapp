<?php 
include_once 'header.php';
include_once 'thankyoupage.inc.php';
?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
    	<div class="container">
			<div class="row">
	            <div class="col-md-12">
	                <div class="panel panel-default">
	                    <div class="panel-heading">
	                        Thank You Page
	                    </div>
	                    <div class="panel-body">
	                        <form name="thankyou_msg" method="post" id="thankyou_msg" enctype="multipart/form-data">
	                            <div class="form-group">
	                                <label for="exampleInputPassword1">Thank You Message:</label>
	                            </div>
	                            <div class="form-group">
                                        <textarea cols="40" rows="4" name="msg_description" id="msg_description" placeholder="Write description here .." style="font-size: 35px;margin: 0px;width: 1100px;height: 120px;font-family: cursive;"><?php if(isset($data['description'])){echo $data['description'];} ?></textarea>
	                            </div>
	                            <?php if(isset($data['img_url'])){
	                            	echo "Thank You Image Preview<br/><img src='".url()."/dev/uploads/".$data['img_url']."' height='100%' width='100%'>";
	                            } ?>
	                            
	                            <?php if(isset($data['img_url'])){
	                            	echo '<div class="form-group">
		                                <a href="javascript:void(0);" id="show_upload_optn">Change Image</a>
		                                <div class="upload-image hide">
		                                <input type="file" name="fileToUpload" id="fileToUpload" value="'.$data['img_url'].'">
		                                <p class="help-block">Example Image size ( 200px X 300px )</p>
		                                </div>
	                            	</div>';
								}else{
		                            echo '<div class="form-group">
		                                <label for="img">Thank You Image</label>
		                                <input type="file" name="fileToUpload" id="fileToUpload">
		                                <p class="help-block">Example Image size ( 150px X 150px )</p>
		                            </div>';
								}?>
	                            
	                            <input type="text" name="action" value="thankyou_msg" hidden="true">
	                            <?php 
					            if(isset($data['id'])){
					            	echo '<input type="button" name="add_thankyou_msg" id="update" class="btn btn-primary add_thankyou_msg" value="Update">';
								}else{
									echo '<input type="button" name="add_thankyou_msg" class="btn btn-primary add_thankyou_msg" value="Add">';
								}
								?>
	                        </form>
                                
                                <div class="loader" hidden="true"><img src="<?php echo  url();?>/dev/assets/img/win.gif" alt="loading..." width="100px" height="100px"/></div>
	                        <div class="msg_dish_error"></div>
	                    </div>
	                </div>
	            </div>
		</div>
	</div>
	
	
<!-- FOOTER SECTION START -->
<?php include 'footer.php';?> 

<script>
	$('#show_upload_optn').click(function(){
		$('#fileToUpload').click();
	});
</script>


