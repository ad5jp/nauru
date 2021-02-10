<table class="form-table">
<tr>
    <th>引用元URL</th>
    <td><input type="text" class="large-text" name="meta_source_url" value="<?php echo get_post_meta( $post->ID, 'source_url', true ) ?>"></td>
</tr>
<tr>
    <th>引用元名称</th>
    <td><input type="text" class="large-text" name="meta_source_name" value="<?php echo get_post_meta( $post->ID, 'source_name', true ) ?>"></td>
</tr>
</table>
