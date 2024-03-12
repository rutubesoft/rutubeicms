<?php // Шаблон одной записи на стене // ?>

<?php
    $count = 0;
    if (empty($max_entries)){ $max_entries = false; }
    if (empty($page)){ $page = false; }
?>

<?php foreach($entries as $entry){ ?>

<?php

    $count++;

    $is_can_add = !empty($permissions['reply']) && $entry['parent_id'] == 0;
    $is_can_edit = ($entry['user']['id']==$user->id) || $user->is_admin;
    $is_can_delete = ($entry['user']['id']==$user->id) || $permissions['delete'];

    if (empty($entry['replies_count'])){ $entry['replies_count'] = 0; }

    $is_hidden = ($max_entries && ($count > $max_entries) && ($page == 1));
    $author_url = href_to_profile($entry['user']);

?>

<div id="entry_<?php echo $entry['id']; ?>" class="entry media my-4"<?php if($is_hidden){ ?> style="display:none"<?php } ?> data-replies="<?php echo $entry['replies_count']; ?>">
    <div class="d-flex mr-3">
        <a href="<?php echo $author_url; ?>" class="icms-user-avatar small <?php if (!empty($entry['user']['is_online'])){ ?>peer_online<?php } else { ?>peer_no_online<?php } ?>">
            <?php if($entry['user']['avatar']){ ?>
                <?php echo html_avatar_image($entry['user']['avatar'], 'micro', $entry['user']['nickname']); ?>
            <?php } else { ?>
                <?php echo html_avatar_image_empty($entry['user']['nickname'], 'avatar__mini'); ?>
            <?php } ?>
        </a>
    </div>
    <div class="media-body">
        <h6 class="d-md-flex align-items-center mb-2">
            <a class="user" href="<?php echo $author_url; ?>"><?php echo $entry['user']['nickname']; ?></a>
            <small class="text-muted<?php if(!empty($entry['is_new'])){ ?> highlight_new<?php } ?> ml-2">
                <?php html_svg_icon('solid', 'history'); ?>
                <span>
                    <?php html(string_date_age_max($entry['date_pub'], true)); ?>
                </span>
                <?php if ($entry['date_last_modified']){ ?>
                    <span data-toggle="tooltip" data-placement="top" class="date_last_modified ml-2" title="<?php echo LANG_CONTENT_EDITED.' '.strip_tags(html_date_time($entry['date_last_modified'])); ?>">
                        <?php html_svg_icon('solid', 'pen'); ?>
                    </span>
                <?php } ?>
            </small>
            <a data-toggle="tooltip" data-placement="top" href="?wid=<?php echo $entry['id']; ?>" class="text-dark ml-2 mr-4" name="wall_<?php echo $entry['id']; ?>" title="<?php html(LANG_WALL_ENTRY_ANCHOR); ?>">#</a>
        </h6>
        <div class="icms-wall-html">
            <?php echo $entry['content_html']; ?>
        </div>
        <div class="links mt-2">
            <?php if ($is_can_add){ ?>
                <a href="#wall-reply" class="btn btn-outline-secondary btn-sm border-0 mr-1 reply" onclick="return icms.wall.add(<?php echo $entry['id']; ?>)">
                    <?php html_svg_icon('solid', 'reply'); ?>
                    <?php echo LANG_REPLY; ?>
                </a>
            <?php } ?>
            <?php if ($is_can_edit){ ?>
                <a href="#wall-edit" class="btn btn-outline-secondary btn-sm border-0 edit" onclick="return icms.wall.edit(<?php echo $entry['id']; ?>)" title="<?php echo LANG_EDIT; ?>">
                    <?php html_svg_icon('solid', 'edit'); ?>
                </a>
            <?php } ?>
            <?php if ($is_can_delete){ ?>
                <a href="#wall-delete" class="btn btn-outline-danger btn-sm border-0 delete" onclick="return icms.wall.remove(<?php echo $entry['id']; ?>)" title="<?php echo LANG_DELETE; ?>">
                    <?php html_svg_icon('solid', 'trash'); ?>
                </a>
            <?php } ?>
        </div>
        <?php if ($entry['replies_count']){ ?>
            <a href="#wall-replies" class="icms-wall-item__btn_replies btn btn-sm font-weight-bold" onclick="return icms.wall.replies(<?php echo $entry['id']; ?>)">
                <span><?php html_svg_icon('solid', 'level-down-alt'); ?></span>
                <span><?php echo html_spellcount($entry['replies_count'], LANG_REPLY_SPELLCOUNT); ?></span>
            </a>
        <?php } ?>
        <?php if (!$entry['parent_id']) { ?>
            <div class="replies"></div>
        <?php } ?>
    </div>
</div>

<?php if ($max_entries && ($count == $max_entries) && (count($entries) > $count) && ($page == 1)){ ?>
    <a class="show_more btn btn-primary btn-block" href="#wall-more" onclick="return icms.wall.more()">
        <?php echo LANG_SHOW_ALL; ?>
    </a>
<?php } ?>

<?php } ?>