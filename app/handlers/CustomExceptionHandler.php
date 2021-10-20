<?php


namespace App\handlers;


use Exception;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;

class CustomExceptionHandler implements IExceptionHandler
{
    public function handleError(Request $request, Exception $error): void
    {
        if ($request->getUrl()->contains('/api')) {

            response()->json([
                'error' => $error->getMessage(),
                'code'  => $error->getCode(),
            ]);

        }

        /* The router will throw the NotFoundHttpException on 404 */
        if($error instanceof NotFoundHttpException) {

            response()->redirect('/not-found');

        }
        if ($error instanceof TokenMismatchException){
            echo "page 419";
            return;
        }

        throw $error;
    }
}