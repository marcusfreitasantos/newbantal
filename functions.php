<?php
function oceanwp_child_enqueue_parent_style() {

	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );

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
	
}

add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


include("components/button-link.php");
include("components/post-card.php");
include("components/whatsapp-btn.php");
include("components/post-pagination.php");
include("components/companies-logo-carousel.php");


global $emailHeaders;
$emailHeaders = array(
	'Content-Type: text/html; charset=UTF-8',
	'Reply-To: Blessy <contato@aristeupires.com.br>',
);


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


function getCompaniesFromApi(){
	$baseApiUrl = BANTAL_API_PUBLIC_URL;
	$apiResponse = wp_remote_get("$baseApiUrl/lista-usuarios", array("timeout" => 120));

	 if (!is_wp_error( $apiResponse ) ) {
				generateLogFiles("/bantal-api-logs/get-clients/get-clients-log.txt", "Error in geting clients from api. Error message: .... \n");


        $usersList = json_decode($apiResponse["body"]);

		if(!empty($usersList)){
			foreach($usersList as $company){
				if($company->perfil == "EMPLOYER"){
					saveCompaniesFromApiToDatabase($company);
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
add_action("getCompaniesFromApiHook", "getCompaniesFromApi");


function saveCompaniesFromApiToDatabase($company){
	global $wpdb;

	$table_name = $wpdb->prefix . 'bantal_clients';

	$existingCompany = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE company_id = %d", $company->userId
    ));

	if($existingCompany){
		$dataToUpdate = array(
			'company_name' => $company->displayName,
			'company_logo' =>  $company->foto
		);

		$where = array(
			'company_id' => $company->userId
		);

		$whereFormat = array('%d');

		$dataToUpdateFormat = array('%s', '%s');
		
		$wpdb->update($table_name, $dataToUpdate, $where, $dataToUpdateFormat, $whereFormat);

	}else{
		$data = array(
			'company_id' => $company->userId,
			'company_name' => $company->displayName,
			'company_logo' =>  $company->foto
		);

		$format = array('%d', '%s', '%s');

		$wpdb->insert($table_name, $data, $format);

		$insert_id = $wpdb->insert_id;
	
		if (!$insert_id) {
			$currentDate = date("Y-m-d H:i:s");
			generateLogFiles("/bantal-api-logs/database-operations/insert-data-log.txt", "Failed to insert data for $company->displayName. $currentDate. \n");
		} 
	}
}


?>
