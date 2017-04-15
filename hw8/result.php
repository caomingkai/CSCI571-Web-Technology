<?php 
//    header('Access-Control-Allow-Origin: *'); 
    require_once __DIR__ . '/php-graph-sdk-5.0.0/src/Facebook/autoload.php'; 
    $fb = new Facebook\Facebook([
    'app_id' => '1723426561284149',
    'app_secret' => '047d902797c5d937e302868b10bde098',
    'default_graph_version' => 'v2.5', ]);

    $GLOBALS['fb']->setDefaultAccessToken('EAAYfcoP7WDUBAO0r4tnhZBSzZAw6VzlCNyVPyR82bSssXQZBA6KWk91d5IURb3DmJKuHDAMtZAHcZAh3fR3yJGWZC1ecZCyep1rmeCGYrt5ij7gkOWnRSZAl8qsIAzt99ZBqBWlGlrlyQdOdRklxTuAAAOdxwjeJh9lcZD');

    
    
    
//----------------- Search Request-------------------------------
//---------------------------------------------------------------

    if( isset( $_GET['kw'] ) && !isset( $_GET['detail']) ){
        
        $kw = $_GET['kw'];
        $lon = $_GET['long'];
        $lat = $_GET['lati'];
        
        if ($lat == 'undefined') {
            $httpFacebookPlace = "/search?q=" . $kw."&type=place&fields=id,name,picture.width(700).height(700)";
        }else{
             $httpFacebookPlace = "/search?q=".$kw."&type=place&fields=id,name,picture.width(700).height(700)&center=" . $lat  . "," . $lon;
        }
        
        $httpFacebookUser = "/search?q=" . $kw . "&type=user&fields=id,name,picture.width(700).height(700)";
        $httpFacebookPage = "/search?q=" . $kw . "&type=page&fields=id,name,picture.width(700).height(700)";
        $httpFacebookEvent = "/search?q=" . $kw. "&type=event&fields=id,name,picture.width(700).height(700)";
        $httpFacebookGroup = "/search?q=" . $kw. "&type=group&fields=id,name,picture.width(700).height(700)";

        try {
            $responseUser = $GLOBALS['fb']->get($httpFacebookUser);
            $responsePage = $GLOBALS['fb']->get($httpFacebookPage);
            $responseEvent = $GLOBALS['fb']->get($httpFacebookEvent);
            $responsePlace = $GLOBALS['fb']->get($httpFacebookPlace);
            $responseGroup = $GLOBALS['fb']->get($httpFacebookGroup);

            $itemObjArrayUser = $responseUser->getDecodedBody();
            $itemObjArrayPage = $responsePage->getDecodedBody();
            $itemObjArrayEvent = $responseEvent->getDecodedBody();
            $itemObjArrayPlace = $responsePlace->getDecodedBody();
            $itemObjArrayGroup = $responseGroup->getDecodedBody();

            $itemObjArray =  array( "user"   =>  $itemObjArrayUser,  
                                            "page"   =>  $itemObjArrayPage, 
                                            "event"  =>  $itemObjArrayEvent,
                                            "place"  =>  $itemObjArrayPlace, 
                                            "group"  =>  $itemObjArrayGroup );

            echo json_encode( $itemObjArray );

        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo json_encode( 'Facebook Graph returned an error in Search Request');
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo json_encode( 'Facebook SDK returned an error in Search Request' );
            exit;
        }
        
    }
       

    
//----------------- Detail Request-------------------------------
//---------------------------------------------------------------

    if( isset($_GET['detailId']) ){
        
        $detailId = $_GET['detailId'];
        
        $httpDetail = $detailId . "?fields=id,name,picture.width(700).height(700),albums.limit(5){name,photos.limit(2){name, picture}},posts.limit(5)";
        
        try {
             $responseDetail = $GLOBALS['fb']->get( $httpDetail );
             $DetailObj = $responseDetail->getDecodedBody();
             echo json_encode( $DetailObj );
        }
        catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
             echo json_encode( 'Facebook Graph returned an error in Detail request');
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo json_encode( 'Facebook SDK returned an error in Detail request' );
            exit;
        }
        
    }
        
    
?>


