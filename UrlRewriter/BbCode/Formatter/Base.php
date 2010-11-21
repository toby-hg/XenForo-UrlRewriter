<?php
class UrlRewriter_BbCode_Formatter_Base extends XFCP_UrlRewriter_BbCode_Formatter_Base {
  /**
   * Renders a URL tag.
   *
   * @param array $tag Information about the tag reference; keys: tag, option, children
   * @param array $rendererStates Renderer states to push down
   *
   * @return string Rendered tag
   */
  public function renderTagUrl(array $tag, array $rendererStates) {
    $text = parent::renderTagUrl($tag, $rendererStates);

    if(!strcmp(substr($text, 0, 8),'<a href="') === 0) {
      return $text;
    }

    $pattern = '/<a [^>]*href="(?<url>[^"]*)"[^>]*>(?<name>[^<]*)<\/a>/';
    if (preg_match($pattern, $text, $matches)) {
      $url = $matches['url'];
      $name = $matches['name'];

      $html = preg_replace($this->_find, $this->_replace, $url);

      if ($url !== $html) {
        $html = str_replace(
          array('[URL]', '[NAME]', '[WIDTH]', '[HEIGHT]'),
          array($url, $name, 425, 350),
          $html
        );
        $text = $html;
      }
    }

    return $text; 
  }

  protected $_find = array(
    '~http://[\w]+\.youtube\.[\w]+/watch\?v=([\w-]+)[\w&;=]*[\#t=]*([\d]*)s?~', // YouTube
    '~http://[\w]+\.youtube\.[\w]+/watch\?fmt=([18|22]+)&[amp;]*v=([\w-]+)[\w&;=]*[\#t=]*(\d*)s?~', // YouTube HD
    '~http://[\w]+\.youtube\.com/view_play_list\?p=([\w]+)~' // YouTube Playlist
  );

  protected $_replace = array(
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${1}&start=${2}"></param><param name="allowFullScreen" value="true"></param><embed src="http://www.youtube.com/v/${1}&start=${2}" type="application/x-shockwave-flash" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]" wmode="transparent"></embed></object>',
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${2}&hl=en&fs=1&rel=0&ap=%2526fmt%3D${1}&start=${2}"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${2}&hl=en&fs=1&rel=0&ap=%2526fmt%3D${1}&start=${2}" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]"></embed></object>',
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/p/${1}"></param><param name="background" value="transparent"></param><embed src="http://www.youtube.com/p/${1}" type="application/x-shockwave-flash" width="[WIDTH]" height="[HEIGHT]" wmode="transparent"></embed></object>'
  );
}
?>
