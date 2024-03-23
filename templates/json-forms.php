<?php namespace Json2Rest\JsonForms; 

use Json2Rest\Helpers;

$jsonData = get_option('Json2Rest_data');
$jsonSettings = get_option('Json2Rest_settings');
$jsonBlocks = maybe_unserialize($jsonData); ?>

<div id="Json2Rest-container">
    <?php if (empty($jsonSettings)) :
        echo '<div class="error"><p>You need to configure JSON settings first before adding JSON data. Go to <a href="' . admin_url('admin.php?page=json-settings') . '">JSON Settings</a>.</p></div>';
        return;
    else : ?>

    <div class="wrap">
        <h2>Add JSON Data</h2>
        <form method="post" enctype="application/json">
            <div id="json-blocks">
                <?php if (!empty($jsonBlocks)) : 
                    foreach ($jsonBlocks as $name => $data) :
                        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
                        $jsonData = Helpers\decode_unicode_sequences($jsonData);
                    ?>
                        <div class="json-block">
                            <input type="text" name="json_names[]" value="<?php echo esc_attr($name); ?>" placeholder="Enter JSON Name">
                            <textarea name="json_data[]" rows="10" cols="50" placeholder="Enter JSON Data"><?php echo esc_textarea($jsonData); ?></textarea>
                            <button type="button" class="remove-json-block">Remove</button>
                        </div>
                    <?php endforeach;
                else : ?>
                    <div class="json-block">
                        <input type="text" name="json_names[]" placeholder="Enter JSON Name">
                        <textarea name="json_data[]" rows="10" cols="50" placeholder="Enter JSON Data"></textarea>
                        <button type="button" class="remove-json-block">Remove</button>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" id="add-json-block">Add JSON</button>
            <input type="submit" id="json-form" name="submit" class="button button-primary" value="Save" <?php echo empty($jsonSettings) ? 'disabled' : ''; ?>>
        </form>
    </div>
    <?php endif; ?>
</div>