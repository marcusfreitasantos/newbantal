<?php
global $emailHeaders;

$emailHeaders = array(
	'Content-Type: text/html; charset=UTF-8',
	'Reply-To: Blessy <contato@aristeupires.com.br>',
);

function oceanwp_child_enqueue_parent_style() {

	$version = "1.0.5";

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/libs/bootstrap/css/bootstrap.min.css',array(), $version );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/libs/fontawesome/css/fontawesome.css',array(), $version );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/libs/fontawesome/css/regular.css',array(), $version );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/libs/fontawesome/css/brands.css',array(), $version );
	wp_enqueue_style( 'bootstrap-style', get_stylesheet_directory_uri() . '/assets/libs/fontawesome/css/solid.css',array(), $version );
	wp_enqueue_style( 'swiper-style', get_stylesheet_directory_uri() . '/assets/libs/swiper/css/swiper-bundle.min.css',array(), $version );
   	wp_enqueue_style( 'lightbox-style', get_stylesheet_directory_uri() . '/assets/libs/lightbox/css/lightbox.min.css',array(), $version );

	wp_enqueue_script( 'bootstrap-main-script', get_stylesheet_directory_uri() . '/assets/libs/bootstrap/js/bootstrap.min.js', array(), $version );
	wp_enqueue_script( 'bootstrap-bundle-script', get_stylesheet_directory_uri() . '/assets/libs/bootstrap/js/bootstrap.bundle.min.js', array(), $version );
	wp_enqueue_script( 'swiper-script',get_stylesheet_directory_uri() . '/assets/libs/swiper/js/swiper-bundle.min.js', array(), $version );
   	wp_enqueue_script( 'lightbox-script',get_stylesheet_directory_uri() . '/assets/libs/lightbox/js/lightbox.min.js', array(), $version );
	wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/scripts.js', array(), $version );

	//AJAX
	wp_enqueue_script( 'ajax-bantal-scripts', get_stylesheet_directory_uri() . '/assets/js/ajax-bantal-scripts.js', array('jquery'), $version, true );
    wp_localize_script( 'ajax-bantal-scripts', 'my_ajax_obj', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );





include("components/button-link.php");
include("components/post-card.php");
include("components/post-pagination.php");
include("components/companies-logo-carousel.php");
include("components/login-form.php");
include("components/bottom-cta.php");
include("components/bantal-plan-card.php");
include("components/google-maps.php");
include("general-options.php");




function getAllPostCategories(){
    $postCategoriesArgs = array(
        'taxonomy'   => 'category',
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true
    );
    $postCategories = get_terms($postCategoriesArgs);
    
    return $postCategories;
}


function getOccupationsFromApi() {
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiUrl = "$baseApiUrl/obterAreaAtuacao";
	$ch = curl_init($apiUrl);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		$errorMsg = curl_error($ch);
		curl_close($ch);

		$currentDate = date("Y-m-d H:i:s");
		// generateLogFiles("/bantal-api-logs/get-clients/get-occupation-list-log.txt", "Error in getting occupations from API. Error message: $errorMsg. $currentDate. \n");
		return;
	}

	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode === 200) {
		$occupationList = json_decode($response);

		if (!empty($occupationList)) {
			return $occupationList;
		}
	} else {
		$currentDate = date("Y-m-d H:i:s");
		$errorMsg = "HTTP Error $httpCode";
		// generateLogFiles("/bantal-api-logs/get-clients/get-occupation-list-log.txt", "Error in getting occupations from API. HTTP Code: $httpCode. $currentDate. \n");
		return;
	}
}


function generateLogFiles($folderPath, $logMessage){
	$uploadDir = wp_upload_dir();
	$logFilePath = $uploadDir['basedir'] . $folderPath;
	file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}

function defineOccupationToBantalUser($user, $occupationList){
	$userOccupation = "";

	foreach($occupationList as $occupation){
		if($occupation->idAreaAtuacao == $user->idAreaAtuacao){
			$userOccupation = $occupation->nome; 
		}
	}

	return $userOccupation;

}


