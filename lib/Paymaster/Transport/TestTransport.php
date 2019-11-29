<?php

namespace Paymaster\Transport;

use Paymaster\Interfaces\RequestInterface;
use Paymaster\Interfaces\ResponseInterface;
use Paymaster\Interfaces\TransportInterface;
use Paymaster\Request;
use Paymaster\Response;
use Paymaster\Methods\Base;

/**
 * Знает как сделать запрос
 *
 * Class Client
 */
class TestTransport implements TransportInterface
{
    const DEFAULT_OWNER_LOGIN = '+79091234567';
    const DEFAULT_RENTER_LOGIN = '+79000000000';
    const DEFAULT_USER_ID = '129001';
    const DEFAULT_CONTRACT_ID = '498765';
    const DEFAULT_DEAL_ID = '387000';
    const DEFAULT_SERVICE_ID = '123456';

    protected $token = null;

    public function request(RequestInterface $request): ResponseInterface
    {
        $url = $request->getUrl();

        switch ($url) {
            case Base::BASE_URL.'/api/authentication':
                $response = $this->authentication($request);
                break;
            case Base::BASE_URL.'/api/profile/payment-accounts':
            case Base::BASE_URL.'/api/profile/payment-accounts/1111':
                $response = $this->profilePaymentAccountsStub($request);
                break;
            case Base::BASE_URL.'/api/contracts':
                $response = $this->contracts($request);
                break;
            case Base::BASE_URL.'/api/registration/service-user':
                $response = $this->registration($request);
                break;
            case Base::BASE_URL.'/api/contracts/'.self::DEFAULT_CONTRACT_ID.'/accept':
                $response = $this->acceptContract($request);
                break;
            case Base::BASE_URL.'/api/contracts/7777/decline':
            case Base::BASE_URL.'/api/contracts/'.self::DEFAULT_CONTRACT_ID.'/decline':
                $response = $this->declineContract($request);
                break;
            case Base::BASE_URL.'/api/deals/get-by-contractId/'.self::DEFAULT_CONTRACT_ID:
                $response = $this->getContract($request);
                break;
            case Base::BASE_URL.'/api/deals/'.self::DEFAULT_DEAL_ID.'/open-dispute':
                $response = $this->openDispute($request);
                break;
            case Base::BASE_URL.'/api/deals/'.self::DEFAULT_DEAL_ID.'/confirm':
                $response = $this->confirm($request);
                break;
            case Base::BASE_URL.'/api/commissions/calculate-dynamic':
                $response = $this->calculateDynamic($request);
                break;
            default:
                $response = $this->returnError();
                break;
        }

        return $response;
    }

    public function setBearerToken(string $token): TransportInterface
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Заглушка для запросов по адресу https://guarantee.money/api/authentication .
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function authentication(RequestInterface $request)
    {
        $keys = ['UserLogin', 'Password'];
        $resultValidation = $this->validateKeys($request, $keys);
        if (false === $resultValidation) {
            return $this->returnError();
        }

        return new Response(
            [
                'IsSuccess' => true,
                'Code' => 0,
                'Data' => [
                    'AccessToken' => 'testAccessToken',
                    'TokenType' => 'bearer',
                    'ExpiresIn' => '86399',
                    'RefreshToken' => 'refreshToken',
                    'UserLogin' => 'Genesis',
                    'AccessIssued' => 'Tue, 15 Oct 2019 06:55:38 GMT',
                    'AccessExpires' => 'Wed, 16 Oct 2019 06:55:38 GMT',
                    'RefreshIssued' => 'Tue, 15 Oct 2019 06:55:38 GMT',
                    'RefreshExpires' => 'Wed, 16 Oct 2019 06:55:38 GMT',
                    'Roles' => [
                        0 => 'Admin',
                        1 => 'Service',
                    ],
                ],
                'Error' => null,
                'ErrorResourceKey' => '0_error_code',
                'Description' => null,
                'Advices' => null,
            ]
        );
    }

