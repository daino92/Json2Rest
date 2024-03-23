<?php namespace Json2Rest\RestAPI;
use WP_Error;
use WP_REST_Response;

function get_data_callback($request) {
    $jsonSettings = get_option('Json2Rest_settings')[0] ?? null;

    if (!$jsonSettings) {
        return new WP_REST_Response(array('message' => 'You should configure the required settings first before attempting to use the service.'), 400);
    }
    $paramName = $jsonSettings["param_name"];
    
    $param = $request->get_param($paramName);

    
    $jsonData = get_option('Json2Rest_data');
    
    $jsonData = maybe_unserialize($jsonData);
    
    if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('invalid_json', 'Error decoding JSON data.', array('status' => 500));
    }
    
    if (!empty($param) && isset($jsonData[$param])) {
        $response = $jsonData[$param];
        return new WP_REST_Response($response, 200);
    } else {
        return new WP_Error('invalid_school', 'Invalid or missing school parameter.', array('status' => 400));
    }
}

function register_data_endpoint() {
    $jsonSettings = get_option('Json2Rest_settings');
    
    if (!is_array($jsonSettings) || empty($jsonSettings)) {
        return new WP_REST_Response(array('message' => 'You should configure the required settings first before attempting to use the service.'), 400);
    }
    
    $restName = $jsonSettings[0]['rest_name'];

    register_rest_route('rest/v1/', $restName,
        array(
            'methods' => 'GET',
            'callback' => __NAMESPACE__ . '\get_data_callback',
        )
    );
}
add_action('rest_api_init', __NAMESPACE__ . '\register_data_endpoint');