function getUsersFromApi($page) {
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiUrl = "$baseApiUrl/lista-usuarios?page=$page&size=50&sort=displayName%2Casc";
	$ch = curl_init($apiUrl);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		$error_message = curl_error($ch);
		curl_close($ch);
		return new WP_Error('broke', __($error_message, "my_textdomain"));
	}

	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);

	if ($httpCode === 200) {
		$response = json_decode($response);
		$usersList = $response->content;
		$occupationList = getOccupationsFromApi();

		if (!empty($usersList) && !empty($occupationList)) {
			foreach ($usersList as $user) {
				saveUsersFromApiInDatabase($user, defineOccupationToBantalUser($user, $occupationList));
			}
			return $usersList;
		}
	} else {
		$currentDate = date("Y-m-d H:i:s");
		$errorMsg = "HTTP Error $httpCode";
		//generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in getting clients from API. Error message: $errorMsg. $currentDate. \n");
		return new WP_Error('broke', __("Error in getting clients from API. HTTP Code: $httpCode", "my_textdomain"));
	}
}
add_action("getUsersFromApiHook", "getUsersFromApi");



function getUsersBatch(){
	$page = 1;
	$users = getUsersFromApi($page);

	while($users && !empty($users)){
		$page++;
		$users = getUsersFromApi($page);

		if(is_wp_error($users)){
			return 'Users not updated.';
		}
	}

	return 'Users updated!';
}
add_action("getUsersFromApiHook", "getUsersBatch");



function saveUsersFromApiInDatabase($client, $clientOccupation){
	global $wpdb;

	$tableName = $wpdb->prefix . 'bantal_users' ;

	$existingCompany = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $tableName WHERE user_id = %d", $client->userId
    ));

	if($existingCompany){
		$dataToUpdate = array(
			'display_name' => $client->displayName,
			'photo' =>  $client->foto,
			'latitude' => $client->latitude,
			'longitude' => $client->longitude,
			'role' => $client->perfil,
			'services' => $client->servicos ? $client->servicos : "",
			'occupation_id' => $client->idAreaAtuacao,
			'occupation_name' => $clientOccupation,

		);

		$where = array(
			'user_id' => $client->userId
		);

		$whereFormat = array('%d');

		$dataToUpdateFormat = array('%s', '%s', '%f', '%f', '%s', '%s', '%d', '%s');
		
		$wpdb->update($tableName, $dataToUpdate, $where, $dataToUpdateFormat, $whereFormat);

	}else{
		$data = array(
			'user_id' => $client->userId,
			'display_name' => $client->displayName,
			'photo' =>  $client->foto,
			'latitude' => $client->latitude,
			'longitude' => $client->longitude,
			'role' => $client->perfil,
			'services' => $client->servicos ? $client->servicos : "",
			'occupation_id' => $client->idAreaAtuacao,
			'occupation_name' => $clientOccupation,
		);

		$format = array('%d', '%s', '%s', '%f', '%f', '%s', '%s', '%d', '%s');

		$wpdb->insert($tableName, $data, $format);

		$insert_id = $wpdb->insert_id;
	
		if (!$insert_id) {
			$currentDate = date("Y-m-d H:i:s");
			//generateLogFiles("/bantal-api-logs/database-operations/insert-data-log.txt", "Failed to insert data for $client->displayName. $currentDate. \n");
		} 
	}
}


function getAllCompaniesFromDatabase($limit) {
    global $wpdb;

    $tableName = $wpdb->prefix . 'bantal_users';

    $query = $wpdb->prepare("SELECT * FROM $tableName WHERE role = 'EMPLOYER' AND photo IS NOT NULL ORDER BY date_creation DESC LIMIT %d", $limit);

    $companies = $wpdb->get_results($query);

    if ($companies) {
        return $companies;
    } else {
        return "No data found.";
    }
}

function getAllBantalUsersFromDatabase() {
    global $wpdb;
	
	$targetUserRole = isset($_POST['userRole']) ? $_POST['userRole'] : null;
	$tableName = $wpdb->prefix . 'bantal_users';

	if($targetUserRole){
		$query = $wpdb->prepare("SELECT * FROM $tableName WHERE role = '$targetUserRole' LIMIT %d", 500);
	}else{
		$query = $wpdb->prepare("SELECT * FROM $tableName LIMIT %d", 500);
	}

    $allBantalUsers = $wpdb->get_results($query);

    if ($allBantalUsers) {
        wp_send_json_success($allBantalUsers);
    } else {
        wp_send_json_error("No data found.");
    }

}


add_action( 'wp_ajax_get_bantal_users_by_ajax', 'getAllBantalUsersFromDatabase' );
add_action( 'wp_ajax_nopriv_get_bantal_users_by_ajax', 'getAllBantalUsersFromDatabase' );

?>
