<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
?>

<div class='hidden'>
	<a id='samplepenlink' class='list-group-item'></a>
</div>

<div class='container-fluid'>
    <div class='row'>
	    <div class='col-12'>
<?php 
if (!isset($_SESSION['userId'])) {
	$home_ctnt = getFileContent($srkEnv->penPath.'/homepage/content.md');
	if ($home_ctnt != -1) {
		echo($home_ctnt);
	}
}
?>
		</div>
	</div>
	<div class='row'>
	    <div class='col-md-8 col-sm-12' id='homecontent'>
			<?php foreach ($srkContent->category as $cate=>$data) { ?>
				<div class='list-group' id='list_<?php echo($cate); ?>'>
					<a class='list-group-item list-group-item-info' href='/list/catalog/<?php echo($cate); ?>'>
						<?php echo($data->title); ?>
					</a>
					<p id='loading'>Loading</p>
				</div>
			<?php } ?>
	    </div>
	    
	    <div class='col-md-4 col-sm-12' id='homewidgets'>
		    <div class='panel panel-default' id='commentrecent'>
			    <div class='panel-heading'>
				    Recent comments
			    </div>
			    <div class='panel-body' id='recentcommentdiv'></div>
		    </div>
		    <div class='panel panel-default' id='visitcount'>
			    <div class='panel-heading'>
				    Visit count
			    </div>
			    <div class='panel-body'>
				    <?php echo($renderArgs['visitCount']); ?>
			    </div>
		    </div>
		    <div class='panel panel-default' id='friends'>
			    <div class='panel-heading'>
				    Friends' blogs
			    </div>
                <div class='panel-body'>
			        <ul>
		        <?php if (isset($srkContent->friendLink)) { 
				        foreach ($srkContent->friendLink as $friendHref) { ?>
					        <li>
						        <a href='<?php echo($friendHref->href); ?>'>
							    <?php echo($friendHref->text); ?>
						        </a>
					        </li>
		        <?php	}
			          } ?>
			        </ul>
                </div>
            </div>
		</div>
    </div>
	</div>
	
	<div class="divclear"></div>
</div>
	