    /**
     * Заглушка для запросов по адресу https://guarantee.money/api/profile/payment-accounts .
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function profilePaymentAccountsStub(RequestInterface $request)
    {
        $checkToken = $this->checkToken();
        if (false === $checkToken) {
            return $this->returnError();
        }

        // получение БК
        if (Request::GET == $request->getMethod()) {
            $params = $request->getParams();
            if ($params['userLogin'] == htmlspecialchars(self::DEFAULT_OWNER_LOGIN)) {
                return new Response(
                    [
                        'IsSuccess' => true,
                        'Code' => 0,
                        'Data' => [
                            [
                                'CardHolder' => 'FirstNameOwner SecondNameOwner',
                                'CardMonth' => '01',
                                'CardYear' => '22',
                                'IsCardInfoFull' => false,
                                'Id' => 1111,
                                'Purse' => '4111111111111111',
                                'Currency' => 'RUB',
                                'Paymethod' => 'CardsTest',
                                'Guid' => '3CAB42E7-1150-4973-B542-7F0EE0D8448F',
                            ],
                        ],
                        'Error' => null,
                        'ErrorResourceKey' => '0_error_code',
                        'Description' => null,
                        'Advices' => null,
                    ]
                );
            } elseif ($params['userLogin'] == htmlspecialchars(self::DEFAULT_RENTER_LOGIN)) {
                return new Response(
                    [
                        'IsSuccess' => true,
                        'Code' => 0,
                        'Data' => [
                            [
                                'CardHolder' => 'FirstNameRenter SecondNameRenter',
                                'CardMonth' => '01',
                                'CardYear' => '22',
                                'IsCardInfoFull' => false,
                                'Id' => 2222,
                                'Purse' => '4111111111111111',
                                'Currency' => 'RUB',
                                'Paymethod' => 'CardsTest',
                                'Guid' => '8E39249F-2B68-44F3-81DB-1B1B967C297B',
                            ],
                        ],
                        'Error' => null,
                        'ErrorResourceKey' => '0_error_code',
                        'Description' => null,
                        'Advices' => null,
                    ]
                );
            } elseif (!array_key_exists('userLogin', $params)) {
                return new Response(
                    [
                        'IsSuccess' => false,
                        'Code' => 4,
                        'Data' => null,
                        'Error' => 'An error occurred while obtaining user profile',
                        'ErrorResourceKey' => '4_error_code',
                        'Description' => '',
                        'Advices' => null,
                    ]
                );
            }
        } elseif (Request::POST === $request->getMethod()) {
            // добавление БК
            $keys = ['UserLogin', 'Purse', 'Paymethod', 'Currency', 'CardHolder', 'CardMonth', 'CardYear'];
            $resultValidation = $this->validateKeys($request, $keys);
            if (false === $resultValidation) {
                return $this->returnError();
            }

            $cardNumber = $request->getData()['Purse'];
            if ('4000111122221234' === $cardNumber) {
                return new Response(
                    [
                        'IsSuccess' => true,
                        'Code' => 0,
                        'Data' => rand(1111, 9999),
                        'Error' => null,
                        'ErrorResourceKey' => '0_error_code',
                        'Description' => null,
                        'Advices' => null,
                    ]
                );
            }
        } elseif (Request::DELETE === $request->getMethod()) {
            // удаление БК
            $keys = ['UserLogin'];
            $resultValidation = $this->validateKeys($request, $keys);

            if (false === $resultValidation) {
                return $this->returnError();
            }

            $urlParts = explode('/', $request->getUrl());
            $paymasterId = end($urlParts);

            if ('1111' === $paymasterId) {
                return new Response([
                    'IsSuccess' => true,
                    'Code' => 0,
                    'Data' => $paymasterId,
                    'Error' => null,
                    'ErrorResourceKey' => '0_error_code',
                    'Description' => null,
                    'Advices' => null,
                ]);
            }
        }

        return $this->returnError();
    }

    /**
     * Заглушка для запросов по адресу https://guarantee.money/api/contracts .
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function contracts(RequestInterface $request)
    {
        $checkToken = $this->checkToken();
        if (false === $checkToken) {
            return $this->returnError();
        }
        if (Request::POST === $request->getMethod()) {
            $keys = [
                'UserLogin',
                'PartnerName',
                'Name',
                'InitiatorRole',
                'Description',
                'ContractDuration',
                'AllowNewConditions',
                'PublicContractsCount',
                'PayMethod',
                'Amount',
                'Currency',
                'CommissionsType',
                'DepositInitiator',
                'DepositPartner',
                'DepositToPayee',
                'DealDuration',
                'ServiceId',
                'Commission',
            ];
            $params = $request->getData();
            $resultValidation = $this->validateKeys($request, $keys);
            if (false === $resultValidation) {
                return $this->returnError();
            }

            return new Response(
                [
                    'IsSuccess' => true,
                    'Code' => 0,
                    'Data' => [
                        'Id' => self::DEFAULT_CONTRACT_ID,
                        'Name' => 'Тестовое предложение от имени арендатора',
                        'ServiceId' => self::DEFAULT_SERVICE_ID,
                        'Version' => 1,
                        'Initiator' => [
                            'Id' => 8001,
                            'UserLogin' => $params['UserLogin'],
                            'AvatarBase64' => null,
                            'FirstName' => null,
                            'Surname' => null,
                            'Patronymic' => null,
                            'AllowedPayMethods' => null,
                            'Scoring' => null,
                            'LoginProvider' => null,
                            'Email' => 'test@test.ru',
                            'Bll' => null,
                        ],
                        'Partner' => [
                            'Id' => 8002,
                            'UserLogin' => $params['PartnerName'],
                            'AvatarBase64' => null,
                            'FirstName' => null,
                            'Surname' => null,
                            'Patronymic' => null,
                            'AllowedPayMethods' => null,
                            'Scoring' => null,
                            'LoginProvider' => null,
                            'Email' => 'test2@test.ru',
                            'Bll' => null,
                        ],
                        'InitiatorRole' => 'Payer',
                        'Status' => 1,
                        'InProgressState' => 0,
                        'Amount' => $this->numberFormat($params['Amount']),
                        'Currency' => 'RUB',
                        'Paymethod' => 'CardsTest',
                        'CommissionsType' => 'Payer',
                        'Terms' => null,
                        'Description' => 'Тестовое описание',
                        'Tags' => [],
                        'DepositInitiator' => $this->numberFormat($params['DepositInitiator']),
                        'DepositPartner' => $this->numberFormat($params['DepositPartner']),
                        'DepositToPayee' => true,
                        'DealDuration' => $params['DealDuration'],
                        'ContractDuration' => $params['ContractDuration'],
                        'CreateDate' => '0001-01-01T00:00:00',
                        'ContractType' => 0,
                        'AllowNewConditions' => false,
                        'PublicContractsCount' => null,
                        'TermTemplateId' => null,
                        'IsContractMember' => false,
                        'Guid' => 'GqmWcr0tEO8zfdIs4xjlw',
                        'ContractAgreementFields' => [],
                        'AgreementFields' => null,
                        'Files' => null,
                        'Transactions' => null,
                        'UnreadMessages' => 0,
                    ],
                    'Error' => null,
                    'ErrorResourceKey' => '0_error_code',
                    'Description' => null,
                    'Advices' => null,
                ]
            );
        }

        return $this->returnError();
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/registration/service-user .
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function registration(RequestInterface $request)
    {
        $checkToken = $this->checkToken();
        if (false === $checkToken) {
            return $this->returnError();
        }
        if (Request::POST === $request->getMethod()) {
            $keys = ['Login', 'Email', 'FirstName', 'Surname', 'Patronymic'];
            $resultValidation = $this->validateKeys($request, $keys);
            if (false === $resultValidation) {
                return $this->returnError();
            }

            return new Response(
                [
                    'IsSuccess' => true,
                    'Code' => 0,
                    'Data' => self::DEFAULT_USER_ID,
                    'Error' => null,
                    'ErrorResourceKey' => '0_error_code',
                    'Description' => null,
                    'Advices' => null,
                ]
            );
        } else {
            return $this->returnError();
        }
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/contracts/{DEFAULT_CONTRACT_ID}/accept.
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function acceptContract(RequestInterface $request)
    {
        $checkToken = $this->checkToken();
        if (false === $checkToken) {
            return $this->returnError();
        }

        return new Response(
            [
                'IsSuccess' => true,
                'Code' => 0,
                'Data' => [
                    'ESC_CONTRACT_ID' => 0,
                    'ESC_USER_ID' => 0,
                    'ESC_SERVICE_ID' => 0,
                    'URL' => 'string',
                    'ContractId' => 0,
                ],
                'Error' => null,
                'ErrorResourceKey' => '0_error_code',
                'Description' => null,
                'Advices' => null,
            ]
        );
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/contracts/{DEFAULT_CONTRACT_ID}/decline.
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function declineContract(RequestInterface $request)
    {
        $keys = ['UserLogin'];
        $resultValidation = $this->validateKeys($request, $keys);
        if (false === $resultValidation) {
            return $this->returnError();
        }

        return new Response(
            [
                'IsSuccess' => true,
                'Code' => 0,
                'Error' => null,
                'ErrorResourceKey' => '0_error_code',
            ]
        );
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/deals/get-by-contractId/{DEFAULT_CONTRACT_ID}.
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function getContract(RequestInterface $request)
    {
        return new Response(
            [
                'IsSuccess' => true,
                'Code' => 0,
                'Data' => [
                    'Id' => self::DEFAULT_DEAL_ID,
                    'ContractId' => self::DEFAULT_CONTRACT_ID,
                    'Transactions' => [
                        0 => [
                            'IsIncome' => true,
                            'ContractId' => self::DEFAULT_CONTRACT_ID,
                            'DealId' => null,
                            'TranId' => '190000000',
                            'UserId' => 11111,
                            'User' => [
                                'Id' => 11111,
                                'UserLogin' => self::DEFAULT_RENTER_LOGIN,
                                'AvatarBase64' => null,
                                'FirstName' => 'FirstNameRenter',
                                'Surname' => 'SecondNameRenter',
                                'Patronymic' => null,
                                'AllowedPayMethods' => [],
                                'Scoring' => [
                                    'SuccessDealsOverallAmount' => 300.0,
                                    'SuccessDealsCount' => 1.0,
                                    'DisputedDealsCount' => 1.0,
                                    'DateOfRegistration' => '2019-10-14T10:07:04.127',
                                    'Score' => 0,
                                ],
                                'LoginProvider' => 'Site',
                                'Email' => 'test@test.ru',
                                'Bll' => null,
                            ],
                            'Amount' => 6000.0,
                            'Currency' => 'RUB',
                            'Purse' => '4100000000000001',
                            'Paymethod' => 'CardsTest',
                            'Status' => 1,
                            'CreateDate' => '2019-10-15T14:41:45.783',
                            'DisplayName' => 'Тестовое предложение',
                        ],
                    ],
                    'ServiceId' => self::DEFAULT_SERVICE_ID,
                    'Name' => 'Тестовое предложение',
                    'Initiator' => [
                        'Id' => 11111,
                        'UserLogin' => self::DEFAULT_RENTER_LOGIN,
                        'AvatarBase64' => null,
                        'FirstName' => null,
                        'Surname' => null,
                        'Patronymic' => null,
                        'AllowedPayMethods' => null,
                        'Scoring' => null,
                        'LoginProvider' => null,
                        'Email' => null,
                        'Bll' => null,
                    ],
                    'Partner' => [
                        'Id' => 22222,
                        'UserLogin' => self::DEFAULT_OWNER_LOGIN,
                        'AvatarBase64' => null,
                        'FirstName' => null,
                        'Surname' => null,
                        'Patronymic' => null,
                        'AllowedPayMethods' => null,
                        'Scoring' => null,
                        'LoginProvider' => null,
                        'Email' => null,
                        'Bll' => null,
                    ],
                    'InitiatorRole' => 'Payer',
                    'Status' => 0,
                    'InProgressState' => 1,
                    'Amount' => 300.0,
                    'Currency' => 'RUB',
                    'Paymethod' => 'CardsTest',
                    'CommissionsType' => 'Payer',
                    'Description' => 'Тестовое описание',
                    'Terms' => null,
                    'Tags' => null,
                    'DepositInitiator' => 300.0,
                    'DepositPartner' => 0.0,
                    'DisputeReason' => null,
                    'DepositToPayee' => true,
                    'Duration' => '2019-12-12T11:29:15.59',
                    'CreateDate' => '2019-10-15T14:41:48.013',
                    'ContractType' => 0,
                    'NeedPayeePurse' => false,
                    'UnreadMessages' => 0,
                ],
                'Error' => null,
                'ErrorResourceKey' => '0_error_code',
                'Description' => null,
                'Advices' => null,
            ]
        );
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/deals/{DEFAULT_DEAL_ID}/open-dispute.
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function openDispute(RequestInterface $request)
    {
        $keys = ['DisputeReason', 'UserLogin'];
        $resultValidation = $this->validateKeys($request, $keys);
        if (false === $resultValidation) {
            return $this->returnError();
        }

        return new Response([
            'IsSuccess' => true,
            'Code' => 0,
            'Data' => [
                'Id' => self::DEFAULT_DEAL_ID,
                'ContractId' => self::DEFAULT_CONTRACT_ID,
                'Transactions' => null,
                'ServiceId' => self::DEFAULT_SERVICE_ID,
                'Name' => 'Тестовое предложение от имени арендатора',
                'Initiator' => [
                    'Id' => 11111,
                    'UserLogin' => self::DEFAULT_RENTER_LOGIN,
                    'AvatarBase64' => null,
                    'FirstName' => null,
                    'Surname' => null,
                    'Patronymic' => null,
                    'AllowedPayMethods' => null,
                    'Scoring' => null,
                    'LoginProvider' => null,
                    'Email' => null,
                    'Bll' => null,
                ],
                'Partner' => [
                    'Id' => 22222,
                    'UserLogin' => self::DEFAULT_OWNER_LOGIN,
                    'AvatarBase64' => null,
                    'FirstName' => null,
                    'Surname' => null,
                    'Patronymic' => null,
                    'AllowedPayMethods' => null,
                    'Scoring' => null,
                    'LoginProvider' => null,
                    'Email' => null,
                    'Bll' => null,
                ],
                'InitiatorRole' => 'Payer',
                'Status' => 2,
                'InProgressState' => 1,
                'Amount' => 300.0,
                'Currency' => 'RUB',
                'Paymethod' => 'CardsTest',
                'CommissionsType' => 'Payer',
                'Description' => 'Тестовое описание',
                'Terms' => null,
                'Tags' => null,
                'DepositInitiator' => 300.0,
                'DepositPartner' => 0.0,
                'DisputeReason' => 'ByInitiator',
                'DepositToPayee' => true,
                'Duration' => '2019-12-12T11:29:15.59',
                'CreateDate' => '2019-10-15T14:41:48.013',
                'ContractType' => 0,
                'NeedPayeePurse' => false,
                'UnreadMessages' => 0,
            ],
            'Error' => null,
            'ErrorResourceKey' => '0_error_code',
            'Description' => null,
            'Advices' => null,
        ]);
    }

    /**
     * Заглушка для запросов по адресу
     * https://guarantee.money/api/deals/{DEFAULT_DEAL_ID}/confirm.
     *
     * @param RequestInterface $request
     *
     * @return Response
     */
    private function confirm(RequestInterface $request)
    {
        return new Response(
            [
                'IsSuccess' => true,
                'Code' => 0,
                'Data' => [
                    'Id' => self::DEFAULT_DEAL_ID,
                    'ContractId' => self::DEFAULT_CONTRACT_ID,
                    'Transactions' => [
                        0 => [
                            'IsIncome' => false,
                            'ContractId' => self::DEFAULT_CONTRACT_ID,
                            'DealId' => self::DEFAULT_DEAL_ID,
                            'TranId' => '200',
                            'UserId' => self::DEFAULT_USER_ID,
                            'User' => [
                                'Id' => self::DEFAULT_USER_ID,
                                'UserLogin' => self::DEFAULT_RENTER_LOGIN,
                                'AvatarBase64' => null,
                                'FirstName' => 'Test',
                                'Surname' => 'Test',
                                'Patronymic' => null,
                                'AllowedPayMethods' => [],
                                'Scoring' => [
                                    'SuccessDealsOverallAmount' => 0.0,
                                    'SuccessDealsCount' => 0.0,
                                    'DisputedDealsCount' => 0.0,
                                    'DateOfRegistration' => '2019-09-24T10:44:05.193',
                                    'Score' => 0,
                                ],
                                'LoginProvider' => 'Site',
                                'Email' => 'renter@test.ru',
                                'Bll' => null,
                            ],
                            'Amount' => 900.0,
                            'Currency' => 'RUB',
                            'Purse' => '1234000022226666',
                            'Paymethod' => 'CardsTest',
                            'Status' => 0,
                            'CreateDate' => '2019-10-17T12:18:26.45',
                            'DisplayName' => 'Тестовое предложение от имени арендатора',
                        ],
                        1 => [
                            'IsIncome' => true,
                            'ContractId' => self::DEFAULT_CONTRACT_ID,
                            'DealId' => null,
                            'TranId' => '200108320',
                            'UserId' => 777777,
                            'User' => [
                                'Id' => 777777,
                                'UserLogin' => self::DEFAULT_OWNER_LOGIN,
                                'AvatarBase64' => null,
                                'FirstName' => 'Тест2',
                                'Surname' => 'Тестов2',
                                'Patronymic' => null,
                                'AllowedPayMethods' => [],
                                'Scoring' => [
                                    'SuccessDealsOverallAmount' => 1200.0,
                                    'SuccessDealsCount' => 2.0,
                                    'DisputedDealsCount' => 2.0,
                                    'DateOfRegistration' => '2019-10-14T10:07:04.127',
                                    'Score' => 0,
                                ],
                                'LoginProvider' => 'Site',
                                'Email' => 'owner@test.ru',
                                'Bll' => null,
                            ],
                            'Amount' => 15120.0,
                            'Currency' => 'RUB',
                            'Purse' => '4100000000000001',
                            'Paymethod' => 'CardsTest',
                            'Status' => 1,
                            'CreateDate' => '2019-10-17T12:15:15.177',
                            'DisplayName' => 'Тестовое предложение от имени арендатора',
                        ],
                    ],
                    'ServiceId' => self::DEFAULT_SERVICE_ID,
                    'Name' => 'Тестовое предложение от имени арендатора',
                    'Initiator' => [
                        'Id' => self::DEFAULT_USER_ID,
                        'UserLogin' => self::DEFAULT_RENTER_LOGIN,
                        'AvatarBase64' => null,
                        'FirstName' => 'Test',
                        'Surname' => 'Test',
                        'Patronymic' => null,
                        'AllowedPayMethods' => [],
                        'Scoring' => [
                            'SuccessDealsOverallAmount' => 1200.0,
                            'SuccessDealsCount' => 2.0,
                            'DisputedDealsCount' => 2.0,
                            'DateOfRegistration' => '2019-10-14T10:07:04.127',
                            'Score' => 0,
                        ],
                        'LoginProvider' => 'Site',
                        'Email' => 'dp@crtweb.ru',
                        'Bll' => null,
                    ],
                    'Partner' => [
                        'Id' => 777777,
                        'UserLogin' => self::DEFAULT_OWNER_LOGIN,
                        'AvatarBase64' => null,
                        'FirstName' => 'Test',
                        'Surname' => 'Test',
                        'Patronymic' => null,
                        'AllowedPayMethods' => [],
                        'Scoring' => [
                            'SuccessDealsOverallAmount' => 0.0,
                            'SuccessDealsCount' => 0.0,
                            'DisputedDealsCount' => 0.0,
                            'DateOfRegistration' => '2019-09-24T10:44:05.193',
                            'Score' => 0,
                        ],
                        'LoginProvider' => 'Site',
                        'Email' => 'test@test.ru',
                        'Bll' => null,
                    ],
                    'InitiatorRole' => 'Payer',
                    'Status' => 9,
                    'InProgressState' => 3,
                    'Amount' => 900.0,
                    'Currency' => 'RUB',
                    'Paymethod' => 'CardsTest',
                    'CommissionsType' => 'Payer',
                    'Description' => 'Тестовое описание',
                    'Terms' => null,
                    'Tags' => null,
                    'DepositInitiator' => 900.0,
                    'DepositPartner' => 0.0,
                    'DisputeReason' => null,
                    'DepositToPayee' => true,
                    'Duration' => '2019-10-20T12:12:53',
                    'CreateDate' => '2019-10-17T12:15:18.52',
                    'ContractType' => 0,
                    'NeedPayeePurse' => false,
                    'UnreadMessages' => 0,
                ],
                'Error' => null,
                'ErrorResourceKey' => '0_error_code',
                'Description' => null,
                'Advices' => null,
            ]
        );
    }

