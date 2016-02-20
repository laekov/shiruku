<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<p id='samplepenlink'>
	<a id='href'></a>
</p>

<div class='homewrapper'>
	<div class='divright divhomer' id='homecontent'>
		<?php foreach ($srkContent->category as $cate=>$data) { ?>
			<div class='penwrapper'>
				<div class='pentitlediv'>
					<div class='divleft'>
						<?php echo($data->title); ?>
					</div>
					<div class='divright'>
						<a href='/list/catalog/<?php echo($cate); ?>'>More</a>
					</div>
					<div class='divclear'>
					</div>
				</div>
				<div class='homecatacontent' id='list_<?php echo($cate); ?>'>
					<p id='loading'>Loading</p>
				</div>
			</div>
		<?php } ?>
	</div>
	
	<div class='divleft divhomel' id='homewidgets'>
		<div class='divsimple penwrapper' id='commentrecent'>
			<div class='pentitlediv'>
				Recent comments
			</div>
			<div class='divsimple' id='recentcommentdiv'></div>
		</div>
		<div class='divsimple penwrapper' id='visitcount'>
			<div class='pentitlediv'>
				Visit count
			</div>
			<div class='simplediv'>
				<?php echo($renderArgs['visitCount']); ?>
			</div>
		</div>
		<div class='divsimple penwrapper' id='friends'>
			<div class='pentitlediv'>
				Friends' blogs
			</div>
			<ul>
		<?php if (isset($srkContent->friendLink)) { 
				foreach ($srkContent->friendLink as $friendHref) { ?>
					<li>
						<a href='<?php echo($friendHref->href); ?>'>
							<?php echo($friendHref->text); ?>
						</a>
					</li>
		<?php	}
			} 
		?>
			</ul>
		</div>
	</div>
	
	<div class="divclear"></div>
</div>
	
