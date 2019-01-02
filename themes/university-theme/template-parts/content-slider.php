<?php
$image = get_field('slide_image');
$headline = get_field('slide_headline');
$subtitle = get_field('slide_subtitle');
$link = get_field('slide_link');


?>
<div class="hero-slider__slide" style="background-image: url(<?php echo $image['url'] ?>);">
<div class="hero-slider__interior container">
    <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center"><?php echo $headline ?></h2>
        <p class="t-center"><?php echo $subtitle ?></p>
        <p class="t-center no-margin"><a href="<?php the_permalink() ?>" class="btn btn--blue">Learn more</a></p>
    </div>
</div>
</div>

<!-- headline, subtitle, image, link -->