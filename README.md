XenForo UrlRewriter
===================

UrlRewriter is a XenForo application to allow forum owners to enable auto media embed functionality and to implement affiliate schemes.

XenForo `[url]` tags are rewritten at the time of render, which adds a slight processing overhead (whilst XenForo does not have a post_parsed cache) but does mean that the underlying post is unmodified = this application will not edit anything in your database and is guaranteed to be non-damaging in any way.

Supported Sites
---------------

To install:

1. Upload the UrlRewriter directory into your XenForo /library/ directory on your web server.
2. In your Admin Dashboard under Home > Add-ons > Install Add-on, browse to the addon_UrlRewriter.xml and click "Install Add-on".

To test that it's working, just create a post on the forum with this URL in the body:

    http://www.youtube.com/watch?v=U0CGsw6h60k

Supported Sites
---------------
  
Currently Supported Site - Test URL:
*  Affiliate Schemes
*  *  Amazon (all countries) - `http://www.amazon.co.uk/Lighted-Leather-Burgundy-Display-Generation/dp/B003DZ166Q/ref=br_lf_m_1000425123_1_3_ttl?ie=UTF8&s=electronics&pf_rd_p=217325627&pf_rd_s=center-3&pf_rd_t=1401&pf_rd_i=1000425123&pf_rd_m=A3P5ROKL5A1OLE&pf_rd_r=052A7YB9W01ZB6HXKBQQ`
*  *  eBay (pick a region) - `http://cgi.ebay.co.uk/Colnago-C40-full-Campagnolo-Record-carbone_W0QQitemZ130457071957QQcategoryZ98084QQcmdZViewItemQQ_trksidZp5197.m7QQ_trkparmsZalgo%3DLVI%26itu%3DUCI%26otn%3D2%26po%3DLVI%26ps%3D63%26clkid%3D5117350348837181446#ht_1164wt_881`
*  Maps and Fitness
*  *  Bikely  - `http://www.bikely.com/maps/bike-path/Princes-Risborough-80km`
*  *  Bikemap - `http://www.bikemap.net/route/714312`
*  *  Every Trail - `http://www.everytrail.com/view_trip.php?trip_id=723506`
*  *  Garmin Connect - `http://connect.garmin.com/activity/55877482`
*  *  GPSies - `http://www.gpsies.com/map.do?fileId=ckhtmmzhuivpjgdi`
*  Audio
*  *  Sound Cloud - `http://soundcloud.com/ronniepollock/dysfunctional-tb303-dont-leave-me-tonight`
*  Video
*  *  YouTube HD - `http://www.youtube.com/watch?v=U0CGsw6h60k&hd=1`
*  *  YouTube - `http://www.youtube.com/watch?v=U0CGsw6h60k`
*  *  YouTube Short URL HD - `http://youtu.be/U0CGsw6h60k?hd=1`
*  *  YouTube Short URL - `http://youtu.be/U0CGsw6h60k`

### Affiliate Replacements

Currently for the affiliate schemes you will need to edit the replacements found within the /UrlRewriter/BbCode/Formatter/Base.php file to insert your tracking tag.

When this addon has matured a little an interface will be provided for you to do this without having to edit the code.

The replacements for affiliates:

Within the **Amazon** replacement:

> Change the URL tag 'buro9' to your Amazon tracking code.

Within the **eBay** replacement:

There are a few bits you need to replace:

After "/rover/1/" you need to put in the Placement ID for your region, default is the UK eBay so you may need to change that:

    eBay AU = 705-53470-19255-0
    eBay BE = 1553-53471-19255-0
    eBay CA = 706-53473-19255-0
    eBay ES = 1185-53479-19255-0
    eBay FR = 709-53476-19255-0
    eBay HK = 3422-53475-19255-0
    eBay IN = 4686-53472-19255-0
    eBay IT = 724-53478-19255-0
    eBay NL = 1346-53482-19255-0
    eBay SG = 3423-53474-19255-0
    eBay UK = 710-53481-19255-0
    eBay US = 711-53200-19255-0
    Half US = 8971-56017-19255-0

You need to change this bit to include your Campaign ID:

    campid=5336525415

Contributing
-------------------

Do you want to submit a URL rewrite definition for a site? Then this is what we need:

1) A regular expression that will take the URL and match URLs for your given site:

    http://www.gpsies.com/map.do\?fileId=([\w\d_-]+)

2) Some HTML to replace that with:

    <a href="[URL]">[NAME]</a><br /><iframe src="http://www.gpsies.com/mapOnly.do?fileId=${1}" width="[WIDTH]" height="[HEIGHT]" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>

You have at your disposal these values:

*   [URL] = The original pre-processed URL
*   [NAME] = The bit of text that would've appeared between the <a> tags </a>.
*   [WIDTH] = The hard-coded default width for all embeds = 425
*   [HEIGHT] = The hard-coded default height for all embeds = 300

3) An example test URL:

    http://www.gpsies.com/map.do?fileId=ckhtmmzhuivpjgdi

Send this information to david@buro9.com with the subject "XenForo UrlRewriter Definition".