    /**
     * Проверяет что в объекте Response присутствуют все необходимые параметры.
     *
     * @param RequestInterface $request
     * @param                  $keys
     *
     * @return bool
     */
    private function validateKeys(RequestInterface $request, $keys)
    {
        $params = $request->getParams();
        $params = array_merge($params, $request->getData());

        foreach ($keys as $key) {
            if (!array_key_exists($key, $params)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Возвращает ошибку сервиса.
     *
     * @return Response
     */
    private function returnError()
    {
        return new Response(
            [
                'IsSuccess' => false,
                'Code' => 10,
                'Data' => 0,
                'Error' => 'Validation error occurred while adding purse',
                'ErrorResourceKey' => '10_error_code',
                'Description' => 'Пользователь не найден (либо не полные данные по карте)',
                'Advices' => null,
            ]
        );
    }

    /**
     * Форматирует число в формат, возвращаемый сервисом
     *
     * @param $number
     *
     * @return mixed
     *
     * @throws \Exception
     */
    private function numberFormat($number)
    {
        return number_format((float) $number, 1, '.', '');
    }

    /**
     * Проверяет установлен ли токен.
     * Нужно использовать, чтобы на проекте не забыть установить токен.
     *
     * @return bool
     */
    private function checkToken()
    {
        return !is_null($this->token);
    }

    private function calculateDynamic(RequestInterface $request)
    {
        $params = $request->getParams();
        $amount = $params['Amount'];

        return new Response([
            'PayerCommission' => rand($amount / 10, $amount / 3),
            'PayeeCommission' => 0.0,
            'MinAmount' => 10.0,
        ]);
    }
}
