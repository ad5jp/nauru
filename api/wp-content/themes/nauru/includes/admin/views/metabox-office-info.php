<input type="hidden" name="edit_office_metadata[]" value="info">

<table class="form-table">
<tr>
    <th>住所</th>
    <td><input type="text" class="large-text" name="meta[address]" value="<?php echo get_post_meta( $this->post->ID, 'address', true ) ?>"></td>
</tr>
<tr>
    <th>TEL</th>
    <td><input type="text" class="regular-text" name="meta[tel]" value="<?php echo get_post_meta( $this->post->ID, 'tel', true ) ?>"></td>
</tr>
<tr>
    <th>FAX</th>
    <td><input type="text" class="regular-text" name="meta[fax]" value="<?php echo get_post_meta( $this->post->ID, 'fax', true ) ?>"></td>
</tr>
<tr>
    <th>Google Map</th>
    <td><input type="text" class="large-text" name="meta[map]" value="<?php echo get_post_meta( $this->post->ID, 'map', true ) ?>"></td>
</tr>
<tr>
    <th>外観写真</th>
    <td>
        <?php
            $image_id = get_post_meta( $this->post->ID, 'photo_appearance', true );
        ?>
        <p class="agx-media-placeholder">
			<?php if ( $image_id ): ?>
			<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
			<?php endif; ?>
		</p>
		<input type="hidden" name="meta[photo_appearance]" class="agx-media-input" value="<?php echo $image_id; ?>">
		<input type="button" class="agx-media-select" value="選択" />
		<input type="button" class="agx-media-clear" value="クリア" />
    </td>
</tr>
<tr>
    <th>スタッフ写真</th>
    <td>
        <?php
            $image_id = get_post_meta( $this->post->ID, 'photo_staff', true );
        ?>
        <p class="agx-media-placeholder">
			<?php if ( $image_id ): ?>
			<?php echo wp_get_attachment_image( $image_id, 'medium' ); ?>
			<?php endif; ?>
		</p>
		<input type="hidden" name="meta[photo_staff]" class="agx-media-input" value="<?php echo $image_id; ?>">
		<input type="button" class="agx-media-select" value="選択" />
		<input type="button" class="agx-media-clear" value="クリア" />
    </td>
</tr>
<tr>
    <th>メッセージ</th>
    <td>
        <p><input type="text" class="large-text" name="meta[message_title]" value="<?php echo get_post_meta( $this->post->ID, 'message_title', true ) ?>"></p>
        <p><textarea class="large-text" name="meta[message_description]" rows="5"><?php echo get_post_meta( $this->post->ID, 'message_description', true ) ?></textarea></p>
    </td>
</tr>
</table>

<script>
(function ($) {
	//メディアアップローダー
	var custom_uploader;
	$(document).on("click", ".agx-media-select", function(e) {
		var media_select = $(this);

		custom_uploader = wp.media({
			title: "写真を選択",
			library: {
				type: "image"
			},
			button: {
				text: "写真を選択"
			},
			multiple: false
		});
		
		custom_uploader.on("select", function() {
			var images = custom_uploader.state().get("selection");
			images.each(function(file){
				media_select.siblings('.agx-media-input').val(file.id);
				var url = "";
				if (file.attributes.sizes.medium) {
					url = file.attributes.sizes.medium.url;
				} else {
					url = file.attributes.sizes.full.url;
				}
				media_select.siblings('.agx-media-placeholder').html('<img src="'+url+'" />');
			});
		});

		custom_uploader.open();
	});

	$("input.agx-media-clear").click(function() {
		$(this).siblings('.agx-media-input').val("");
		$(this).siblings('.agx-media-placeholder').empty();
	});

})(jQuery);
</script>
