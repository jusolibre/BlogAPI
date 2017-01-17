<?php

function checkJson($form, $json) {
    $error = false;
    foreach ($form as $key) {
        /**
         * If some arguments are missing, error is detected.
         */
        if (!isset($json[$key])) {
            $error	= true;
        }

        /**
         *  If the arg 'key' is found in the array ["id", "article_id"] but it's not numeric, error is detected.
         */
        if((in_array($key, ["id", "article_id"])) && (!is_numeric($json[$key]))) {
            $error = true;
        }
    }
    return ($error);
}

?>
