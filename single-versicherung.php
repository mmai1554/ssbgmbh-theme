<?php get_header(); ?>

<?php
global $post;
ob_start();
/**
 * read the html skeleton from the template-page: slug = 'vorlage-versicherung'
 */
FLBuilder::render_query( array(
    'page_id' => 2411,
));
$html = ob_get_clean();

// for examining the html:
// $path = mi_versicherung_plugin_path().'assets/log.txt';
// file_put_contents($path, $html);
// Broschüren:
if (!have_rows('broschuere')) {
    $class_downloads = 'mi_hide';
    $pdf = '';
} else {
    $class_downloads = '';
    ob_start();
    include(locate_template('templates/promo_broschuere.php'));
    $pdf = ob_get_clean();
}
// tarifrechner:
//$tarifrechner = '<iframe width="1024" height="768" src="%s" style="-webkit-transform:scale(0.5);-moz-transform-scale(0.5);"></iframe>';
// $tarifrechner = sprintf('<iframe width="1024" height="768" src="%s"></iframe>', get_field('tarifrechner'));
$tarifrechner_url = get_field('tarifrechner');
if (strlen($tarifrechner_url)) {
    $tarifrechner = str_replace("\n", "", '<div class="codegena_iframe" data-src="%s" 
style="height:602px;width:1024px;"
data-responsive="true" 
data-css="background:url(\'%s/wp-content/plugins/mi-versicherung/assets/loading.gif\') white center center no-repeat;border:0px;"
data-img="%s/wp-content/plugins/mi-versicherung/assets/RechnerStarten.jpg"
data-name="versicherung_video"></div><script src="http://codegena.com/assets/js/async-iframe.js"></script>');
    $tarifrechner = sprintf($tarifrechner,
        get_field('tarifrechner'),
        site_url(),
        site_url()
    );
    $tarifrechner_class = 'mi_sektion_tarifrechner';
} else {
    $tarifrechner_class = 'mi_sektion_tarifrechner_hide';
    $tarifrechner = '';
}
// Video:
if (get_field('video_url')) {
    $video_field = get_field('video_url');
    if(strpos($video_field, '<iframe') !== false) {
        $video = $video_field;
    } else {
        $video = sprintf('<iframe width="1024" height="550" src="%s"></iframe>', get_field('video_url'));
    }
    $class_videos = '';
} else {
    $video = '<p>Zurzeit kein Video vorhanden</p>';
    $class_videos = 'mi_hide';
}
// background picture:
global $post;
$term_list = wp_get_post_terms($post->ID, 'zielgruppe', array("fields" => "names"));
if(is_array($term_list) && in_array('Geschäftskunden', $term_list)) {
    $header_class = 'mi_versicherung_sektion_geschaeftskunden';
} else {
    $header_class = '';
}
// Querverweise:
$arrCheck = get_field('querverweise');
if (is_array($arrCheck)) {
    ob_start();
    include(locate_template('templates/querverweise.php'));
    $querverweise = ob_get_clean();
    $class_querverweise = '';
} else {
    $class_querverweise = 'mi_hide';
    $querverweise = '';
}
// Now replace all:
$arrReplacer = array(
    '##versicherung_titel##' => get_the_title($post),
    '##versicherung_untertitel##' => get_field('untertitel'),
    '##versicherung_einleitender_text##' => get_the_content(),
    '##versicherung_downloads##' => $pdf,
    '##versicherung_tarifrechner_url##' => mi_get_url_tarifrechner_call($post->post_name),
    '##versicherung_videos##' => $video,
    '##versicherung_tarifrechner_sektion_class##' => $tarifrechner_class,
    '##versicherung_header_sektion_class##' => $header_class,
    '##versicherung_querverweise##' => $querverweise,
    '##versicherung_downloads_class##' => $class_downloads,
    '##versicherung_videos_class##' => $class_videos,
    '##versicherung_querverweise_class##' => $class_querverweise,

);
$html = str_replace(array_keys($arrReplacer), array_values($arrReplacer), $html);
echo($html);
?>

<?php get_footer(); ?>

