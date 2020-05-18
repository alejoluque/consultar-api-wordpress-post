<?php
function get_posts_general() {
	// inicializar variable
	$allposts = '';
	
	
	$response = wp_remote_get( 'https://www.dominio.com/wp-json/wp/v2/posts?per_page=3' );
	
	if ( is_wp_error( $response ) ) {
		return;
	}
	// Consigue el cuerpo de la consulta
	$posts = json_decode( wp_remote_retrieve_body( $response ) );
	// Exit if nothing is returned.
	if ( empty( $posts ) ) {
		return;
	}		
	// Si hay publicaciones.
	if ( ! empty( $posts ) ) {
		// For each post.
	
		foreach ( $posts as $post ) {
			
			$img = esc_html( $post->featured_media );			
			$img_post = wp_remote_get( 'https://www.dominio.com/wp-json/wp/v2/media/'.$img  );
			$posts_img = json_decode( wp_remote_retrieve_body( $img_post ) );
			
			
			$cat = esc_html( $post->categories );			
			$cat_post = wp_remote_get( 'https://www.dominio.com/wp-json/wp/v2/categories/'.$cat  );
			$posts_cat = json_decode( wp_remote_retrieve_body( $cat_post ) );
			// Mostrar título vinculado y una fecha de publicación.
			
			$allposts .= '<a href="' . esc_url( $post->link ) . '" target=\"_blank\"> ';
			$allposts .= '<img src="'.esc_html( $posts_img ->source_url ).'" alt="'. esc_html( $post->title->rendered ) . '">';
			$allposts .= ''.esc_html( $posts_cat ->slug ).'<h3>' . esc_html( $post->title->rendered ) . '</h3>';
			
			
			$allposts .= '</a>';
			
		}
		return $allposts;
	}
	?>	
		
	<?php
}
// Registrar Shortcode
add_shortcode( 'posts_api_general', 'get_posts_general' );
