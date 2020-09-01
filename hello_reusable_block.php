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

function hrb_hello( $atts ) {
	extract(shortcode_atts(array(
		'pid' => 0,
	), $atts));
	$reuse_block = get_post( $pid );
	if ( $reuse_block && 'wp_block' === get_post_type($pid) ) {
		$reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
	}
	return $reuse_block_content;
}
add_shortcode('hrb_hello', 'hrb_hello');
