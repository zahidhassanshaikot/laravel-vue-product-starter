<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Format the response data consistently.
     *
     * @param bool $status The status of the response.
     * @param string $message The message for the response.
     * @param mixed $data The data to include in the response.
     * @param int $statusCode The HTTP status code for the response.
     * @return JsonResponse The formatted JSON response.
     */
    protected function formatResponse(bool $status, string $message, $data, int $statusCode): JsonResponse
    {
        $responseData = [
            'status'  => $status,
            'message' => $message,
            'data'    => $data
        ];
        if($data instanceof ResourceCollection) {
            $responseData['data'] = $data->response()->getData(true);
        }
        return Response::json($responseData, $statusCode);
    }

    /**
     * Returns a JSON response on success.
     *
     * @param string $message The success message. Defaults to 'Success'.
     * @param mixed $data The data to include in the response.
     * @param int $statusCode The HTTP status code for the response. Defaults to 200.
     * @return JsonResponse The JSON response.
     */
    public function successResponse(string $message = 'Success', $data = null, int $statusCode = 200): JsonResponse
    {
        return $this->formatResponse(true, $message, $data, $statusCode);
    }

    /**
     * Returns a JSON response with an error message.
     *
     * @param string $message The error message. Defaults to 'Error'.
     * @param int $statusCode The HTTP status code. Defaults to 500.
     * @param array $data Additional data to include in the response.
     * @return JsonResponse The JSON response.
     */
    public function errorResponse(string $message = 'Error', int $statusCode = 500, array $data = []): JsonResponse
    {
        return $this->formatResponse(false, $message, $data, $statusCode);
    }

    /**
     * Returns a JSON response for not found resources.
     *
     * @param string $message The message for not found resources.
     * @param int $statusCode The HTTP status code. Defaults to 404.
     * @param array $data Additional data to include in the response.
     * @return JsonResponse The JSON response.
     */
    public function notFoundResponse(string $message = 'Not Found', int $statusCode = 404, array $data = []): JsonResponse
    {
        return $this->formatResponse(false, $message, $data, $statusCode);
    }

    /**
     * Returns a JSON response for forbidden access.
     *
     * @param string $message The message for forbidden access.
     * @param int $statusCode The HTTP status code. Defaults to 403.
     * @param array $data Additional data to include in the response.
     * @return JsonResponse The JSON response.
     */
    public function forbiddenResponse(string $message = 'Forbidden', int $statusCode = 403, array $data = []): JsonResponse
    {
        return $this->formatResponse(false, $message, $data, $statusCode);
    }

    /**
     * Returns a JSON response for validation errors.
     *
     * @param string $message The validation error message. Defaults to 'Validation Error'.
     * @param int $statusCode The HTTP status code. Defaults to 422.
     * @param array $data Additional data to include in the response.
     * @return JsonResponse The JSON response.
     */
    public function validationErrorResponse(string $message = 'Validation Error', int $statusCode = 422, array|object $data = []): JsonResponse
    {
        return $this->formatResponse(false, $message, $data, $statusCode);
    }

    /**
     * Returns a JSON response for unauthorized access.
     *
     * @param string $message The message for unauthorized access. Defaults to 'Unauthorized'.
     * @param int $statusCode The HTTP status code. Defaults to 401.
     * @param array $data Additional data to include in the response.
     * @return JsonResponse The JSON response.
     */
    public function unauthorizedResponse(string $message = 'Unauthorized', int $statusCode = 401, array $data = []): JsonResponse
    {
        return $this->formatResponse(false, $message, $data, $statusCode);
    }

    /**
     * Validates the given request data against the specified rules and returns a JSON response with validation errors if the validation fails.
     *
     * @param Request $request The HTTP request object containing the data to be validated.
     * @param array $rules The validation rules to be applied to the request data.
     * @param array $attributes The custom attributes to be used in the validation error messages.
     * @return JsonResponse|bool Returns a JSON response with validation errors if the validation fails, otherwise returns false.
     */
    public function validateRequest(Request $request, array $rules, array $attributes = []): JsonResponse|bool
    {
        // Create a validator instance using the request data and validation rules
        $validator = Validator::make($request->all(), $rules, $attributes);

        // Check if the validation fails
        if ($validator->fails()) {

            // If validation fails, return a JSON response with validation errors
            return $this->validationErrorResponse(
                message: 'The given data was invalid',
                statusCode: 422,
                data: $validator->errors()->toArray()
            );
        }

        // If validation passes, return false
        return false;
    }


    // response code wise response
    public function customResponse($resData)
    {
        switch ($resData?->code) {
            case '200':
                return $this->successResponse(message:$resData?->message, data:$resData?->data);
                break;

            case '401':
                return $this->unauthorizedResponse(message:$resData?->message, data:$resData?->data);
                break;
            case '422':
                return $this->validationErrorResponse(message:$resData?->message, data:$resData?->data);
                break;
            case '403':
                return $this->forbiddenResponse(message:$resData?->message, data:$resData?->data);
                break;
            case '404':
                return $this->notFoundResponse(message:$resData?->message, data:$resData?->data);
                break;
            case '500':
                return $this->errorResponse(message:$resData?->message, data:$resData?->data);
                break;
            default:
                return $this->errorResponse(message:$resData?->message, statusCode:$resData?->code ?? 500, data:$resData?->data);
                break;
        }
    }
}
