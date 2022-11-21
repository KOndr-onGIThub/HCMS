<?php

namespace App;

use Illuminate\Support\Facades\Auth;

class Role {

    private static $instance;
    protected $role;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        $this->roles = Auth::user() ? Auth::user()->getARoles() : [];
    }

    public function isAdmin() {
//        dd($this);
        return in_array('admin', $this->roles);
    }

    public function isDelivery_boy() {
        return in_array('delivery_boy', $this->roles);
    }

        public function isLog_kbr() {
        return in_array('log_kbr', $this->roles);
    }

    public function isLog_leaders() {
        return in_array('log_leaders', $this->roles);
    }

    public function isPc_spec() {
        return in_array('pc_spec', $this->roles);
    }    

}
