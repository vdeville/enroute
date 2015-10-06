<?php get_header(); ?>
<?php

    global $wp_query;
    $term = $wp_query->get_queried_object();
    $enr_map_locations = enroute_get_tax_stores( $term->term_id );

?>

<div id="enroute-holder" class="enroute-tax-page">

    <?php if( !empty( $enr_map_locations ) ) : ?>
        <div id="enroute-map" class="enroute-map-container"></div>

        <div id="enroute-output" class="enroute-map-container" style="display: none;"></div>
        <div id="enroute-route">
            <div class="split">
                <input type="text" id="enroute-from" class="enroute-control" value="" onfocus="enroute_geolocate()" placeholder="Enter your address">
            </div>
            <div class="split">
                <select id="enroute-to" class="enroute-control">
                    <option value="">Select your nearest store</option>
                    <?php foreach( $enr_map_locations as $k => $v ) : ?>
                        <option value="<?php echo $v['gps']['lat']; ?>, <?php echo $v['gps']['lng']; ?>"><?php echo $v['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="split">
                <input type="button" class="enroute-btn" id="enroute-submit" value="Get Route" onclick="enroute_getmap()">
            </div>
            <div id="enroute-controls-top" class="enroute-map-controls" style="display: none;">
                <input type="button" class="enroute-btn enroute-print" onclick="enroute_printmap()" value="Print" />
                <input type="button" class="enroute-btn" onclick="enroute_clearoutput()" value="Clear" />
            </div>
            <div id="enroute-directions" style="display: none;"></div>
            <div id="enroute-controls-bottom" class="enroute-map-controls" style="display: none;">
                <input type="button" class="enroute-btn enroute-print" onclick="enroute_printmap()" value="Print" />
                <input type="button" class="enroute-btn" onclick="enroute_clearoutput()" value="Clear" />
            </div>
        </div>
    <?php endif; ?>

</div>

<?php get_footer(); ?>
