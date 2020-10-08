<?php



$absolute_path = __FILE__;

$path_to_file = explode('wp-content', $absolute_path);



if (count($path_to_file) > 1) {

    /* got wp-content dir */

    $path_to_wp = $path_to_file[0];

} else {

    /* dev environement */

    $path_to_file = explode('content', $absolute_path);

    $path_to_wp = $path_to_file[0] . '/wp';

}

// Access WordPress

require_once( $path_to_wp . '/wp-load.php' );

//Initial response is NULL

$response = null;



//Initialize appropriate action and return as HTML response

?>

<?php



if (isset($_POST["name"])) {



    $name = $_POST["name"];



    switch ($name) {



        case "columns" : {

                $response = '<div id="shortcodes_' . $name . '_form">

							<table id="cocobasic_shortcode_columns">

								<tr>

									<th><label for="shortcode_columns_class">' . esc_html__('Class', 'cocobasic-shortcode') . '</label></th>

									<td><input style="width:150px" name="columns" id="shortcode_columns_class" /><br /><small>' . esc_html__('additional class', 'cocobasic-shortcode') . '</small></td>

								</tr>	

								<tr>

									<th><label for="shortcode_columns">Columns</label></th>

									<td><select name="columns" id="shortcode_columns"><option>1/1</option><option>1/2</option><option>1/3</option><option>2/3</option><option>1/4</option><option>3/4</option></select><br /><small>' . esc_html__('select column width', 'cocobasic-shortcode') . '</small></td>

									<td><input type="checkbox" id="column_checkbox" name="last_checkbox" value="last">' . esc_html__('Last', 'cocobasic-shortcode') . '</td>

								</tr>	

							</table>

							<p class="submit">

								<input type="button" id="submit_shortcode" class="button-primary" value="' . esc_html__('Insert Shortcode', 'cocobasic-shortcode') . '" name="submit" />

							</p>

						</div>';

            }

            break;



        case "image_slider" : {

                $response = '<div id="shortcodes_' . $name . '_form">

						 	<table id="cocobasic_shortcode_image_slider">

								<tr>

									<th><label for="shortcode_image_slider_name">' . esc_html__('Name', 'cocobasic-shortcode') . '</label></th>

									<td><input style="width:150px" name="image_slider" id="shortcode_image_slider_name" value="slider1" /><br /><small>' . esc_html__('*required image slider name - unique', 'cocobasic-shortcode') . '</small></td>

								</tr>

								<tr>

									<th><label for="shortcode_image_slider_auto">' . esc_html__('Auto', 'cocobasic-shortcode') . '</label></th>

									<td><select id="shortcode_image_slider_auto"><option>true</option><option>false</option></select><br /><small>' . esc_html__('slide auto', 'cocobasic-shortcode') . '</small></td>

								</tr>

								<tr>

									<th><label for="shortcode_image_slider_hover_pause">' . esc_html__('Hover Pause', 'cocobasic-shortcode') . '</label></th>

									<td><select id="shortcode_image_slider_hover_pause"><option>true</option><option>false</option></select><br /><small>' . esc_html__('pause on hover', 'cocobasic-shortcode') . '</small></td>

								</tr>

								<tr>

									<th><label for="shortcode_image_slider_speed">' . esc_html__('Speed', 'cocobasic-shortcode') . '</label></th>

									<td><input style="width:100px" name="image_slider" id="shortcode_image_slider_speed" value="2000" /><br /><small>' . esc_html__('duration of the transition in milliseconds', 'cocobasic-shortcode') . '</small></td>

								</tr>

							</table>

							<p class="submit">

								<input type="button" id="submit_shortcode" class="button-primary" value="' . esc_html__('Insert Shortcode', 'cocobasic-shortcode') . '" name="submit" />

							</p>

						 </div>';

            }

            break;



        case "image_slide" : {

                $response = '<div id="shortcodes_' . $name . '_form">

						 	<table id="cocobasic_shortcode_image_slide">

								<tr>

								<th><label for="shortcode_image_slide_img">' . esc_html__('Set Image', 'cocobasic-shortcode') . '</label></th>

								<td><label for="upload_image">

								<input id="shortcode_image_slide_img" type="text" size="36" name="shortcode_image_slide_img" value="" /> 

								<input id="upload_image_button" class="button" type="button" value="' . esc_html__('Upload Image', 'cocobasic-shortcode') . '" />

								<br /><small>' . esc_html__('Enter a URL or upload an image', 'cocobasic-shortcode') . '</small>

								</label>

								</td>	

								</tr>

								<tr>

									<th><label for="shortcode_image_slide_alt">' . esc_html__('Alt tag for image', 'cocobasic-shortcode') . '</label></th>

									<td><input style="width:300px" name="image_slider" id="shortcode_image_slide_alt" /><br /><small>' . esc_html__('Alt tag for image (optional)', 'cocobasic-shortcode') . '</small></td>

								</tr>

								<tr>

									<th><label for="shortcode_image_slide_href">' . esc_html__('URL to Page/Post', 'cocobasic-shortcode') . '</label></th>

									<td><input style="width:300px" name="image_slider" id="shortcode_image_slide_href" /><br /><small>' . esc_html__('Use this field to link image to some Page/Post (optional)', 'cocobasic-shortcode') . '</small></td>

								</tr>

								<tr>

									<th><label for="shortcode_image_slide_target">' . esc_html__('Target', 'cocobasic-shortcode') . '</label></th>

									<td><select id="shortcode_image_slide_target"><option></option><option>_self</option><option>_blank</option></select><br /><small>' . esc_html__('if URL to Page/Post is set (specifies how to open the linked page)', 'cocobasic-shortcode') . '</small></td>

								</tr>

							</table>

							<p class="submit">

								<input type="button" id="submit_shortcode" class="button-primary" value="' . esc_html__('Insert Shortcode', 'cocobasic-shortcode') . '" name="submit" />

							</p>

						 </div>';

            }

            break;





        default: {

                $response = '';

            }

    }

}

?>

<?php



if (isset($response) && !empty($response) && !is_null($response)) {

    echo '{"ResponseData":' . json_encode($response) . '}';

}

?>