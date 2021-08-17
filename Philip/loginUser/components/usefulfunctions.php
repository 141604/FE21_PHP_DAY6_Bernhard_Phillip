<?php
function debug_to_console($data) {
    $output = $data;
    if (is_array($output)) $output = implode(',', $output);
	echo "<script>console.log('$output');</script>";
}

function formatted_dump($obj, $print_to_console=FALSE) {
	if ($print_to_console) debug_to_console($obj);
	else echo "<pre>". var_dump($obj) ."</pre>";
}

function CleanInput($string) { // sanitize user input to prevent sql injection
    $new_string = trim($string);
    $new_string = strip_tags($new_string);
    $new_string = htmlspecialchars($new_string);
    return $new_string;
}

?>