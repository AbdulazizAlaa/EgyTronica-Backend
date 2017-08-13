<?php

use Dingo\Api\Routing\Router;
use App\User;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->post('contactus/create', 'App\\Api\\V1\\Controllers\\ContactController@create');

    $api->get('email/{token}', 'App\\Api\\V1\\Controllers\\EmailValidationController@validation');

    $api->get('events', 'App\\Api\\V1\\Controllers\\EventsController@index');
    $api->get('news', 'App\\Api\\V1\\Controllers\\NewsController@index');
    $api->get('news/{id}', 'App\\Api\\V1\\Controllers\\NewsController@show');

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {

        //user apis
        $api->put('users/registration_id', 'App\\Api\\V1\\Controllers\\UserController@update_registration_id'); //setting the mobile registration id

        //board apis
        $api->post('boards', 'App\\Api\\V1\\Controllers\\BoardController@create');
        $api->get('boards', 'App\\Api\\V1\\Controllers\\BoardController@index');
        $api->get('member/boards', 'App\\Api\\V1\\Controllers\\BoardController@member_boards');
        $api->get('boards/{id}', 'App\\Api\\V1\\Controllers\\BoardController@show');
        //apis for updates from hardware
        $api->put('boards/{board_code}', 'App\\Api\\V1\\Controllers\\BoardController@update');

        //board components apis
        $api->post('boards/{id}/components', 'App\\Api\\V1\\Controllers\\BoardComponentsController@create_component');
        $api->get('boards/{id}/components', 'App\\Api\\V1\\Controllers\\BoardComponentsController@show_components');
        $api->get('boards/{board_code}/components/{component_name}', 'App\\Api\\V1\\Controllers\\BoardComponentsController@show_component');
        $api->put('boards/{board_id}/components/{component_id}/control', 'App\\Api\\V1\\Controllers\\BoardComponentsController@control_component');
        //apis for updates from hardware
        $api->put('boards/{board_code}/components/{component_name}', 'App\\Api\\V1\\Controllers\\BoardComponentsController@update');

        //board members apis
        $api->post('boards/{id}/members', 'App\\Api\\V1\\Controllers\\BoardMembersController@create_member');
        $api->delete('boards/{board_id}/members/{member_id}', 'App\\Api\\V1\\Controllers\\BoardMembersController@delete_member');
        $api->get('boards/{id}/members', 'App\\Api\\V1\\Controllers\\BoardMembersController@show_members');

        //mobile pin apis
        $api->post('mobile/verify', 'App\\Api\\V1\\Controllers\\MobilePinController@validation');
        $api->get('mobile/resend', 'App\\Api\\V1\\Controllers\\MobilePinController@resend');

        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to this item is only for authenticated user. Provide a token in your request!'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);
    });

    $api->get('images/{filename}', function ($filename){

        $path = storage_path() . '/images/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });


    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
