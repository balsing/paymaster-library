<?php

namespace Paymaster;

use Paymaster\Methods\Authentication;
use Paymaster\Methods\Commissions;
use Paymaster\Methods\Contracts;
use Paymaster\Methods\Deals;
use Paymaster\Methods\PaymentAccounts;
use Paymaster\Methods\Profile;
use Paymaster\Methods\Registration;
use Paymaster\Methods\Users;
use Paymaster\Interfaces\TransportInterface;

/**
 * Class Methods.
 */
class Methods
{
    /**
     * @var TransportInterface
     */
    protected $transport;

    /**
     * @var Paymaster|null
     */
    protected $paymaster = null;
    /**
     * @var Authentication|null
     */
    protected $authentication = null;

    /**
     * @var Commissions|null
     */
    protected $commissions = null;

    /**
     * @var Contracts|null
     */
    protected $contracts = null;
    /**
     * @var Deals|null
     */
    protected $deals = null;
    /**
     * @var PaymentAccounts|null
     */
    protected $paymentAccounts = null;
    /**
     * @var Profile|null
     */
    protected $profile = null;
    /**
     * @var Registration|null
     */
    protected $registration = null;
    /**
     * @var Users|null
     */
    protected $users = null;

    /**
     * @return Authentication
     */
    public function getAuthentication()
    {
        if (is_null($this->authentication)) {
            $this->authentication = new Authentication($this->transport);
        }

        return $this->authentication;
    }

    /**
     * @return Commissions
     */
    public function getCommissions()
    {
        if (is_null($this->commissions)) {
            $this->commissions = new Commissions($this->transport);
        }

        return $this->commissions;
    }

    /**
     * @return Contracts
     */
    public function getContracts()
    {
        if (is_null($this->contracts)) {
            $this->contracts = new Contracts($this->transport);
        }

        return $this->contracts;
    }

    /**
     * @return Deals
     */
    public function getDeals()
    {
        if (is_null($this->deals)) {
            $this->deals = new Deals($this->transport);
        }

        return $this->deals;
    }

    /**
     * @return PaymentAccounts
     */
    public function getPaymentAccounts()
    {
        if (is_null($this->paymentAccounts)) {
            $this->paymentAccounts = new PaymentAccounts($this->transport);
        }

        return $this->paymentAccounts;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        if (is_null($this->profile)) {
            $this->profile = new Profile($this->transport);
        }

        return $this->profile;
    }

    /**
     * @return Registration
     */
    public function getRegistration()
    {
        if (is_null($this->registration)) {
            $this->registration = new Registration($this->transport);
        }

        return $this->registration;
    }

    /**
     * @return Users
     */
    public function getUsers()
    {
        if (is_null($this->users)) {
            $this->users = new Users($this->transport);
        }

        return $this->users;
    }
}
