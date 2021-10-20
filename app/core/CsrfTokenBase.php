<?php


namespace App\core;


use Pecee\Http\Middleware\BaseCsrfVerifier;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\Http\Request;

class CsrfTokenBase extends BaseCsrfVerifier
{
    protected $except = [
        '/api/*'
    ];



    protected $include = [
        '/*',
        '/admin/*',
    ];

//    public function testSkip(\Pecee\Http\Request $request) {
//        return $this->skip($request);
//    }

    public function handle(Request $request): void
    {
        if ($this->skip($request) === false && $request->isPostBack() === true) {

            $token = $request->getInputHandler()->value(
                static::POST_KEY,
                $request->getHeader(static::HEADER_KEY),
                Request::$requestTypesPost
            );

            if ($this->tokenProvider->validate((string)$token) === false) {
//                throw new TokenMismatchException('Invalid CSRF-token.');
                echo "419";
                exit();
            }

        }

        // Refresh existing token
        $this->tokenProvider->refresh();
    }

}