<?php use_helper('opDiary', 'Text') ?>

<?php decorate_with('layoutB') ?>
<?php slot('op_sidemenu', get_component('diary', 'sidemenu', array('member' => $member, 'year' => date('Y', strtotime($diary->created_at)), 'month' => date('n', strtotime($diary->created_at))))) ?>

<?php /* {{{ diaryDetailBox */ ?>
<div class="dparts diaryDetailBox"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Diary of %1%', array('%1%' => $member->name)) ?></h3>
<p class="public">(<?php echo $diary->getPublicFlagLabel() ?>)</p></div>

<?php if ($diary->getPrevious($myMemberId) || $diary->getNext($myMemberId)): ?>
<div class="block prevNextLinkLine">
<?php if ($diary->getPrevious($myMemberId)): ?>
<p class="prev"><?php echo link_to(__('Previous Diary'), 'diary_show', $diary->getPrevious($myMemberId)) ?></p>
<?php endif; ?>
<?php if ($diary->getNext($myMemberId)): ?>
<p class="next"><?php echo link_to(__('Next Diary'), 'diary_show', $diary->getNext($myMemberId)) ?></p>
<?php endif; ?>
</div>
<?php endif; ?>

<dl>
<dt><?php echo nl2br(op_format_date($diary->created_at, 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p class="heading"><?php echo $diary->title; ?></p>
</div>
<div class="body">
<?php if ($diary->has_images): ?>
<?php $images = $diary->getDiaryImagesJoinFile() ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->File) ?>" target="_blank"><?php echo image_tag_sf_image($image->File, array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php echo op_url_cmd(op_decoration(nl2br($diary->body))) ?>
</div>
<!--Like Plugin -->
<div class="like" style="display: none;">
<span class="like-wrapper" data-like-id="<?php echo $diary->getId() ?>" data-like-target="D" member-id="<?php echo $diary->member_id ?>">
<span class="like-post">いいね！</span>
<span class="like-cancel">いいね！を取り消す&nbsp;</span>
<span class="like-you">あなたが「いいね！」と言っています。</span><br />
<a class="like-list" href="#likeModal" data-toggle="modal"></a>
<div class="like-list-member"></div>
<span class="like-friend-list"></span>
</span>
</div>
</dd>
</dl>
<?php if ($diary->member_id === $myMemberId): ?>
<div class="operation">
<form action="<?php echo url_for('diary_edit', $diary) ?>">
<ul class="moreInfo button">
<li><input type="submit" class="input_submit" value="<?php echo __('Edit this diary') ?>" /></li>
</ul>
</form>
</div>
<?php endif; ?>
</div></div>
<?php /* }}} */ ?>

<?php include_component('diaryComment', 'list', array('diary' => $diary)) ?>

<?php if ($myMemberId): ?>
<?php
$form->getWidget('body')->setAttribute('rows', 8);
$form->getWidget('body')->setAttribute('cols', 40);

op_include_form('formDiaryComment', $form, array(
  'title' => __('Post a diary comment'),
  'url' => url_for('@diary_comment_create?id='.$diary->id),
  'button' => __('Save'),
  'isMultipart' => true,
  'body' => $diary->is_open ? __('Your comment is visible to all users on the Web.') : null,
));
?>
<?php endif; ?>

<?php op_include_line('lineLinkToDiaryMemberList', link_to(__('Diaries of %1%', array('%1%' => $member->name)), 'diary_list_member', $member)) ?>

<script id="LikelistTemplate" type="text/x-jquery-tmpl">
<table>
<tr style="padding: 2px;">
<td style="width: 48px; padding: 2px;"><a href="${profile_url}"><img src="${profile_image}" width="48"></a></td>
<td style="padding: 2px;"><a href="${profile_url}">${name}</a></td>
</tr>
</table>
</script>

<div id="likeModal" class="modal hide">
  <div class="modal-header">
    <h1>「いいね！」と言っている人</h1>
  </div>
  <div class="like-modal-body">
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close" data-dismiss="modal" aria-hidden="true">閉じる</a>
  </div>
</div>
