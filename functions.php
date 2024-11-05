<?php
global $emailHeaders;

$emailHeaders = array(
	'Content-Type: text/html; charset=UTF-8',
	'Reply-To: Blessy <contato@aristeupires.com.br>',
);

function oceanwp_child_enqueue_parent_style() {

	$version = "1.0.3";

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
include("components/whatsapp-btn.php");
include("components/post-pagination.php");
include("components/companies-logo-carousel.php");
include("components/login-form.php");
include("components/bottom-cta.php");
include("components/bantal-plan-card.php");
include("components/google-maps.php");


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


function getOccupationsFromApi(){
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiResponse = wp_remote_get("$baseApiUrl/obterAreaAtuacao", array("timeout" => 300));
	
	if (!is_wp_error( $apiResponse ) ) {
        $occupationList = json_decode($apiResponse["body"]);

		if(!empty($occupationList)){
			return $occupationList;
		}
	 }else{
		$errorMsg = $apiResponse->get_error_message();
		$currentDate = date("Y-m-d H:i:s");
		generateLogFiles("/bantal-api-logs/get-clients/get-occupation-list-log.txt", "Error in geting occupations from api. Error message: $errorMsg. $currentDate. \n");
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


function getUsersFromApi(){
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiResponse = wp_remote_get("$baseApiUrl/lista-usuarios", array("timeout" => 300));

	 if (!is_wp_error( $apiResponse ) ) {
        $usersList = json_decode($apiResponse["body"]);
		$occupationList = getOccupationsFromApi();

		if(!empty($usersList) && !empty($occupationList)){
			foreach($usersList as $user){
				saveUsersFromApiInDatabase($user, defineOccupationToBantalUser($user, $occupationList));
			}
		}
	 }else{
		$errorMsg = $apiResponse->get_error_message();
		$currentDate = date("Y-m-d H:i:s");
		generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: $errorMsg. $currentDate. \n");
        return;
	 }
}
add_action("getUsersFromApiHook", "getUsersFromApi");



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
			'services' => $client->servicos,
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
			'services' => $client->servicos,
			'occupation_id' => $client->idAreaAtuacao,
			'occupation_name' => $clientOccupation,
		);

		$format = array('%d', '%s', '%s', '%f', '%f', '%s', '%s', '%d', '%s');

		$wpdb->insert($tableName, $data, $format);

		$insert_id = $wpdb->insert_id;
	
		if (!$insert_id) {
			$currentDate = date("Y-m-d H:i:s");
			generateLogFiles("/bantal-api-logs/database-operations/insert-data-log.txt", "Failed to insert data for $client->displayName. $currentDate. \n");
		} 
	}
}


function getAllCompaniesFromDatabase($limit) {
    global $wpdb;

    $tableName = $wpdb->prefix . 'bantal_users';

    $query = $wpdb->prepare("SELECT * FROM $tableName WHERE role = 'EMPLOYER' LIMIT %d", $limit);

    $companies = $wpdb->get_results($query);

    if ($companies) {
        return $companies;
    } else {
        return "No data found.";
    }
}

function getAllBantalUsersFromDatabase() {
    global $wpdb;

	$tableName = $wpdb->prefix . 'bantal_users';

	$query = $wpdb->prepare("SELECT * FROM $tableName LIMIT %d", 500);

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
