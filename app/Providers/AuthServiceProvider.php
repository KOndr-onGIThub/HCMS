<?php

namespace App\Providers;

use Auth;
use App\Authentication\LocalUserProvider;
use Illuminate\Support\Facades\Gate;
use App\Authentication\CustomUserProvider;
use App\Authentication\TpcaGuard;
use App\Authentication\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Role;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
//    public function boot()
//    {
//
//        // zaregistrujeme prihlasovani pomoci TPCA Usera
//        Auth::provider('tpcaProvider', function ($app, array $config) {
//            return new CustomUserProvider($app);
//        });
//
//
//        // pridame guard pro overeni uzivatele
//        Auth::extend('tpca', function ($app, $name, array $config) {
//            return new TpcaGuard(
//                $name,
//                Auth::createUserProvider($config['provider']),
//                $app['session.store'],
//                $app->make('request')
//            );
//        });
//
//        $this->registerPolicies();
//    }
    public function boot() {
        $this->registerPolicies();

        Auth::provider('tpcaProvider', function ($app, array $config) {
            return new CustomUserProvider($app);
        });

        Auth::extend('tpca', function ($app, $name, array $config) {
            return new TpcaGuard(
                    $name, Auth::createUserProvider($config['provider']), $app['session.store'], $app->make('request')
            );
        });

        Gate::define('send-hotcall', function () {
            return Role::getInstance()->isAdmin() || Role::getInstance()->isLog_kbr() || Role::getInstance()->isLog_leaders();
        });
//        Gate::define('deliver-hotcall', function () {
//            return Role::getInstance()->isAdmin() || Role::getInstance()->isLog_kbr() || Role::getInstance()->isDelivery_boy() ;
//        });
//        Gate::define('view-seznam-zamestnancu', function () {
//            return Role::getInstance()->isHrAdmin() || Role::getInstance()->isHrPartner();
//        });
//        Gate::define('edit-seznam-zamestnancu', function () {
//            return Role::getInstance()->isHrAdmin() || Role::getInstance()->isHrPartner();
//        });
//        Gate::define('view-seznam-hodnotitelu', function () {
//            return Role::getInstance()->isHrAdmin() || Role::getInstance()->isHrPartner();
//        });
//        Gate::define('edit-ovladat-hodnoceni', function () {
//            return Role::getInstance()->isHrAdmin();
//        });
//        Gate::define('edit-evidence', function () {
//            return Role::getInstance()->isHrAdmin();
//        });
    }
    /** DEFINICE OBECNYCH ACL POLITIK PRO OBRAZOVKY */
    public function registerPolicies()
    {
        Gate::define('see-anything', function (User $oUser) {
            $this->requireAuthUser();
            $aRoles = $oUser->getARoles();
//            dd($oUser);
            if (is_array($aRoles) && count($aRoles) > 0) {
                return true;
            }

            return false;
        });

        Gate::define('edit-configs', function (User $oUser) {
            $this->requireAuthUser();
            $aRoles = $oUser->getARoles();
//            dd($oUser);
            if(is_array($aRoles) && count($aRoles) > 0 && in_array("admin", $aRoles)) {
                return true;
            }

            return false;
        });

    }


    public function requireAuthUser()
    {
        if ($_SERVER['AUTH_USER'] === "") {
            header('HTTP/1.1 401 Unauthorized');
            header('WWW-Authenticate: Negotiate');
            header('WWW-Authenticate: NTLM', false);
            exit;
        }
    }

}
