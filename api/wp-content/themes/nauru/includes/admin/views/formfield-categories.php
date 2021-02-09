<?php
	$term = $this->term;
?>
<tr class="form-field">
	<th scope="row"><label for="term_group">並び順</label></th>
	<td>
        <input type="number" id="term_group" name="term_group" value="<?php echo ( $term ? $term->term_group : "" ); ?>">
        <p class="description">昇順に並びます</p>
    </td>
</tr>

<tr class="form-field">
	<th scope="row"><label for="meta_url">リンクURL</label></th>
	<td>
		<input type="text" id="meta_url" name="meta[url]" value="<?php echo ( $term ? get_term_meta( $term->term_id, 'url', true ) : "" ); ?>">
		<p>
			<input type="hidden" name="meta[url_blank]" value="0">
			<label><input type="checkbox" name="meta[url_blank]" value="1" <?php echo ( ( $term && get_term_meta( $term->term_id, 'url_blank', true ) ) ? "checked" : "" ); ?>> 外部リンク</label>
		</p>
        <p class="description">未入力の場合はメーカー一覧</p>
    </td>
</tr>

<tr class="form-field">
	<th scope="row"><label for="meta_thumbnail">画像</label></th>
	<td>
        <p class="agx-media-placeholder">
			<?php 
                $thumbnail_id = null;
                if ( $term && $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail', true ) ) {
                    echo wp_get_attachment_image( $thumbnail_id, 'medium' );
                }
            ?>
        </p>
        <input type="hidden" name="meta[thumbnail]" class="agx-media-input" value="<?php echo $thumbnail_id; ?>">
        <input type="button" class="agx-media-select" value="選択" />
        <input type="button" class="agx-media-clear" value="クリア" />
		<br><br>

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
						media_select.siblings('.agx-media-placeholder').html('<img src="'+file.attributes.sizes.medium.url+'" />');
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
    </td>
</tr>
