<?php

require_once 'includes/common.inc.php';




$page['css'][] = 'frame';
$page['js'][]  = 'frame';

require 'includes/header.inc.php';

?>
<h2>保存中...</h2>

...
<?php

// Flush everything so far cause the next command could take some time.
flush();

$redis->save();

?>
 完成.
<?php

require 'includes/footer.inc.php';

?>
