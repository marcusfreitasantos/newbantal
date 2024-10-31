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


function generateLogFiles($folderPath, $logMessage){
	$uploadDir = wp_upload_dir();
	$logFilePath = $uploadDir['basedir'] . $folderPath;
	file_put_contents($logFilePath, $logMessage, FILE_APPEND);
}


function getEmployersFromApi(){
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiResponse = wp_remote_get("$baseApiUrl/lista-usuarios", array("timeout" => 300));

	 if (!is_wp_error( $apiResponse ) ) {
		generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: .... \n");

        $usersList = json_decode($apiResponse["body"]);

		if(!empty($usersList)){
			foreach($usersList as $company){
				if($company->perfil == "EMPLOYER"){
					saveClientsFromApi($company, "bantal_employers");
				}
			}
		}
	 }else{
		$errorMsg = $apiResponse->get_error_message();
		$currentDate = date("Y-m-d H:i:s");
		generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: $errorMsg. $currentDate. \n");
        return;
	 }
}
add_action("getEmployersFromApiHook", "getEmployersFromApi");


function getCandidatesFromApi(){
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiResponse = wp_remote_get("$baseApiUrl/lista-usuarios", array("timeout" => 300));

	 if (!is_wp_error( $apiResponse ) ) {
		generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: .... \n");

        $usersList = json_decode($apiResponse["body"]);

		if(!empty($usersList)){
			foreach($usersList as $user){
				if($user->perfil == "CANDIDATE"){
					saveClientsFromApi($user, "bantal_candidates");
				}
			}
		}
	 }else{
		$errorMsg = $apiResponse->get_error_message();
		$currentDate = date("Y-m-d H:i:s");
		generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: $errorMsg. $currentDate. \n");
        return;
	 }
}
add_action("getCandidatesFromApiHook", "getCandidatesFromApi");


function saveClientsFromApi($client, $tableName){
	global $wpdb;

	$tableName = $wpdb->prefix . $tableName;

	$existingCompany = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $tableName WHERE user_id = %d", $client->userId
    ));

	if($existingCompany){
		$dataToUpdate = array(
			'display_name' => $client->displayName,
			'photo' =>  $client->foto,
			'latitude' => $client->latitude,
			'longitude' => $client->longitude
		);

		$where = array(
			'user_id' => $client->userId
		);

		$whereFormat = array('%d');

		$dataToUpdateFormat = array('%s', '%s', '%f', '%f');
		
		$wpdb->update($tableName, $dataToUpdate, $where, $dataToUpdateFormat, $whereFormat);

	}else{
		$data = array(
			'user_id' => $client->userId,
			'display_name' => $client->displayName,
			'photo' =>  $client->foto,
			'latitude' => $client->latitude,
			'longitude' => $client->longitude
		);

		$format = array('%d', '%s', '%s', '%f', '%f');

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

    $tableName = $wpdb->prefix . 'bantal_employers';

    $query = $wpdb->prepare("SELECT * FROM $tableName LIMIT %d", $limit);

    $companies = $wpdb->get_results($query);

    if ($companies) {
        return $companies;
    } else {
        return "No data found.";
    }
}

function getAllBantalUsersFromDatabase() {
    global $wpdb;

	$tableNameEmployers = $wpdb->prefix . 'bantal_employers';
    $tableNameCandidates = $wpdb->prefix . 'bantal_candidates';

	$query = $wpdb->prepare("
		SELECT * FROM $tableNameEmployers
		UNION
		SELECT * FROM $tableNameCandidates
		LIMIT %d
	", 500);

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
