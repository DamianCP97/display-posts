<?php
/*
Plugin Name: Display Posts
Description: Plugin to display the posts of your WordPress.
Version: 1.0
Author: Damián Caamaño
Author URI: https://www.linkedin.com/in/dami%C3%A1n-caama%C3%B1o-pazos-a543a71b3/
*/

//Función para añadir el CSS
function enqueue_estilos() {
    wp_enqueue_style('estilos', plugins_url('assets/styles.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_estilos');

// Función para mostrar publicaciones según los argumentos
function mostrar_publicaciones_personalizadas() {
    // Define los argumentos para la consulta
    $args = array(
        'post_type' => 'post',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => 6
    );

    // Realiza la consulta
    $publicaciones_query = new WP_Query($args);

    // Comprueba si hay publicaciones
    if ($publicaciones_query->have_posts()) {
        // Comienza el bucle de publicaciones
        while ($publicaciones_query->have_posts()) {
            ?>
            <div class="entrada">
                <?php
            $publicaciones_query->the_post(); //Aquí se configura la publicación actual dentro del bucle. Se puede acceder a los datos de la publicación actual utilizando funciones de WordPress como the_title(), the_content(), etc.
            the_title('<h2>', '</h2>');
            the_category(', ');
            ?>
            </div>
            <?php
        }
        // Restaura los datos de la consulta
        wp_reset_postdata();
    } else {
        // Si no hay publicaciones
        echo 'There is no posts to display.';
    }
}

// Función para agregar un shortcode que mostrará las publicaciones
function agregar_shortcode_publicaciones() {
    add_shortcode('mostrar_publicaciones', 'mostrar_publicaciones_personalizadas');
}

add_action('init', 'agregar_shortcode_publicaciones'); //Permite ejecutar la función cuando WordPress se inicializa