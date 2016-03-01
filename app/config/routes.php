<?php
use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use SierraSql\App;
/*
    Config file to define application routes.

    "Controller-style" routes should be of the form 'Namespace\ClassName::methodName'
    and don't necessarily have to use a "controller" as typically found in MVC architecture

    In general, each report should have a data model defined in SierraSql\Model\<ReportName>Model.php,
    a route path defined in this file as /<ReportName>, and a corresponding 
    SierraSql\Controller\<ReportName>Controller.php.  
*/



return array(
    'routes' => array(
        // Controller-style Route
        array(
            'verb' => 'GET',
            'path' => '/',
            'action' => 'SierraSql\Controller\MainController::index'
        ),         
        array(
            'verb' => 'GET',
            'path' => '/payments',
            'action' => 'SierraSql\Controller\PaymentsController::show'
        ),  
        array(
            'verb' => 'GET',
            'path' => '/payments/{start}/{end}',
            'action' => 'SierraSql\Controller\PaymentsController::show'
        ),  
        array(
            'verb' => 'GET',
            'path' => '/payments/download',
            'action' => 'SierraSql\Controller\PaymentsController::download'
        ), 
        array(
            'verb' => 'GET',
            'path' => '/payments/download/{start}/{end}',
            'action' => 'SierraSql\Controller\PaymentsController::download'
        ),        
        array(
            'verb' => 'POST',
            'path' => '/payments',
            'action' => 'SierraSql\Controller\PaymentsController::customDates'
        ),      
/*        array(
            'verb' => 'GET',
            'path' => '/patrons',
            'action' => 'SierraSql\Controller\PatronsController::show'
        ),
         array(
            'verb' => 'GET',
            'path' => '/patrons/download',
            'action' => 'SierraSql\Controller\PatronsController::download'
        ),
 */     array(
            'verb' => 'GET',
            'path' => '/patrons/duplicates',
            'action' => 'SierraSql\Controller\PatronsController::duplicates'
        ), 
        array(
            'verb' => 'GET',
            'path' => '/patrons/duplicates/download',
            'action' => 'SierraSql\Controller\PatronsController::duplicatesDownload'
        ),       
        // // Callback-style Route
        // array(
        //     'verb' => 'GET',
        //     'path' => '/',
        //     'action' => function(Request $request, Response $response) {

        //         $response->setContent("You are on the home page");
        //         $response->setStatusCode(200);

        //         return $response;
        //     }
        // )
    )
);