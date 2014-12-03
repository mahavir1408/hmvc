<script type="text/javascript">
$(function() {        
	$("#blog_content").htmlarea(); // Initialize jHtmlArea's with all default values
});
</script>
<div id="content">				
	<div id="contentHeader">
		<h1>Blog</h1>
	</div> <!-- #contentHeader -->		
	<div class="container">
		<!--TAB VIEW-->
		
		<div class="grid-16">
			<?php echo set_breadcrumb(); ?>
			<div class="clear">&nbsp;</div>			
			<form class="form uniformForm" name="blogfrm" action="" method="post">
				<div class="widget">
					<div class="widget-header">
						<span class="icon-article"></span>
						<h3>Add</h3>
					</div> <!-- .widget-header -->						
					<div class="widget-content">					
						<?php if($is_dir){ ?>
						<div class="field-group">
							<label for="myfile">Directory Name:</label>
							<div class="field">
								<input type="text" name="dir_name" value="" />									
							</div>
						</div>
						<?php } ?>
						<div class="field-group">
							<label for="myfile">H1 tag:</label>
							<div class="field">
								<input type="text" name="h1_tag" value="" />									
							</div>
						</div>
						<div class="field-group">	
							<label for="myfile">URL:</label>			
							<div class="field">
								<input type="text" name="slug" value="" />
							</div>
						</div>
						<div class="field-group">										
							<div class="field">
								<input type="submit" name="save" value="Save" />
							</div>							
						</div>
					</div> <!-- .widget-content -->						
				</div> <!-- .widget -->					
			</form>
		</div>			
	</div> <!-- .container -->		
</div> <!-- #content -->