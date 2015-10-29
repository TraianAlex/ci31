<div class="magazine">
    <div class="name_issue">
        <?=html_escape($publication->publication_name); ?>
        #<?=html_escape($issue->issue_number); ?>
    </div>
    <div class="date">
        <?=html_escape($issue->issue_date_publication); ?>
    </div>
    <?php if ($issue->issue_cover):?>
    	<div class="cover">
    		<?=img('upload/'.$issue->issue_cover)?>
    	</div>
    <?php endif;?>
</div>