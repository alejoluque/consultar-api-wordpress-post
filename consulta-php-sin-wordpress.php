<?php

$uri = 'https://dominio.com/wp-json/wp/v2/posts?per_page=5';
$json = file_get_contents($uri);
$posts= json_decode($json);
 
echo "<div class='clase-principal'>";
foreach ($posts as $post) { 

    $img_post = 'https://dominio.com/wp-json/wp/v2/media/'.$post->featured_media.'';
    $json_img = file_get_contents($img_post);
    $posts_img = json_decode( $json_img );
   $categorias = $post->categories;
        foreach($categorias as $cat){ 
            //echo $cat;
            $cat_post = 'https://dominio.com/blog/wp-json/wp/v2/categories/'.$cat.'';
            $json_cat = file_get_contents($cat_post);
                $posts_cat = json_decode( $json_cat );
            
        }
    echo '<div class="itemCard">
                <div class="img">
                    <img src="'.$posts_img ->source_url.'" alt="" />
                </div>
                
                <div class="cont">
                    <span>'.$posts_cat->name.'</span>
                    
                    <h2>'. $post->title->rendered .'</h2>

                    <p>'.$post->excerpt->rendered.'</p>

                    <a href="' . $post->link . '">Leer más</a>
                </div>
            </div>';
    
}
echo "</div>";



?>
