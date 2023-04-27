<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ApiKey;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('X-API-KEY')) {
            return response()->json(['error' => 'API key missing.'], 401);
        }

        $apiKey = ApiKey::where('api_key', $request->header('X-API-KEY'))->first();

        if (!$apiKey) {
            return response()->json(['error' => 'Invalid API key.'], 401);
        }

        // Check permissions
        if (!$this->checkPermissions($request, $apiKey)) {
            return response()->json(['error' => 'Insufficient permissions.'], 403);
        }

        return $next($request);
    }

    private function checkPermissions(Request $request, ApiKey $apiKey)
    {
        $routeName = $request->route()->getName();

        $permissions = [
            'read'   => $apiKey->read_access,
            'write'  => $apiKey->write_access,
            'delete' => $apiKey->delete_access,
        ];

        switch ($request->getMethod()) {
            case 'GET':
                return $permissions['read'] || $permissions['write'];
                break;
            case 'POST':
                return $permissions['write'];
                break;
            case 'PUT':
            case 'PATCH':
                return $permissions['write'] || ($permissions['read'] && $routeName);
                break;
            case 'DELETE':
                return $permissions['delete'];
                break;
            default:
                return false;
        }
    }
}
