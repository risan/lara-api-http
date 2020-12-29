<?php

namespace Risan\LaraApiHttp;

use Illuminate\Http\JsonResponse;

trait JsonResponses
{
    public function json($data = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    public function jsonData($data = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->json(['data' => $data], $status, $headers, $options);
    }

    public function jsonDataAndMessage($data = null, string $message = 'Ok', int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], $status, $headers, $options);
    }

    public function jsonCreated($data = null, string $message = 'Resource is created.', array $headers = [], int $options = 0): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], 201, $headers, $options);
    }

    public function jsonUpdated($data = null, string $message = 'Resource is updated.', array $headers = [], int $options = 0): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], 200, $headers, $options);
    }

    public function jsonDeleted($data = null, string $message = 'Resource is deleted.', array $headers = [], int $options = 0): JsonResponse
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], 200, $headers, $options);
    }
}
