<?php

namespace Paymaster;

use Paymaster\Interfaces\ResponseInterface;

/**
 * Класс, предоставляет собой единый интерфейс для обработки результатов запроса.
 *
 * Class Response
 */
class Response implements ResponseInterface
{
    private $isSuccess;
    private $code;
    private $data;
    private $error;
    private $errorResourceKey;
    private $errorByCode = null;

    private function getErrorCodes()
    {
        return [
            'Ok',
            'InvalidHash',
            'WrongParams',
            'InternalError',
            'SmallDeposit',
            'SendingMailError',
            'WrongConfirmationCode',
            'AccessDenied',
            'WrongAmount',
            'UserNotFound',
            'WrongUser',
            'ContractNotFound',
            'DealNotFound',
            'UnsupportedLoginProvider',
            'TransactionNotFound',
            'UsersEqual',
            'EmailIsAlreadyUsed',
            'LoginIsAlreadyUsed',
            'WrongUserAction',
            'WrongPassword',
            'UserIsNotConfirmed',
            'ContractIsExpired',
            'UnavailableCurrency',
            'PayError',
            'DealIsExpired',
            'WrongPurse',
            'WrongPurseType',
            'PurseError',
            'WrongContractDuration',
            'WrongDealDuration',
            'EmptyName',
            'UserIsInactive',
            'DealNotCreated',
            'PurseIsAlreadyAdded',
            'PaymethodIsNotAvailable',
            'ValidationError',
            'ContractIsClosed',
            'DealIsClosed',
            'DealIsDisputed',
            'EmailShouldBeAddedToAnExternalAccount',
            'RequestNotFound',
            'SimilarRequestAlreadyExsists',
            'AnonymousUsersCannotAcceptContracts',
            'OnlyAnonymousUserCanBeReplaced',
            'DealProlongationTooLong',
            'AgreementFieldError',
            'WrongPhoneNumber',
            'WrongWmid',
            'WrongEmail',
            'TxIdIsNull',
            'RequestEmpty',
            'FileOverwieght',
            'WrongExtension',
            'PurseWmDoNotExist',
            'CardNotFound',
            'IdentificationRequired',
            'UserAlreadyInvoiced',
            'PaymentSystemUnavailable',
            'PurseIsNull',
            'InvalidCaptcha',
            'ErrorWhileProlong',
            'PassportExists',
            'CommissionTypeRestricted',
            'ContractAlreadyAccepted',
            'WaitingSrpValidation',
            'CodeExpired',
            'TokenBlocked',
            'TokenUsed',
            'AdminCustom',
        ];
    }

    public function __construct($data)
    {
        $this->isSuccess = $data['IsSuccess'];
        $this->code = $data['Code'];
        $this->errorByCode = $this->getErrorByCode();
        if (array_key_exists('Data', $data)) {
            $this->data = $data['Data'];
        }
        $this->error = $data['Error'];
        $this->errorResourceKey = $data['ErrorResourceKey'];
    }

    /**
     * @return string
     */
    public function getErrorByCode()
    {
        if (is_null($this->errorByCode)) {
            if (intval($this->code) > 0) {
                $codes = $this->getErrorCodes();
                $code = $this->code - 1;
                $this->errorByCode = $codes[$code] ?? 'undefined error';
            }
        }

        return (string) $this->errorByCode;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getErrorResourceKey()
    {
        return $this->errorResourceKey;
    }
}
