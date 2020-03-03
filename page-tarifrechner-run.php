<?php get_header(); ?>

    <div class="fl-content-full container">
		<?php
		$slug = get_query_var( 'tarifrechner_call', '' );
		if ( $slug ) {
			$args = [
				'post_type'      => 'versicherung',
				'posts_per_page' => 1,
				'post_name__in'  => [ $slug ]
			];
			/**
			 * @var WP_Post $objVersicherung
			 */
			$objVersicherung = array_pop( get_posts( $args ) );
			$title           = 'Tarifrechner für ' . $objVersicherung->post_title;
			$tarifrechner    = get_field( 'tarifrechner', $objVersicherung->ID );
		} else {
			$tarifrechner = '';
			$title        = '';
		}
		?>
        <div class="row">
            <div class="fl-content col-md-12">
				<?php
				if ( strlen( $tarifrechner ) ) {
					$tarifrechner .= '&ur_iD=mobile';
				    echo( '<h2>' . $title . '</h2>' );
					?>
                    <div class="hinweis fl-module-content fl-node-content">
						<span class="fl-icon-wrap">
						<span class="fl-icon">
						<i class="fa fa-info-circle"></i>
						</span>
						<span class="fl-icon-text">
						Hinweis: Die Berechnung über einen Tarifrechner kann immer nur einen Richtwert darstellen. Für ein exaktes Angebot über Leistung sowie Prämie kontaktieren Sie uns bitte, da mit diversen Gesellschaften Rahmenverträge bestehen, die nicht mithilfe eines Tarifrechners abgedeckt werden können.			</span>
						</span>
                    </div>
                    <iframe id="MiTRFrame" frameborder="0" width="100%" height="600" src="<?php echo( $tarifrechner ); ?>"></iframe>
					<?php
				} else {
					echo( '<p><strong>Tarifrechner konnte nicht geladen werden.</strong></p>' );
				}
				?>
                <script type="text/javascript">
                    if (window.addEventListener) {
                        window.addEventListener("message", function(event) {
                            mrmoProgressEvent(event);
                        }, false);
                    } else if(window.attachEvent)
                    {   window.attachEvent("onmessage", function(event) {
                        mrmoProgressEvent(event);
                    });
                    }
                    function mrmoProgressEvent(event) {
                        try {
                            var json = JSON.parse(event.data);
                            var doc = document.getElementById('MiTRFrame').style.height = parseInt(json.bodyHeight) + 'px';

                            /* für Ergebnisseite - aktivieren falls benötigt */
                            /*if ( json.mrmoScrollTop == 1 ) {
                             window.scrollTo(0,0);
                             }*/
                        }catch(e){}
                    }
                </script>
            </div>
        </div>
    </div>

<?php get_footer(); ?>