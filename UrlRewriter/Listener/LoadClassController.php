<?php
class UrlRewriter_Listener_LoadClassController {
  public static function loadClassListener($class, &$extend) {
    if ($class == 'XenForo_BbCode_Formatter_Base') {
      $extend[] = 'UrlRewriter_BbCode_Formatter_Base';
    }
  }
}
?>
