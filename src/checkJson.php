<?php

  function checkJson($form, $json) {
      $error = false;

      foreach ($form as $key) {
           if (!isset($json[$key])) {
                $error	= true;
           }

          if (($key == "id" || $key == "article_id") && !is_numeric($json[$key])) {
               $error = true;
          }
      }

    return ($error);
  }

?>
