<?php
    $custom = get_post_custom( $this->post->ID );
?>

<h1>管理者宛メール</h1>

<table class="form-table">
    <tr>
        <th>送信先</th>
        <td>
            <textarea name="meta[notification_to]" class="regular-text" rows="5"><?php echo esc_attr( ( isset( $custom['notification_to'][0] ) ? $custom['notification_to'][0] : "" ) ); ?></textarea>
            <p>改行区切り</p>
        </td>
    </tr>
    <tr>
        <th>件名</th>
        <td>
            <input name="meta[notification_subject]" class="regular-text" value="<?php echo esc_attr( ( isset( $custom['notification_subject'][0] ) ? $custom['notification_subject'][0] : "" ) ); ?>">
        </td>
    </tr>
</table>

<h1>ユーザ宛メール</h1>

<table class="form-table">
    <tr>
        <th>送信元アドレス</th>
        <td>
            <input name="meta[thanks_from]" class="regular-text" value="<?php echo esc_attr( ( isset( $custom['thanks_from'][0] ) ? $custom['thanks_from'][0] : "" ) ); ?>">
        </td>
    </tr>
    <tr>
        <th>差出人名</th>
        <td>
            <input name="meta[thanks_fromname]" class="regular-text" value="<?php echo esc_attr( ( isset( $custom['thanks_fromname'][0] ) ? $custom['thanks_fromname'][0] : "" ) ); ?>">
        </td>
    </tr>
    <tr>
        <th>件名</th>
        <td>
            <input name="meta[thanks_subject]" class="regular-text" value="<?php echo esc_attr( ( isset( $custom['thanks_subject'][0] ) ? $custom['thanks_subject'][0] : "" ) ); ?>">
        </td>
    </tr>
    <tr>
        <th>本文</th>
        <td>
            <textarea name="meta[thanks_body]" class="regular-text" rows="10"><?php echo esc_attr( ( isset( $custom['thanks_body'][0] ) ? $custom['thanks_body'][0] : "" ) ); ?></textarea>
            <p>##content## で内容表示</p>
        </td>
    </tr>
</table>




