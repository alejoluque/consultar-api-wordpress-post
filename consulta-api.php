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
		?>
		<div class="container" id="recent-post-home">
		<div class="row">
		<?php
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
			$allposts .= '<div class="mk-post-box col-12 col-md-4">';
			$allposts .= '<div class="mk-post-recent">';
			$allposts .= '<a href="' . esc_url( $post->link ) . '" target=\"_blank\"> ';
			$allposts .= '<div class="mk-feature-image-pr"><img class="mk-feature-image-post-recent" src="'.esc_html( $posts_img ->source_url ).'" alt="'. esc_html( $post->title->rendered ) . '"></div>';
			$allposts .= '<div class="mk-text-post-recent"><span class="mk-category-post-recent">'.esc_html( $posts_cat ->slug ).'</span><br><br><h3 class="mk-title-post-recent">' . esc_html( $post->title->rendered ) . '</h3></div>';
			
			
			$allposts .= '</a>';
			$allposts .= '</div>';
			$allposts .= '</div>';
			
		}
		return $allposts;
	}
	?>
		</div>
		</div>
		
	<?php
}
// Registrar Shortcode
add_shortcode( 'posts_api_general', 'get_posts_general' );
