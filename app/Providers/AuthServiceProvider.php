<?php

namespace App\Providers;

use App\Order;
use App\User;
use Hash;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
     * The default error message if a gate fails, overwrite in gates
     */
    private $message = 'Deze actie is niet toegestaan';

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Implicitly grant "Super Admin" role all permission
         * when Response::deny has not yet been returned in the gates before
         */
        Gate::after(fn(User $user) => $user->hasRole('super-admin') ? true : Response::deny($this->message));

        Gate::define('manage-roles', function (User $user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
            $this->message = 'Je kunt geen rollen beheren';
        });

        /**
         * General manage capability
         */
        Gate::define('manage', function (User $user) {
            if ($user->hasRole('admin')) {
                return true;
            }
            $this->message = 'Je kunt deze actie alleen als beheerder uitvoeren';
        });

        Gate::define('make-admin', function (User $user, User $otherUser) {
            // Only dissalow when the other user is a super admin,
            // else return null which means super-admin true, else false
            if ($otherUser->hasRole('super-admin')) {
                return false;
            }
        });

        Gate::define('destroy-user', function (User $user, User $otherUser) {
            $this->message = 'Deze gebruiker kan je niet veranderen';

            // Super admins can't be destroyed
            if ($otherUser->hasRole('super-admin')) {
                return Response::deny('Hoofdgebruikers kunnen niet verwijderd worden');
            }

            // Users can destroy themselves
            if ($user->id === $otherUser->id) {
                return true;
            }

            // Admins can't destroy other admins
            if ($otherUser->hasRole('admin') && !$user->hasRole('super-admin')) {
                $this->message = 'Beheerders kunnen geen andere beheerders verwijderen';
                return null;
            } else {
                return true;
            }
        });

        Gate::define('update-user', function (User $user, User $otherUser) {
            $this->message = 'Deze gebruiker kan je niet veranderen';

            // Super admins can't be edited by other people
            if (!$user->hasRole('super-admin') && $otherUser->hasRole('super-admin')) {
                return null;
            }

            // Users can update themselves
            if ($user->id === $otherUser->id) {
                return true;
            }

            // Admins can't update other admins
            if ($otherUser->hasRole('admin') && !$user->hasRole('super-admin')) {
                $this->message = 'Beheerders kunnen geen andere beheerders veranderen';
                return null;
            } else {
                return true;
            }
        });

        /**
         * Check old password and only allow updating if that matches
         */
        Gate::define('change-password', function (User $user, string $old_password) {
            $this->message = 'Wachtwoorden komen niet overeen';
            if (Hash::check($old_password, $user->password)) {
                return true;
            } else {
                return Response::deny($this->message);
            }
        });

        /**
         * Orders can be viewed if the user has placed them or if the user is an admin
         */
        Gate::define('view-order', function (User $user, Order $order) {
            if ($user->id === $order->user_id || $user->hasRole('admin')) {
                return true;
            }
            $this->message = 'Deze bestelling kan je niet bekijken';
        });

        Gate::define('see-private-galleries', function (?User $user) {
            if ($user && $user->hasAnyRole(['member', 'admin'])) {
                return true;
            }
        });
    }
}
