<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Services\JwtManager\Contracts\JwtManagerServiceInterface;
use App\Services\TokenService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        auth()->viaRequest('api', [$this, 'getUserFromRequest']);
    }


    /**
     * Custom HTTP request based authentication system
     * more info on: https://laravel.com/docs/9.x/authentication#closure-request-guards
     *
     * @param Request $request
     * @return User|null
     * @throws BindingResolutionException
     */
    public function getUserFromRequest(Request $request) : ?User
    {

        $tokenService = app()->make(TokenService::class);

        if ($request->has('api-key')) {
            return $tokenService->getUserFromToken($request->get('api-key'));
        }

        return null;
    }

}
