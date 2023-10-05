<?php
/**
 * Plugin name: こんにちは再利用ブロックさん
 * Description: ショートコードで再利用ブロックを呼び出すプラグインです
 * Version: 0.1.0
 *
 * @package hello_reusable_block
 * @author kutsu
 * @license GPL-2.0+
 */

/**
 * 管理画面にブロックの管理メニューを追加する
 */
add_action( 'admin_menu', 'hrb_add_wp_block_menu' );
function hrb_add_wp_block_menu () {
	add_menu_page( '再利用ブロック', '再利用ブロック', 'manage_options', 'edit.php?post_type=wp_block', '', 'dashicons-block-default', 31 );
}

/**
 * 再利用ブロックをショートコードから呼び出す
 */
function hrb_show_reusable_block ( $atts ) {
    //ショートコードのパラメーター
	extract(shortcode_atts(array(
		'post_id'    => '',
        'post_title' => ''
	), $atts));

    //指定のIDからコンテンツを取得し返す
    if ( $post_id ) {
        $reuse_block = get_post( $post_id );
        $reuse_block_content = ( $reuse_block && 'wp_block' === $reuse_block->post_type ) ? $reuse_block->post_content : '';

    //タイトルの指定がある場合はタイトル名からコンテンツを取得する
    } elseif ( $post_title ) {
        $args = array(
            'post_type'      => 'wp_block',
            'title'          => $post_title,
            'posts_per_page' => 1,
            'no_found_rows'  => true,
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $reuse_block_content = get_the_content();
            }
        }
        wp_reset_postdata();

    } else {
        return;
    }
    return apply_filters('the_content', $reuse_block_content);
}
add_shortcode('hrb_show_reusable_block', 'hrb_show_reusable_block');
