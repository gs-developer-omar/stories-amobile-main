<?php

namespace App\Exceptions\v1;

use App\Enums\api\v1\ERROR_TYPE;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptions
{
    public static array $handlers = [
        NotFoundHttpException::class => 'handleNotFoundHttpException',
        ModelNotFoundException::class => 'handleModelNotFoundException',
        ValidationException::class => 'handleValidationException',
    ];

    public static function handleNotFoundHttpException(NotFoundHttpException $e, Request $request): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'type' => ERROR_TYPE::HTTP_NOT_FOUND,
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => rtrim($e->getMessage(), '.'),
                ]
            ]
        ], Response::HTTP_NOT_FOUND);
    }

    public static function handleModelNotFoundException(ModelNotFoundException $e, Request $request): JsonResponse
    {
        $model = class_basename($e->getModel());
        return response()->json([
            'errors' => [
                [
                    'type' => ERROR_TYPE::HTTP_MODEL_NOT_FOUND,
                    'status' => Response::HTTP_NOT_FOUND,
                    'message' => "Модель {$model} не найдена",
                ]
            ]
        ], Response::HTTP_NOT_FOUND);
    }

    public static function handleValidationException(ValidationException $e, Request $request): JsonResponse
    {
        $errors = [];
        foreach ($e->errors() as $attributeErrors)
            foreach ($attributeErrors as $message) {
                $errors[] = [
                    'type' => ERROR_TYPE::HTTP_UNPROCESSABLE_ENTITY,
                    'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => rtrim($message, '.'),
                ];
            }

        return response()->json([
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}


