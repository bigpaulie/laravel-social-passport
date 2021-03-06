<?php

namespace Bigpaulie\Laravel\Social\Passport;

use Bigpaulie\Laravel\Social\Passport\Grants\PassportTwitterGrant;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\AuthorizationServer;

/**
 * Class TwitterPassportProvider
 * @package bigpaulie\laravel\passport\social
 */
class TwitterPassportProvider extends PassportServiceProvider
{

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/social.php' => config_path('social.php'),
        ]);
        app(AuthorizationServer::class)->enableGrantType($this->buildRequestGrant(),
            Passport::tokensExpireIn());
    }

    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        parent::register();
    }

    /**
     * Build Grant.
     * @return PassportTwitterGrant
     */
    private function buildRequestGrant()
    {
        $grant = new PassportTwitterGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}