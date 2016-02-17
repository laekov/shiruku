<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>
		</div>
		<div id='bottomspace'></div>
		<div class='pagefootwrapper'>
			<div class='maindiv'>
				<div class='div50 divleft'>
					<p>Powered&nbsp;by&nbsp;
						<a href='https://github.com/laekov/shiruku'>Shiruku <?php echo(srkVersion); ?></a>
					</p>
					<p><a href='/view/bugreport'>Report a bug</a></p>
					<p><a href='/admin'>Site administration entrance</a></p>
				</div>
				<div class='divright alignright'>
					<p> All&nbsp;rights&nbsp;reserved&nbsp;
						<?php if (isset($srkContent->ownerInfo->owner)) { ?>
							by&nbsp;<?php echo($srkContent->ownerInfo->owner); ?>
						<?php } ?>
					</p>
					<p>
						<?php if (isset($srkContent->ownerInfo->age)) { ?>
							&copy; <?php echo($srkContent->ownerInfo->age); ?>
						<?php } ?>
					</p>
					<?php if (isset($srkContent->ownerInfo->email)) { ?>
					<p> Contact&nbsp;site&nbsp;owner&nbsp;at&nbsp;
						<a href='mailto:<?php echo($srkContent->ownerInfo->email); ?>'>
							<?php echo($srkContent->ownerInfo->email); ?>
						</a>
					</p>
					<?php } ?>
				</div>
				<div class='divclear'></div>
			</div>
			<?php if (isset($srkContent->PRCRecordInfo)) { ?>
			<div class='recorddiv'>
				<a href='<?php echo($srkContent->PRCRecordInfo->href); ?>' class='prcrecordhref'>
					<?php echo($srkContent->PRCRecordInfo->text); ?>
				</a>
			</div>
			<?php } ?>
		</div>
	</body>
</html>
	
