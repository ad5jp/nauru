<input type="hidden" name="edit_maker_metadata[]" value="info">

<table class="form-table">
<tr>
    <th>メーカー名カナ</th>
    <td><input type="text" class="large-text" name="meta[post_title_kana]" required value="<?php echo get_post_meta( $this->post->ID, 'post_title_kana', true ) ?>" pattern="^[ァ-ンヴー・]+$" title="全角カタカナで入力"></td>
</tr>
</table>


