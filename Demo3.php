 <?PHP
 class flipkartApi {
   
    private static $affiliateID;
    private static $token;
    private static $timeout = 45;
    //Set filpkart affilate id and token at the time of class init.
     public function __construct($affiliateID, $token) {
       self::$affiliateID = $affiliateID;
       self::$token = $token;
      }
     public static function getData($url, $dataType) {
         try {
         	if(!isset($url) && !empty($url)) {
         		throw new exception("URL is not available.");
         	}
         	if(!isset($dataType) && !empty($dataType)) {
         		throw new exception("Please set datatype json or xml");
         	}
         	if (!function_exists('curl_init')){
                throw new exception("Curl is not available.");
         	}
         	 // Set header to make authentication
	        $headers = array(
	            'Cache-Control: no-cache',
	            'Fk-Affiliate-Id: '.self::$affiliateID,
	            'Fk-Affiliate-Token: '.self::$token
	            );
	        $cObj = curl_init();
	        curl_setopt($cObj, CURLOPT_URL, $url);
	        curl_setopt($cObj, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($cObj, CURLOPT_TIMEOUT, self::$timeout);
	        curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($cObj);
	        curl_close($cObj);
             // render result as per format.
             if($dataType == 'json') {
               return $result ? json_decode($result, true) : false;
             } else if($dataType == 'xml') {
                return $result ? new SimpleXMLElement($result) : false;
             } else {
             	return false;
             }
         }  catch (Exception $e) {
            return $e->getMessage();
         }
     }
 }
 
            $affiliateID = 'prasadksh';
$token = '8919e8282e0448e7bd10c7eb35cd2c75';
$fkObj = new flipkartApi($affiliateID, $token);
// fetch flipkart offer
$offerJsonURL =  'https://affiliate-api.flipkart.net/affiliate/offers/v1/all/json';
$dotdJsonURL =  'https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
$result = flipkartApi::getData($offerJsonURL, 'json');
if(!$result) {
    	echo "<h3>There is no offer, Or Error on flipkart api server please contact to flipkart affiliate team..</h3>";
    }
?>
<title>FlipKart Affiliate API DEMO</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<style>
.glyphicon { margin-right:5px; }
.thumbnail
{
    margin-bottom: 20px;
    padding: 0px;
    -webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
}
.item.list-group-item
{
    float: none;
    width: 100%;
    background-color: #fff;
    margin-bottom: 10px;
}
.item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
{
    background: #428bca;
}
.item.list-group-item .list-group-image
{
    margin-right: 10px;
}
.item.list-group-item .thumbnail
{
    margin-bottom: 0px;
}
.item.list-group-item .caption
{
    padding: 9px 9px 0px 9px;
}
.item.list-group-item:nth-of-type(odd)
{
    background: #eeeeee;
}
.item.list-group-item:before, .item.list-group-item:after
{
    display: table;
    content: " ";
}
.item.list-group-item img
{
    float: left;
}
.item.list-group-item:after
{
    clear: both;
}
.list-group-item-text
{
    margin: 0 0 11px;
}
</style>

<div class="container">
<h1 style="text-align:center">FlipKart Affiliate API DEMO</h1>
    <div id="products" class="row list-group">

    <?php foreach($result['allOffersList'] as $resultSet) { 
  
?>
        <div class="item col-sm-6 col-md-3"  cat="<?= $resultSet['category']; ?>">
            <div class="thumbnail" >
                <img class="group list-group-image" src="<?= $resultSet['imageUrls'][1]['url']; ?>" alt="" style="height:200px; width:200px;" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?= $resultSet['title']; ?></h4>
                        <p><b> <?= str_replace('_', ' ',$resultSet['category']); ?></b></p>
                    <p class="group inner list-group-item-text">
                        <?= $resultSet['description']; ?></p>
                    <div class="row">
                       
                        <div class="col-xs-12 col-md-12">
                            <a class="btn btn-lg btn-success deal" target="_blank" style="width:100%" rel="nofollow, noindex" href="<?= $resultSet['url']; ?>"><b>GOTO FLIPKART</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php   } ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
            
