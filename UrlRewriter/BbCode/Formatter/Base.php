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
          array('[URL]', '[CACHEBUSTER]', '[NAME]', '[WIDTH]', '[HEIGHT]'),
          array($url, rand(0, 10000000), $name, 425, 350),
          $html
        );
        $text = $html;
      }
    }

    return $text; 
  }

  protected $_find = array(
    '~http://([a-z\.]+\.)?amazon\.([a-z\.]+)/([\w-]+/)?(dp|gp/product|exec/obidos/asin)/(\w+/)?(\w{10}).*~', // Amazon Affiliate
    '~http://www.bikely.com/maps/bike-path/([\w\d_-]+)~', // Bikely
    '~http://www.bikemap.net/route/(\d+)~', // Bikemap
    '~https?://([a-qs-z][a-z\.]+\.)?ebay\.([a-z\.]+)/.*~', // eBay
    '~http://www.everytrail.com/view_trip.php\?trip_id=(\d+)~', // Every Trail
    '~http://connect.garmin.com/activity/(\d+)~', // Garmin Connect
    '~http://www.gpsies.com/map.do\?fileId=([\w\d_-]+)~', // GPSies
    '~http://soundcloud\.com/[\w-]+/[\w-]+~', // Soundcloud
    '~http://(www\.)?youtube\.com/watch\?v=([^&]+)&(amp;)?hd=1~', // YouTube HD
    '~http://(www\.)?youtube\.com/watch\?v=([^&]+)~', // YouTube
    '~http://youtu\.be/([^?]+)?hd=1~', // YouTube Short HD
    '~http://youtu\.be/([^&]+)~', // YouTube Short
  );

  protected $_replace = array(
    '<a href="http://$1amazon.${2}/gp/product/${6}?tag=buro9&creativeASIN=${6}">[NAME]</a>', // Amazon Affilate - Replace 'buro9' with your affiliate tag
    '<a href="[URL]">[NAME]</a><br /><iframe id="rmiframe" style="height:[HEIGHT]px;background:#eee;" width="100%" frameborder="0" scrolling="no" src="http://www.bikely.com/maps/bike-path/${1}/embed/1"></iframe>', // Bikely
    '<a href="[URL]">[NAME]</a></br><iframe width="[WIDTH]" height="[HEIGHT]" frameborder="0" src="http://www.bikemap.net/route/${1}/widget?width=[WIDTH]&height=[HEIGHT]&extended=true&maptype=2&unit=miles&redirect=no"></iframe>', // Bikemap
    '<a href="http://rover.ebay.com/rover/1/710-53481-19255-0/1?campid=5336525415&amp;toolid=10001&amp;mpre=${0}">[NAME]</a><img style="text-decoration:none;border:0;padding:0;margin:0;" src="http://rover.ebay.com/roverimp/1/710-53481-19255-0/1?pub=5574889051&toolid=10001&campid=5336525415&mpt=[CACHEBUSTER]">', // eBay
    '<a href="[URL]">[NAME]</a><br /><iframe src="http://www.everytrail.com/iframe2.php?trip_id=${1}&width=[WIDTH]&height=[HEIGHT]" marginheight="0" marginwidth="0" frameborder="0" scrolling="no" width="[WIDTH]" height="[HEIGHT]"></iframe>', // Every Trail
    '<a href="[URL]">[NAME]</a><br /><iframe width="[WIDTH]" height="[HEIGHT]" frameborder="0" src="http://connect.garmin.com/activity/embed/${1}"></iframe>', // Garmin Connect
    '<a href="[URL]">[NAME]</a><br /><iframe src="http://www.gpsies.com/mapOnly.do?fileId=${1}" width="[WIDTH]" height="[HEIGHT]" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>', // GPSies
    '<object height="81" width="100%"><param name="movie" value="http://player.soundcloud.com/player.swf?g=bb&amp;url=[URL]"></param><param name="allowscriptaccess" value="always"></param><embed allowscriptaccess="always" height="81" src="http://player.soundcloud.com/player.swf?g=bb&amp;url=[URL]" type="application/x-shockwave-flash" width="100%"></embed></object> <a href="[URL]">[NAME]</a>', // Soundcloud
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${2}?fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${2}?fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]"></embed></object>', // YouTube HD
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${2}?fs=1&amp;hl=en_GB&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${2}?fs=1&amp;hl=en_GB&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]"></embed></object>', // YouTube
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${1}?fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${1}?fs=1&amp;hl=en_GB&amp;rel=0&amp;hd=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]"></embed></object>', // YouTube Short HD
    '<object width="[WIDTH]" height="[HEIGHT]"><param name="movie" value="http://www.youtube.com/v/${1}?fs=1&amp;hl=en_GB&amp;rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/${1}?fs=1&amp;hl=en_GB&amp;rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="[WIDTH]" height="[HEIGHT]"></embed></object>', // YouTube Short
  );
}
?>
