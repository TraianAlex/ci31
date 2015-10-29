<?=validation_errors(); ?>
<?=$this->upload->display_errors('<div class="alert alert-error">', '</div>'); ?>
<?=form_open_multipart(); ?>
    <div>
        <?=form_label('Publication Name', 'publication_id'); ?>
        <?=form_dropdown('publication_id', $publication_form_options, set_value('publication_id')); ?>
    </div>
    <div>
        <?=form_label('Issue Number', 'issue_number'); ?>
        <?=form_input('issue_number', set_value('issue_number')); ?>
    </div>
    <div>
        <?=form_label('Date Published', 'issue_date_publication'); ?>
        <?=form_input('issue_date_publication', set_value('issue_date_publication')); ?>
    </div>
    <div>
        <?=form_label('Cover scan', 'issue_cover'); ?>
        <?=form_upload('issue_cover'); ?>
    </div>
    <div>
        <?=form_submit('save', 'Save'); ?>
    </div>
<?=form_close(); ?>