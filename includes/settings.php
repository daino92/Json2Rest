<?php namespace Json2Rest\SettingsPage;

function add_settings_page() {
    add_menu_page(
        'JSON Settings',
        'JSON Settings',
        'manage_options',
        'json-settings',
        __NAMESPACE__ . '\render_json_settings', 
        'dashicons-admin-generic',
        25
    );

    add_submenu_page(
        'json-settings',
        'Fill JSONs',
        'Fill JSONs',
        'manage_options',
        'fill-jsons',
        __NAMESPACE__ . '\render_json_forms'
    );
}
add_action('admin_menu', __NAMESPACE__ . '\add_settings_page');

function render_json_forms() {
    include MY_JSON_REST_API_PLUGIN_DIR . 'templates/json-forms.php';
}

function render_json_settings() {
    include MY_JSON_REST_API_PLUGIN_DIR . 'templates/json-settings.php';
}

function form_submission() {
    if (!isset($_POST['submit'])) return;

    if (isset($_POST['json_names']) && isset($_POST['json_data'])) {
        $jsonNames = $_POST['json_names'];
        $jsonData = $_POST['json_data'];

        $combinedJson = array();
        
        // Combine JSON names and data
        foreach ($jsonNames as $index => $name) {
            if (!empty($name) && isset($jsonData[$index])) {
                $jsonString = stripslashes(sanitize_textarea_field($jsonData[$index]));        
                $decodedJson = json_decode($jsonString, true);
        
                if ($decodedJson !== null) {
                    $combinedJson[$name] = $decodedJson;
                } 
            }
        }
    
        $serializedArr = maybe_serialize($combinedJson);

        update_option('Json2Rest_data', $serializedArr);  
        
        add_action('admin_notices', function() {
            echo '<div class="updated"><p>JSON data have been saved successfully.</p></div>';
        });
    } elseif (isset($_POST['param_name']) && isset($_POST['rest_name'])) {
        $paramName = sanitize_text_field($_POST['param_name']);
        $restName = sanitize_text_field($_POST['rest_name']);

        $storedData = get_option('Json2Rest_settings');

        if (!$storedData) {
            $storedData = array();
        }

        $settingExists = false;
        foreach ($storedData as &$setting) {
            if ($setting['param_name'] === $paramName) {
                $setting['rest_name'] = $restName;
                $settingExists = true;
                break;
            }
        }

        if (!$settingExists) {
            $storedData[] = array(
                'param_name' => $paramName,
                'rest_name' => $restName
            );
        }

        update_option('Json2Rest_settings', $storedData); 
        
        add_action('admin_notices', function() {
            echo '<div class="updated"><p>JSON configurations have been saved successfully.</p></div>';
        });    
    }
}
add_action('admin_init', __NAMESPACE__ . '\form_submission'); ?>