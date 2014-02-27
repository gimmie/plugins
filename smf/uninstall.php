<?php

if (file_exists(dirname(__FILE__).'/SSI.php') && !defined('SMF')) {
  require_once(dirname(__FILE__.'/SSI.php'));
}
else if (!defined('SMF')) {
  die ('<strong>Unable to install:</strong> Please make sure that you have copied this file in the same location as the index.php of your SMF.');
}

?>
