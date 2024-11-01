<?php

namespace App\Traits;

use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Trait ApiReturnFormatTrait
 *
 * This trait provides methods for formatting API responses with success or error messages.
 *
 * @package App\Traits
 */
trait ApiReturnFormatTrait
{
    /**
     * Return a JSON response.
     *
     * @param string $status The status of the response.
     * @param mixed|null $data The data to include in the response.
     * @param string $message The message to include in the response.
     * @param int $statusCode The HTTP status code for the response.
     * @return JsonResponse The JSON response.
     */
    function apiJsonResponse(string $status = 'success', mixed $data = null, string $message = '', int $statusCode = 200): JsonResponse
    {
        return response()
            ->json([
                'status' => $status,
                'data' => $data ?? [],
                'message' => $message
            ], $statusCode);
    }

    /**
     * Return a success response.
     *
     * @param string $message The success message.
     * @param array $data The data to include in the response.
     * @param int $code The HTTP status code for the response.
     * @return JsonResponse The JSON response.
     */
    protected function responseWithSuccess(string $message = "", mixed $data = [], int $code = 200): JsonResponse
    {
        $message = $message ?: __('Success');
        return $this->apiJsonResponse('success', $data, $message, $code);
    }

    /**
     * Return an error response.
     *
     * @param string $message The error message.
     * @param array $data The data to include in the response.
     * @param int $code The HTTP status code for the response.
     * @return JsonResponse The JSON response.
     */
    protected function responseWithError(string $message = '', mixed $data = [], int $code = 400): JsonResponse
    {
        $message = $message ?: __('Error');
        return $this->apiJsonResponse('error', $data, $message, $code ?: 400);
    }

    /**
     * Perform API request validation.
     *
     * @param Request $request
     * @param array $rule
     * @param array $attributes
     * @return bool|JsonResponse
     */
    function apiValidation(Request $request, array $rule = [], array $attributes = []): JsonResponse|bool
    {
        $validator = Validator::make($request->all(), $rule, $attributes);

        if ($validator->fails()) {
            return $this->apiJsonResponse('error', $validator->errors(), __('The given data was invalid'), 422);
        }

        return false;
    }

    /**
     * Check if the user exists and is active.
     *
     * @param User $user
     * @return bool|JsonResponse
     */
    protected function userCheck(User $user): JsonResponse|bool
    {
        if (blank($user)) {
            return $this->responseWithError(__('User not found.'), [], 404);
        } elseif ($user->status == GlobalConstant::STATUS_INACTIVE) {
            return $this->responseWithError(__('Your account is inactive.'), [], 403);
        }

        return true;
    }
}
