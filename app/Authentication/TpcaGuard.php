<?php
namespace App\Authentication;
 
use Illuminate\Http\Request;
use Illuminate\Support\Traits\Macroable;
use \Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use \Illuminate\Auth\GuardHelpers;
use \Illuminate\Contracts\Session\Session;

class TpcaGuard implements Guard
{
    use GuardHelpers, Macroable;
    
    protected $name;
    protected $provider;
    protected $session;
    protected $request;
    protected $cookie;
    protected $user;
    protected $loggedOut;

    /**
     * Create a new authentication guard.
     *
     * @param  string  $name
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Contracts\Session\Session  $session
     * @param  \Symfony\Component\HttpFoundation\Request|null  $request
     * @return void
     */
    public function __construct(
        $name,
        UserProvider $provider,
        Session $session,
        Request $request = null
    ) {
        $this->name = $name;
        $this->session = $session;
        $this->request = $request;
        $this->provider = $provider;
    }
    
    
    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        // pokud uz je nacteny, vrat ho
        if (! is_null($this->user)) {
            return $this->user;
        }
                
        //pokud je v session, nacti ho
        $user = $this->session->get($this->getName());
        $oUser = unserialize($user);
        if (is_a($oUser, "App\Authentication\User") && !empty($oUser->getDn())) {
            $this->user = $oUser;
            return $this->user;
        }
        
        //pokud není načtený, zkus ho automaticky načíst
        if (is_null($this->user)) {
            if (!in_array($this->request->path(), ["logout", "login"])) {
                $this->user = $this->provider->retrieveById("");
                if (!is_null($this->user)) {
                    //pokud se ho podařilo načíst, ulož si ho
                    $this->updateSession($this->user);
                }
            }
        }

        return $this->user;
    }

    /* Ověření uživatele */
    public function authenticate()
    {
        if (is_null($this->user())) {
            $oUser = $this->provider->retrieveById("");
            $this->setUser($oUser);
        }
        
        return ! is_null($this->user());
    }
    
      
    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return ! $this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return string|null
    */
    public function id()
    {
        if ($user = $this->user()) {
            return $this->user()->getAuthIdentifier();
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $oLarUser = $this->provider->retrieveByCredentials($credentials);
        $this->setUser($oLarUser);

        return !is_null($this->user());
    }

    /**
     * Set the current user.
     *
     * @param  Array $user User info
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
        return $this;
    }
        
    
    public function logout()
    {
        $this->user = null;
        $this->clearUserDataFromStorage();
    }

    public function attempt(array $credentials = array(), $remember = false): bool
    {
        $user = $this->provider->retrieveByCredentials($credentials);
        if ($this->hasValidCredentials($user, $credentials)) {
            $this->login($user, $remember);

            return true;
        }
        
        return false;
    }
    
    /**
     * Determine if the user matches the credentials.
     *
     * @param  mixed  $user
     * @param  array  $credentials
     * @return bool
     */
    protected function hasValidCredentials($user, $credentials)
    {
        return ! is_null($user) && $this->provider->validateCredentials($user, $credentials);
    }
    
    
    
    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  bool  $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        $this->updateSession($user);

        $this->setUser($user);
    }
    
    
    /**
     * Update the session with the given ID.
     *
     * @param  User $user
     * @return void
     */
    protected function updateSession($user)
    {
        $this->session->put($this->getName(), serialize($user));
        $this->session->migrate(true);
    }
    
     /**
     * Remove the user data from the session and cookies.
     *
     * @return void
     */
    protected function clearUserDataFromStorage()
    {
        $this->session->put($this->getName(), null);
        $this->session->remove($this->getName());
    }
        
    
    /**
     * Get the session store used by the guard.
     *
     * @return \Illuminate\Contracts\Session\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Return the currently cached user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return 'login_'.$this->name.'_'.sha1(static::class);
    }
}
