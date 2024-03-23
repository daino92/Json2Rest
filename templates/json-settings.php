<?php namespace Json2Rest\JsonSettings; 

$jsonSettings = get_option('Json2Rest_settings'); 
$jsonSettings = maybe_unserialize($jsonSettings);  ?>

<div id="Json2Rest-container">
    <div class="wrap">
        <h2>Configure JSON Settings</h2>
        <form method="post" enctype="application/json">
            <?php if (!empty($jsonSettings)) {
                foreach ($jsonSettings as $setting) { ?>
                    <div class="setting">
                        <label for="param_name">Parameter Name:</label><br>
                        <input type="text" name="param_name" value="<?php echo esc_attr($setting['param_name']); ?>" /><br><br>
                        <label for="rest_name">REST Name:</label><br>
                        <input type="text" name="rest_name" value="<?php echo esc_attr($setting['rest_name']); ?>" />
                    </div>
                <?php }
            } else { ?>
                <div class="setting">
                    <label for="param_name">Parameter Name:</label><br>
                    <input type="text" name="param_name" /><br><br>
                    <label for="rest_name">REST Name:</label><br>
                    <input type="text" name="rest_name" />
                </div>
            <?php } ?>
            <input type="submit" id="json-params" name="submit" class="button button-primary" value="Save">
        </form>
    </div>
</div>