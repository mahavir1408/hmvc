<style>
.folder:before {
    background-color: #E9CF5F;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 20px;
    content: "";
    height: 10px;
    left: 0;
    position: absolute;
    top: -3px;
    width: 63%;
}
.folder {
	background-color: #E9CF5F;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
    border-top-left-radius: 0;
    border-top-right-radius: 6px;
    box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
    height: 19px;
    margin-bottom: 0;
    margin-left: auto;
    margin-right: auto;
    margin-top: 50px;
    position: relative;
    width: 27px;
}
.fr {
float:right;
}
</style>
<?php $uri = (isset($uri)&&!empty($uri))?$uri."/":""; ?>
<div id="content">		
		<div id="contentHeader">
			<h1>Category</h1>
		</div> <!-- #contentHeader -->	
		
		<div class="container">
			<div class="grid-24">
			<?php echo set_breadcrumb(); ?>
			<div class="clear">&nbsp;</div>
			<a class="btn btn-primary" href="/admin/pages/<?php echo $uri.$parentid; ?>/add-directory"><span class="icon-folder-stroke"></span>Directory</a>			
			<a class="btn btn-primary" href="/admin/pages/<?php echo $uri.$parentid; ?>/add-page"><span class="icon-document-alt-stroke"></span>Page</a>
			<div class="clear">&nbsp;</div>
			<div class="widget widget-table">
						
						<div class="widget-header">
							<span class="icon-list"></span>
							<h3 class="icon chart">Pages</h3>		
						</div>
					
						<div class="widget-content">							
							<table class="table table-bordered table-striped">							
							<tbody>
								<?php foreach($pages AS $page) { ?>
								<tr class="odd gradeX">
									<td>
										<?php 
											if($page['page_type'] =='directory') {
												$pageType = $page['page_type'];
												echo "&raquo;&nbsp;<a href='/admin/pages".$page['uri']."'>".$page['head']."</a>";
											}else{
												$pageType = $page['page_type'];
												echo $page['head'];
											}
											
										?>
										<div class="fr">
										  <button type="button" class="btn btn-success btn-small">SEO</button>
										  <button type="button" class="btn btn-success btn-small">CONTENT</button>
										  <button type="button" class="btn btn-success btn-small">DELETE</button>
										</div>

									</td>																	
								</tr>								
								<?php } ?>
							</tbody>
							</table>							
						</div> <!-- .widget-content -->
						
				</div>				
				<?php 
					echo $pagination;
				?>
			</div> 
		</div> <!-- .container -->
		
	</div> <!-- #content -->