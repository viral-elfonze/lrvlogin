<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MicrosoftGraphAuthenticate;
use App\Models\User;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph as MicrosoftGraph;
use Microsoft\Graph\Model;

class AuthController extends Controller
{
    public function redirectToMicrosoft()
    {

        $guzzle = new \GuzzleHttp\Client();

        $provider = new \TheNetworg\OAuth2\Client\Provider\Azure([
            'clientId' => env('MS_GRAPH_CLIENT_ID'),
            'clientSecret' => env('MS_GRAPH_CLIENT_SECRET'),
            'redirectUri' => env('MS_GRAPH_REDIRECT_URI'),
        ]);

        $authUrl = $provider->getAuthorizationUrl();
        session(['oauth2state' => $provider->getState()]);
        return redirect()->away($authUrl);
    }

    public function handleMicrosoftCallback(Request $request)
    {

        dump($request);
        $guzzle = new \GuzzleHttp\Client();
        $provider = new \TheNetworg\OAuth2\Client\Provider\Azure([
            'clientId' => env('MS_GRAPH_CLIENT_ID'),
            'clientSecret' => env('MS_GRAPH_CLIENT_SECRET'),
            'redirectUri' => env('MS_GRAPH_REDIRECT_URI'),
        ]);

        // Validate state
        $state = $request->session()->pull('oauth2state');
        dump($state);
        // dd();
        // if (empty($state) || ($state !== $request->input('state'))) {
        //     return redirect('/');
        // }

        // Get access token
        $token = $provider->getAccessToken('authorization_code', [
            'code' => $request->input('code'),
        ]);

        dump($token);
        dump($token->getValues());

        dump($token->getToken());
        $resourceOwner = $provider->getResourceOwner($token);
        dump($resourceOwner->data);
        dd("test");
        // Use Microsoft Graph SDK to interact with Microsoft Graph
        $graph = new Graph();
        $graph->setAccessToken($token->getToken());
        $me = $graph->createRequest('GET', '/me')->setReturnType(Model\User::class)->execute();
        dump($me->getDisplayName());
        dd($me);
        // Use $me->getDisplayName() or other properties for user viinfo
    }
}
