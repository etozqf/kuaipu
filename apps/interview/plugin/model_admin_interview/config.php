<?php
return array(
    'guest'=>array('after_add', 'after_edit', 'after_get', 'after_delete'),
    'question'=>array('after_get'),
    'qrcode'=>array('html_write', 'after_add', 'after_edit', 'after_publish', 'after_unpublish', 'after_restore', 'after_pass', 'after_remove', 'before_delete', 'before_move', 'after_move', 'state', 'review', 'notice', 'picture'),
    'html'=>array('html_write', 'after_add', 'after_edit', 'after_publish', 'after_unpublish', 'after_restore', 'after_pass', 'after_remove', 'before_delete', 'before_move', 'after_move', 'state', 'review', 'notice', 'picture'),
    'search'=>array('after_add', 'after_edit', 'after_publish', 'after_unpublish', 'after_restore', 'after_pass', 'after_remove', 'after_delete', 'state', 'review', 'notice', 'picture'),
    'reference'=>array('after_edit', 'after_publish', 'after_unpublish', 'after_restore', 'after_pass', 'after_remove', 'after_move'),
    'content_version'=>array('after_edit'),
);