<?php

if (!function_exists("toApiResponse")) {
    function toApiResponse(bool $status, string $message, Illuminate\Http\Resources\Json\JsonResource | array $data = [], array $errors = []): array
    {
        return [
            "status" => $status,
            "message" => $message,
            "data" => $data,
            "errors" => $errors
        ];
    }
}
