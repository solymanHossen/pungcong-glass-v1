<?php
/* Template Name: Contact Page */
get_header(); 
?>

<div class="pt-24">
    <?php 
    // Use the reusable contact section
    get_template_part('template-parts/contact-section', null, array(
        'show_header' => true,
        'bg_class' => 'bg-slate-50',
        'section_id' => 'contact'
    )); 
    ?>
</div>

<?php get_footer(); ?>
