<?php 

get_header();

?>

<h1>Bienvenue !</h1>
<div class="trait trait-rose"></div>
<span class="accueil-subtiltle">Laisser vous guider pour déterminer l'utilisation qui vous correspond.</span>
<?php

generate(0,'0');

get_footer();

function generate($level, $sub) {
	if( have_rows('reponse_' . $level, 'option') ){
		$nextLevel = 1 + $level;
		echo '<ul>';
		while( have_rows('reponse_' . $level, 'option') ): the_row();
			echo '<li class="questionnaire-li' . $level . '">';
			$isFinal = get_sub_field('reponse_finale_' . $nextLevel);
			if(!$isFinal){
				?>
					<input style="display: none;" id="<?php echo ( $sub . '-' . get_row_index() ) ?>" type="radio" name="<?php echo $nextLevel?>" />
					<label for="<?php echo ( $sub . '-' . get_row_index() ) ?>" class="reponse-container reponse-container-<?php echo $level ?>">
						<?php the_sub_field('texte_de_la_reponse_' . $nextLevel) ?>
					</label>
				<?php
				generate($nextLevel, $sub . '-' . get_row_index());
			} else {
				?>
				<a href="<?php the_sub_field('url_' . $nextLevel) ?>">
				<div class="reponse-container reponse-container-<?php echo $level ?>">
					<?php the_sub_field('texte_de_la_reponse_' . $nextLevel) ?>
				</div>
				</a>
				<?php
			}
			echo '</li>';
		endwhile;
		echo '</ul>';
	}
}

?>