<?php

if (!class_exists("transferBankCard")) {
/**
 * transferBankCard
 */
class transferBankCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var bankCardTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("authDTO")) {
/**
 * authDTO
 */
class authDTO {
	/**
	 * @access public
	 * @var string
	 */
	public $accountEmail;
	/**
	 * @access public
	 * @var string
	 */
	public $apiName;
	/**
	 * @access public
	 * @var string
	 */
	public $authenticationToken;
	/**
	 * @access public
	 * @var string
	 */
	public $ipAddress;
	/**
	 * @access public
	 * @var string
	 */
	public $systemAccountName;
}}

if (!class_exists("bankCardTransferRequestDTO")) {
/**
 * bankCardTransferRequestDTO
 */
class bankCardTransferRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $cardNumber;
	/**
	 * @access public
	 * @var string
	 */
	public $destCurrency;
	/**
	 * @access public
	 * @var string
	 */
	public $expiryMonth;
	/**
	 * @access public
	 * @var string
	 */
	public $expiryYear;
	/**
	 * @access public
	 * @var boolean
	 */
	public $savePaymentTemplate;
	/**
	 * @access public
	 * @var string
	 */
	public $srcWalletId;
}}

if (!class_exists("transferBankCardResponse")) {
/**
 * transferBankCardResponse
 */
class transferBankCardResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("validateAdvcashCardTransfer")) {
/**
 * validateAdvcashCardTransfer
 */
class validateAdvcashCardTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var advcashCardTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("advcashCardTransferRequestDTO")) {
/**
 * advcashCardTransferRequestDTO
 */
class advcashCardTransferRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var tnscardType
	 */
	public $cardType;
	/**
	 * @access public
	 * @var string
	 */
	public $email;
	/**
	 * @access public
	 * @var boolean
	 */
	public $savePaymentTemplate;
	/**
	 * @access public
	 * @var string
	 */
	public $srcWalletId;
}}

if (!class_exists("validateAdvcashCardTransferResponse")) {
/**
 * validateAdvcashCardTransferResponse
 */
class validateAdvcashCardTransferResponse {
}}

if (!class_exists("findTransaction")) {
/**
 * findTransaction
 */
class findTransaction {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var string
	 */
	public $arg1;
}}

if (!class_exists("findTransactionResponse")) {
/**
 * findTransactionResponse
 */
class findTransactionResponse {
	/**
	 * @access public
	 * @var outcomingTransactionDTO
	 */
	public $return;
}}

if (!class_exists("baseDTO")) {
/**
 * baseDTO
 */
class baseDTO {
	/**
	 * @access public
	 * @var string
	 */
	public $id;
}}

if (!class_exists("validateEmailTransfer")) {
/**
 * validateEmailTransfer
 */
class validateEmailTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var emailTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("emailTransferRequestDTO")) {
/**
 * emailTransferRequestDTO
 */
class emailTransferRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $comment;
	/**
	 * @access public
	 * @var string
	 */
	public $destCurrency;
	/**
	 * @access public
	 * @var string
	 */
	public $email;
	/**
	 * @access public
	 * @var string
	 */
	public $srcWalletId;
}}

if (!class_exists("validateEmailTransferResponse")) {
/**
 * validateEmailTransferResponse
 */
class validateEmailTransferResponse {
}}

if (!class_exists("validationSendMoneyToEcurrency")) {
/**
 * validationSendMoneyToEcurrency
 */
class validationSendMoneyToEcurrency {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var withdrawToEcurrencyRequest
	 */
	public $arg1;
}}

if (!class_exists("moneyRequest")) {
/**
 * moneyRequest
 */
class moneyRequest {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var tnscurrency
	 */
	public $currency;
	/**
	 * @access public
	 * @var string
	 */
	public $note;
	/**
	 * @access public
	 * @var boolean
	 */
	public $savePaymentTemplate;
}}

if (!class_exists("validationSendMoneyToEcurrencyResponse")) {
/**
 * validationSendMoneyToEcurrencyResponse
 */
class validationSendMoneyToEcurrencyResponse {
}}

if (!class_exists("validateAccounts")) {
/**
 * validateAccounts
 */
class validateAccounts {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var string[]
	 */
	public $arg1;
}}

if (!class_exists("validateAccountsResponse")) {
/**
 * validateAccountsResponse
 */
class validateAccountsResponse {
	/**
	 * @access public
	 * @var accountPresentDTO[]
	 */
	public $return;
}}

if (!class_exists("accountPresentDTO")) {
/**
 * accountPresentDTO
 */
class accountPresentDTO {
	/**
	 * @access public
	 * @var boolean
	 */
	public $present;
	/**
	 * @access public
	 * @var string
	 */
	public $systemAccountName;
}}

if (!class_exists("sendMoneyToEcurrency")) {
/**
 * sendMoneyToEcurrency
 */
class sendMoneyToEcurrency {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var withdrawToEcurrencyRequest
	 */
	public $arg1;
}}

if (!class_exists("sendMoneyToEcurrencyResponse")) {
/**
 * sendMoneyToEcurrencyResponse
 */
class sendMoneyToEcurrencyResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("transferAdvcashCard")) {
/**
 * transferAdvcashCard
 */
class transferAdvcashCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var advcashCardTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("transferAdvcashCardResponse")) {
/**
 * transferAdvcashCardResponse
 */
class transferAdvcashCardResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("withdrawalThroughExternalPaymentSystem")) {
/**
 * withdrawalThroughExternalPaymentSystem
 */
class withdrawalThroughExternalPaymentSystem {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var withdrawalThroughExternalPaymentSystemRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("withdrawalThroughExternalPaymentSystemRequestDTO")) {
/**
 * withdrawalThroughExternalPaymentSystemRequestDTO
 */
class withdrawalThroughExternalPaymentSystemRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $comment;
	/**
	 * @access public
	 * @var tnscurrency
	 */
	public $currency;
	/**
	 * @access public
	 * @var tnsexternalSystemWithdrawalType
	 */
	public $externalPaymentSystem;
	/**
	 * @access public
	 * @var string
	 */
	public $receiver;
	/**
	 * @access public
	 * @var boolean
	 */
	public $savePaymentTemplate;
}}

if (!class_exists("withdrawalThroughExternalPaymentSystemResponse")) {
/**
 * withdrawalThroughExternalPaymentSystemResponse
 */
class withdrawalThroughExternalPaymentSystemResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("currencyExchange")) {
/**
 * currencyExchange
 */
class currencyExchange {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var currencyExchangeRequest
	 */
	public $arg1;
}}

if (!class_exists("currencyExchangeRequest")) {
/**
 * currencyExchangeRequest
 */
class currencyExchangeRequest extends moneyRequest {
	/**
	 * @access public
	 * @var tnscurrencyExchangeAction
	 */
	public $action;
	/**
	 * @access public
	 * @var tnscurrency
	 */
	public $from;
	/**
	 * @access public
	 * @var tnscurrency
	 */
	public $to;
}}

if (!class_exists("currencyExchangeResponse")) {
/**
 * currencyExchangeResponse
 */
class currencyExchangeResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("sendMoneyToAdvcashCard")) {
/**
 * sendMoneyToAdvcashCard
 */
class sendMoneyToAdvcashCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var advcashCardTransferRequest
	 */
	public $arg1;
}}

if (!class_exists("advcashCardTransferRequest")) {
/**
 * advcashCardTransferRequest
 */
class advcashCardTransferRequest extends moneyRequest {
	/**
	 * @access public
	 * @var tnscardType
	 */
	public $cardType;
	/**
	 * @access public
	 * @var string
	 */
	public $email;
}}

if (!class_exists("sendMoneyToAdvcashCardResponse")) {
/**
 * sendMoneyToAdvcashCardResponse
 */
class sendMoneyToAdvcashCardResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("sendMoney")) {
/**
 * sendMoney
 */
class sendMoney {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var sendMoneyRequest
	 */
	public $arg1;
}}

if (!class_exists("sendMoneyRequest")) {
/**
 * sendMoneyRequest
 */
class sendMoneyRequest extends moneyRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $email;
}}

if (!class_exists("sendMoneyResponse")) {
/**
 * sendMoneyResponse
 */
class sendMoneyResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("validationSendMoneyToAdvcashCard")) {
/**
 * validationSendMoneyToAdvcashCard
 */
class validationSendMoneyToAdvcashCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var advcashCardTransferRequest
	 */
	public $arg1;
}}

if (!class_exists("validationSendMoneyToAdvcashCardResponse")) {
/**
 * validationSendMoneyToAdvcashCardResponse
 */
class validationSendMoneyToAdvcashCardResponse {
}}

if (!class_exists("validationCurrencyExchange")) {
/**
 * validationCurrencyExchange
 */
class validationCurrencyExchange {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var currencyExchangeRequest
	 */
	public $arg1;
}}

if (!class_exists("validationCurrencyExchangeResponse")) {
/**
 * validationCurrencyExchangeResponse
 */
class validationCurrencyExchangeResponse {
}}

if (!class_exists("emailTransfer")) {
/**
 * emailTransfer
 */
class emailTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var emailTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("emailTransferResponse")) {
/**
 * emailTransferResponse
 */
class emailTransferResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("sendMoneyToEmail")) {
/**
 * sendMoneyToEmail
 */
class sendMoneyToEmail {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var sendMoneyRequest
	 */
	public $arg1;
}}

if (!class_exists("sendMoneyToEmailResponse")) {
/**
 * sendMoneyToEmailResponse
 */
class sendMoneyToEmailResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("validateTransfer")) {
/**
 * validateTransfer
 */
class validateTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var tnstypeOfTransaction
	 */
	public $arg1;
	/**
	 * @access public
	 * @var transferRequestDTO
	 */
	public $arg2;
}}

if (!class_exists("transferRequestDTO")) {
/**
 * transferRequestDTO
 */
class transferRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $comment;
	/**
	 * @access public
	 * @var string
	 */
	public $destWalletId;
	/**
	 * @access public
	 * @var boolean
	 */
	public $savePaymentTemplate;
	/**
	 * @access public
	 * @var string
	 */
	public $srcWalletId;
}}

if (!class_exists("validateTransferResponse")) {
/**
 * validateTransferResponse
 */
class validateTransferResponse {
}}

if (!class_exists("register")) {
/**
 * register
 */
class register {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var registrationRequest
	 */
	public $arg1;
}}

if (!class_exists("registrationRequest")) {
/**
 * registrationRequest
 */
class registrationRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $email;
	/**
	 * @access public
	 * @var string
	 */
	public $firstName;
	/**
	 * @access public
	 * @var string
	 */
	public $ip;
	/**
	 * @access public
	 * @var tnssupportedLanguage
	 */
	public $language;
	/**
	 * @access public
	 * @var string
	 */
	public $lastName;
}}

if (!class_exists("registerResponse")) {
/**
 * registerResponse
 */
class registerResponse {
}}

if (!class_exists("validateAccount")) {
/**
 * validateAccount
 */
class validateAccount {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var validateAccountRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("validateAccountRequestDTO")) {
/**
 * validateAccountRequestDTO
 */
class validateAccountRequestDTO {
	/**
	 * @access public
	 * @var string
	 */
	public $email;
	/**
	 * @access public
	 * @var string
	 */
	public $firstName;
	/**
	 * @access public
	 * @var string
	 */
	public $lastName;
	/**
	 * @access public
	 * @var string
	 */
	public $walletId;
}}

if (!class_exists("validateAccountResponse")) {
/**
 * validateAccountResponse
 */
class validateAccountResponse {
	/**
	 * @access public
	 * @var validateAccountResultDTO
	 */
	public $return;
}}

if (!class_exists("validateAccountResultDTO")) {
/**
 * validateAccountResultDTO
 */
class validateAccountResultDTO extends validateAccountRequestDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $firstNameMatchingPercentage;
	/**
	 * @access public
	 * @var double
	 */
	public $lastNameMatchingPercentage;
}}

if (!class_exists("validationSendMoneyToEmail")) {
/**
 * validationSendMoneyToEmail
 */
class validationSendMoneyToEmail {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var sendMoneyRequest
	 */
	public $arg1;
}}

if (!class_exists("validationSendMoneyToEmailResponse")) {
/**
 * validationSendMoneyToEmailResponse
 */
class validationSendMoneyToEmailResponse {
}}

if (!class_exists("validationSendMoneyToBankCard")) {
/**
 * validationSendMoneyToBankCard
 */
class validationSendMoneyToBankCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var bankCardTransferRequest
	 */
	public $arg1;
}}

if (!class_exists("bankCardTransferRequest")) {
/**
 * bankCardTransferRequest
 */
class bankCardTransferRequest extends moneyRequest {
	/**
	 * @access public
	 * @var string
	 */
	public $cardNumber;
	/**
	 * @access public
	 * @var string
	 */
	public $expiryMonth;
	/**
	 * @access public
	 * @var string
	 */
	public $expiryYear;
}}

if (!class_exists("validationSendMoneyToBankCardResponse")) {
/**
 * validationSendMoneyToBankCardResponse
 */
class validationSendMoneyToBankCardResponse {
}}

if (!class_exists("makeCurrencyExchange")) {
/**
 * makeCurrencyExchange
 */
class makeCurrencyExchange {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var transferRequestDTO
	 */
	public $arg1;
	/**
	 * @access public
	 * @var boolean
	 */
	public $arg2;
}}

if (!class_exists("makeCurrencyExchangeResponse")) {
/**
 * makeCurrencyExchangeResponse
 */
class makeCurrencyExchangeResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("validationSendMoney")) {
/**
 * validationSendMoney
 */
class validationSendMoney {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var sendMoneyRequest
	 */
	public $arg1;
}}

if (!class_exists("validationSendMoneyResponse")) {
/**
 * validationSendMoneyResponse
 */
class validationSendMoneyResponse {
}}

if (!class_exists("validateCurrencyExchange")) {
/**
 * validateCurrencyExchange
 */
class validateCurrencyExchange {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var transferRequestDTO
	 */
	public $arg1;
	/**
	 * @access public
	 * @var boolean
	 */
	public $arg2;
}}

if (!class_exists("validateCurrencyExchangeResponse")) {
/**
 * validateCurrencyExchangeResponse
 */
class validateCurrencyExchangeResponse {
}}

if (!class_exists("validateWithdrawalThroughExternalPaymentSystem")) {
/**
 * validateWithdrawalThroughExternalPaymentSystem
 */
class validateWithdrawalThroughExternalPaymentSystem {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var withdrawalThroughExternalPaymentSystemRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("validateWithdrawalThroughExternalPaymentSystemResponse")) {
/**
 * validateWithdrawalThroughExternalPaymentSystemResponse
 */
class validateWithdrawalThroughExternalPaymentSystemResponse {
}}

if (!class_exists("validateBankCardTransfer")) {
/**
 * validateBankCardTransfer
 */
class validateBankCardTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var bankCardTransferRequestDTO
	 */
	public $arg1;
}}

if (!class_exists("validateBankCardTransferResponse")) {
/**
 * validateBankCardTransferResponse
 */
class validateBankCardTransferResponse {
}}

if (!class_exists("makeTransfer")) {
/**
 * makeTransfer
 */
class makeTransfer {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var tnstypeOfTransaction
	 */
	public $arg1;
	/**
	 * @access public
	 * @var transferRequestDTO
	 */
	public $arg2;
}}

if (!class_exists("makeTransferResponse")) {
/**
 * makeTransferResponse
 */
class makeTransferResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("getBalances")) {
/**
 * getBalances
 */
class getBalances {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
}}

if (!class_exists("getBalancesResponse")) {
/**
 * getBalancesResponse
 */
class getBalancesResponse {
	/**
	 * @access public
	 * @var walletBalanceDTO[]
	 */
	public $return;
}}

if (!class_exists("walletBalanceDTO")) {
/**
 * walletBalanceDTO
 */
class walletBalanceDTO {
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var string
	 */
	public $id;
}}

if (!class_exists("sendMoneyToBankCard")) {
/**
 * sendMoneyToBankCard
 */
class sendMoneyToBankCard {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var bankCardTransferRequest
	 */
	public $arg1;
}}

if (!class_exists("sendMoneyToBankCardResponse")) {
/**
 * sendMoneyToBankCardResponse
 */
class sendMoneyToBankCardResponse {
	/**
	 * @access public
	 * @var string
	 */
	public $return;
}}

if (!class_exists("history")) {
/**
 * history
 */
class history {
	/**
	 * @access public
	 * @var authDTO
	 */
	public $arg0;
	/**
	 * @access public
	 * @var MerchantAPITransactionFilter
	 */
	public $arg1;
}}

if (!class_exists("MerchantAPITransactionFilter")) {
/**
 * MerchantAPITransactionFilter
 */
class MerchantAPITransactionFilter {
	/**
	 * @access public
	 * @var string
	 */
	public $accountName;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $startTimeFrom;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $startTimeTo;
	/**
	 * @access public
	 * @var tnstransactionName
	 */
	public $transactionName;
	/**
	 * @access public
	 * @var tnstransactionStatus
	 */
	public $transactionStatus;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $updatedFrom;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $updatedTo;
	/**
	 * @access public
	 * @var string
	 */
	public $walletId;
}}

if (!class_exists("historyResponse")) {
/**
 * historyResponse
 */
class historyResponse {
	/**
	 * @access public
	 * @var outcomingTransactionDTO[]
	 */
	public $return;
}}

if (!class_exists("exceptionType")) {
/**
 * exceptionType
 */
class exceptionType {
}}

if (!class_exists("currency")) {
/**
 * currency
 */
class currency {
}}

if (!class_exists("cardType")) {
/**
 * cardType
 */
class cardType {
}}

if (!class_exists("transactionStatus")) {
/**
 * transactionStatus
 */
class transactionStatus {
}}

if (!class_exists("transactionName")) {
/**
 * transactionName
 */
class transactionName {
}}

if (!class_exists("verificationStatus")) {
/**
 * verificationStatus
 */
class verificationStatus {
}}

if (!class_exists("ecurrency")) {
/**
 * ecurrency
 */
class ecurrency {
}}

if (!class_exists("externalSystemWithdrawalType")) {
/**
 * externalSystemWithdrawalType
 */
class externalSystemWithdrawalType {
}}

if (!class_exists("currencyExchangeAction")) {
/**
 * currencyExchangeAction
 */
class currencyExchangeAction {
}}

if (!class_exists("typeOfTransaction")) {
/**
 * typeOfTransaction
 */
class typeOfTransaction {
}}

if (!class_exists("supportedLanguage")) {
/**
 * supportedLanguage
 */
class supportedLanguage {
}}

if (!class_exists("NotEnoughMoneyException")) {
/**
 * NotEnoughMoneyException
 */
class NotEnoughMoneyException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("UserBlockedException")) {
/**
 * UserBlockedException
 */
class UserBlockedException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("TransactionIsNotAvailableException")) {
/**
 * TransactionIsNotAvailableException
 */
class TransactionIsNotAvailableException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("LimitPerMonthException")) {
/**
 * LimitPerMonthException
 */
class LimitPerMonthException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("BadParametersException")) {
/**
 * BadParametersException
 */
class BadParametersException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("LimitPerDayException")) {
/**
 * LimitPerDayException
 */
class LimitPerDayException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("MerchantDisabledException")) {
/**
 * MerchantDisabledException
 */
class MerchantDisabledException {
}}

if (!class_exists("NotAuthException")) {
/**
 * NotAuthException
 */
class NotAuthException {
}}

if (!class_exists("WalletDoesNotExist")) {
/**
 * WalletDoesNotExist
 */
class WalletDoesNotExist {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("WrongParamsException")) {
/**
 * WrongParamsException
 */
class WrongParamsException {
}}

if (!class_exists("LimitsException")) {
/**
 * LimitsException
 */
class LimitsException {
}}

if (!class_exists("WrongIpException")) {
/**
 * WrongIpException
 */
class WrongIpException {
}}

if (!class_exists("InternalException")) {
/**
 * InternalException
 */
class InternalException {
}}

if (!class_exists("AccessDeniedException")) {
/**
 * AccessDeniedException
 */
class AccessDeniedException {
}}

if (!class_exists("CardNumberIsNotValidException")) {
/**
 * CardNumberIsNotValidException
 */
class CardNumberIsNotValidException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("TransactionFailureException")) {
/**
 * TransactionFailureException
 */
class TransactionFailureException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("LimitPerTransactionException")) {
/**
 * LimitPerTransactionException
 */
class LimitPerTransactionException {
	/**
	 * @access public
	 * @var double
	 */
	public $maxAmount;
	/**
	 * @access public
	 * @var double
	 */
	public $minAmount;
	/**
	 * @access public
	 * @var tnscurrency
	 */
	public $currency;
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("DatabaseException")) {
/**
 * DatabaseException
 */
class DatabaseException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("UserDoesNotExistException")) {
/**
 * UserDoesNotExistException
 */
class UserDoesNotExistException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("CardIsNotActiveException")) {
/**
 * CardIsNotActiveException
 */
class CardIsNotActiveException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("CardDoesNotExistException")) {
/**
 * CardDoesNotExistException
 */
class CardDoesNotExistException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("CallRestrictionException")) {
/**
 * CallRestrictionException
 */
class CallRestrictionException {
}}

if (!class_exists("EmailAlreadyExistException")) {
/**
 * EmailAlreadyExistException
 */
class EmailAlreadyExistException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("WrongEmailException")) {
/**
 * WrongEmailException
 */
class WrongEmailException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("ExchangeCurrencyException")) {
/**
 * ExchangeCurrencyException
 */
class ExchangeCurrencyException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("ApiException")) {
/**
 * ApiException
 */
class ApiException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("NotEnoughMoneyApiException")) {
/**
 * NotEnoughMoneyApiException
 */
class NotEnoughMoneyApiException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("WalletCurrencyIncorrectException")) {
/**
 * WalletCurrencyIncorrectException
 */
class WalletCurrencyIncorrectException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("RegistrationException")) {
/**
 * RegistrationException
 */
class RegistrationException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("NotSupportedCountryException")) {
/**
 * NotSupportedCountryException
 */
class NotSupportedCountryException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("CodeIsNotValidException")) {
/**
 * CodeIsNotValidException
 */
class CodeIsNotValidException {
	/**
	 * @access public
	 * @var tnsexceptionType
	 */
	public $type;
}}

if (!class_exists("outcomingTransactionDTO")) {
/**
 * outcomingTransactionDTO
 */
class outcomingTransactionDTO extends baseDTO {
	/**
	 * @access public
	 * @var string
	 */
	public $accountName;
	/**
	 * @access public
	 * @var integer
	 */
	public $activityLevel;
	/**
	 * @access public
	 * @var double
	 */
	public $amount;
	/**
	 * @access public
	 * @var double
	 */
	public $amountInUSD;
	/**
	 * @access public
	 * @var string
	 */
	public $comment;
	/**
	 * @access public
	 * @var double
	 */
	public $fullCommission;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $startTime;
	/**
	 * @access public
	 * @var tnstransactionStatus
	 */
	public $status;
	/**
	 * @access public
	 * @var tnstransactionName
	 */
	public $transactionName;
	/**
	 * @access public
	 * @var dateTime
	 */
	public $updatedTime;
	/**
	 * @access public
	 * @var tnsverificationStatus
	 */
	public $verificationStatus;
	/**
	 * @access public
	 * @var string
	 */
	public $walletDestId;
	/**
	 * @access public
	 * @var string
	 */
	public $walletSrcId;
}}

if (!class_exists("withdrawToEcurrencyRequest")) {
/**
 * withdrawToEcurrencyRequest
 */
class withdrawToEcurrencyRequest extends moneyRequest {
	/**
	 * @access public
	 * @var tnsecurrency
	 */
	public $ecurrency;
	/**
	 * @access public
	 * @var string
	 */
	public $receiver;
}}

if (!class_exists("MerchantWebService")) {
/**
 * MerchantWebService
 * @author WSDLInterpreter
 */
class MerchantWebService extends SoapClient {
	/**
	 * Default class map for wsdl=>php
	 * @access private
	 * @var array
	 */
	private static $classmap = array(
		"transferBankCard" => "transferBankCard",
		"authDTO" => "authDTO",
		"bankCardTransferRequestDTO" => "bankCardTransferRequestDTO",
		"transferBankCardResponse" => "transferBankCardResponse",
		"validateAdvcashCardTransfer" => "validateAdvcashCardTransfer",
		"advcashCardTransferRequestDTO" => "advcashCardTransferRequestDTO",
		"validateAdvcashCardTransferResponse" => "validateAdvcashCardTransferResponse",
		"findTransaction" => "findTransaction",
		"findTransactionResponse" => "findTransactionResponse",
		"outcomingTransactionDTO" => "outcomingTransactionDTO",
		"baseDTO" => "baseDTO",
		"validateEmailTransfer" => "validateEmailTransfer",
		"emailTransferRequestDTO" => "emailTransferRequestDTO",
		"validateEmailTransferResponse" => "validateEmailTransferResponse",
		"validationSendMoneyToEcurrency" => "validationSendMoneyToEcurrency",
		"withdrawToEcurrencyRequest" => "withdrawToEcurrencyRequest",
		"moneyRequest" => "moneyRequest",
		"validationSendMoneyToEcurrencyResponse" => "validationSendMoneyToEcurrencyResponse",
		"validateAccounts" => "validateAccounts",
		"validateAccountsResponse" => "validateAccountsResponse",
		"accountPresentDTO" => "accountPresentDTO",
		"sendMoneyToEcurrency" => "sendMoneyToEcurrency",
		"sendMoneyToEcurrencyResponse" => "sendMoneyToEcurrencyResponse",
		"transferAdvcashCard" => "transferAdvcashCard",
		"transferAdvcashCardResponse" => "transferAdvcashCardResponse",
		"withdrawalThroughExternalPaymentSystem" => "withdrawalThroughExternalPaymentSystem",
		"withdrawalThroughExternalPaymentSystemRequestDTO" => "withdrawalThroughExternalPaymentSystemRequestDTO",
		"withdrawalThroughExternalPaymentSystemResponse" => "withdrawalThroughExternalPaymentSystemResponse",
		"currencyExchange" => "currencyExchange",
		"currencyExchangeRequest" => "currencyExchangeRequest",
		"currencyExchangeResponse" => "currencyExchangeResponse",
		"sendMoneyToAdvcashCard" => "sendMoneyToAdvcashCard",
		"advcashCardTransferRequest" => "advcashCardTransferRequest",
		"sendMoneyToAdvcashCardResponse" => "sendMoneyToAdvcashCardResponse",
		"sendMoney" => "sendMoney",
		"sendMoneyRequest" => "sendMoneyRequest",
		"sendMoneyResponse" => "sendMoneyResponse",
		"validationSendMoneyToAdvcashCard" => "validationSendMoneyToAdvcashCard",
		"validationSendMoneyToAdvcashCardResponse" => "validationSendMoneyToAdvcashCardResponse",
		"validationCurrencyExchange" => "validationCurrencyExchange",
		"validationCurrencyExchangeResponse" => "validationCurrencyExchangeResponse",
		"emailTransfer" => "emailTransfer",
		"emailTransferResponse" => "emailTransferResponse",
		"sendMoneyToEmail" => "sendMoneyToEmail",
		"sendMoneyToEmailResponse" => "sendMoneyToEmailResponse",
		"validateTransfer" => "validateTransfer",
		"transferRequestDTO" => "transferRequestDTO",
		"validateTransferResponse" => "validateTransferResponse",
		"register" => "register",
		"registrationRequest" => "registrationRequest",
		"registerResponse" => "registerResponse",
		"validateAccount" => "validateAccount",
		"validateAccountRequestDTO" => "validateAccountRequestDTO",
		"validateAccountResponse" => "validateAccountResponse",
		"validateAccountResultDTO" => "validateAccountResultDTO",
		"validationSendMoneyToEmail" => "validationSendMoneyToEmail",
		"validationSendMoneyToEmailResponse" => "validationSendMoneyToEmailResponse",
		"validationSendMoneyToBankCard" => "validationSendMoneyToBankCard",
		"bankCardTransferRequest" => "bankCardTransferRequest",
		"validationSendMoneyToBankCardResponse" => "validationSendMoneyToBankCardResponse",
		"makeCurrencyExchange" => "makeCurrencyExchange",
		"makeCurrencyExchangeResponse" => "makeCurrencyExchangeResponse",
		"validationSendMoney" => "validationSendMoney",
		"validationSendMoneyResponse" => "validationSendMoneyResponse",
		"validateCurrencyExchange" => "validateCurrencyExchange",
		"validateCurrencyExchangeResponse" => "validateCurrencyExchangeResponse",
		"validateWithdrawalThroughExternalPaymentSystem" => "validateWithdrawalThroughExternalPaymentSystem",
		"validateWithdrawalThroughExternalPaymentSystemResponse" => "validateWithdrawalThroughExternalPaymentSystemResponse",
		"validateBankCardTransfer" => "validateBankCardTransfer",
		"validateBankCardTransferResponse" => "validateBankCardTransferResponse",
		"makeTransfer" => "makeTransfer",
		"makeTransferResponse" => "makeTransferResponse",
		"getBalances" => "getBalances",
		"getBalancesResponse" => "getBalancesResponse",
		"walletBalanceDTO" => "walletBalanceDTO",
		"sendMoneyToBankCard" => "sendMoneyToBankCard",
		"sendMoneyToBankCardResponse" => "sendMoneyToBankCardResponse",
		"history" => "history",
		"MerchantAPITransactionFilter" => "MerchantAPITransactionFilter",
		"historyResponse" => "historyResponse",
		"exceptionType" => "exceptionType",
		"currency" => "currency",
		"cardType" => "cardType",
		"transactionStatus" => "transactionStatus",
		"transactionName" => "transactionName",
		"verificationStatus" => "verificationStatus",
		"ecurrency" => "ecurrency",
		"externalSystemWithdrawalType" => "externalSystemWithdrawalType",
		"currencyExchangeAction" => "currencyExchangeAction",
		"typeOfTransaction" => "typeOfTransaction",
		"supportedLanguage" => "supportedLanguage",
		"NotEnoughMoneyException" => "NotEnoughMoneyException",
		"UserBlockedException" => "UserBlockedException",
		"TransactionIsNotAvailableException" => "TransactionIsNotAvailableException",
		"LimitPerMonthException" => "LimitPerMonthException",
		"BadParametersException" => "BadParametersException",
		"LimitPerDayException" => "LimitPerDayException",
		"MerchantDisabledException" => "MerchantDisabledException",
		"NotAuthException" => "NotAuthException",
		"WalletDoesNotExist" => "WalletDoesNotExist",
		"WrongParamsException" => "WrongParamsException",
		"LimitsException" => "LimitsException",
		"WrongIpException" => "WrongIpException",
		"InternalException" => "InternalException",
		"AccessDeniedException" => "AccessDeniedException",
		"CardNumberIsNotValidException" => "CardNumberIsNotValidException",
		"TransactionFailureException" => "TransactionFailureException",
		"LimitPerTransactionException" => "LimitPerTransactionException",
		"DatabaseException" => "DatabaseException",
		"UserDoesNotExistException" => "UserDoesNotExistException",
		"CardIsNotActiveException" => "CardIsNotActiveException",
		"CardDoesNotExistException" => "CardDoesNotExistException",
		"CallRestrictionException" => "CallRestrictionException",
		"EmailAlreadyExistException" => "EmailAlreadyExistException",
		"WrongEmailException" => "WrongEmailException",
		"ExchangeCurrencyException" => "ExchangeCurrencyException",
		"ApiException" => "ApiException",
		"NotEnoughMoneyApiException" => "NotEnoughMoneyApiException",
		"WalletCurrencyIncorrectException" => "WalletCurrencyIncorrectException",
		"RegistrationException" => "RegistrationException",
		"NotSupportedCountryException" => "NotSupportedCountryException",
		"CodeIsNotValidException" => "CodeIsNotValidException",
	);

	/**
	 * Constructor using wsdl location and options array
	 * @param string $wsdl WSDL location for this service
	 * @param array $options Options for the SoapClient
	 */
	public function __construct($wsdl="https://wallet.advcash.com:8443/wsm/merchantWebService?wsdl", $options=array()) {
		foreach(self::$classmap as $wsdlClassName => $phpClassName) {
		    if(!isset($options['classmap'][$wsdlClassName])) {
		        $options['classmap'][$wsdlClassName] = $phpClassName;
		    }
		}
		$options['location'] = 'https://wallet.advcash.com:8443/wsm/merchantWebService';
		libxml_disable_entity_loader(false);
		parent::__construct($wsdl, $options);
	}

	/**
	 * Checks if an argument list matches against a valid argument type list
	 * @param array $arguments The argument list to check
	 * @param array $validParameters A list of valid argument types
	 * @return boolean true if arguments match against validParameters
	 * @throws Exception invalid function signature message
	 */
	public function _checkArguments($arguments, $validParameters) {
		$variables = "";
		foreach ($arguments as $arg) {
		    $type = gettype($arg);
		    if ($type == "object") {
		        $type = get_class($arg);
		    }
		    $variables .= "(".$type.")";
		}
		if (!in_array($variables, $validParameters)) {
		    throw new Exception("Invalid parameter types: ".str_replace(")(", ", ", $variables));
		}
		return true;
	}

	/**
	 * Service Call: transferBankCard
	 * Parameter options:
	 * (transferBankCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return transferBankCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function transferBankCard($mixed = null) {
		$validParameters = array(
			"(transferBankCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("transferBankCard", $args);
	}


	/**
	 * Service Call: validateAdvcashCardTransfer
	 * Parameter options:
	 * (validateAdvcashCardTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateAdvcashCardTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateAdvcashCardTransfer($mixed = null) {
		$validParameters = array(
			"(validateAdvcashCardTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateAdvcashCardTransfer", $args);
	}


	/**
	 * Service Call: findTransaction
	 * Parameter options:
	 * (findTransaction) parameters
	 * @param mixed,... See function description for parameter options
	 * @return findTransactionResponse
	 * @throws Exception invalid function signature message
	 */
	public function findTransaction($mixed = null) {
		$validParameters = array(
			"(findTransaction)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("findTransaction", $args);
	}


	/**
	 * Service Call: validateEmailTransfer
	 * Parameter options:
	 * (validateEmailTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateEmailTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateEmailTransfer($mixed = null) {
		$validParameters = array(
			"(validateEmailTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateEmailTransfer", $args);
	}


	/**
	 * Service Call: validationSendMoneyToEcurrency
	 * Parameter options:
	 * (validationSendMoneyToEcurrency) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationSendMoneyToEcurrencyResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationSendMoneyToEcurrency($mixed = null) {
		$validParameters = array(
			"(validationSendMoneyToEcurrency)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationSendMoneyToEcurrency", $args);
	}


	/**
	 * Service Call: validateAccounts
	 * Parameter options:
	 * (validateAccounts) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateAccountsResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateAccounts($mixed = null) {
		$validParameters = array(
			"(validateAccounts)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateAccounts", $args);
	}


	/**
	 * Service Call: sendMoneyToEcurrency
	 * Parameter options:
	 * (sendMoneyToEcurrency) parameters
	 * @param mixed,... See function description for parameter options
	 * @return sendMoneyToEcurrencyResponse
	 * @throws Exception invalid function signature message
	 */
	public function sendMoneyToEcurrency($mixed = null) {
		$validParameters = array(
			"(sendMoneyToEcurrency)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("sendMoneyToEcurrency", $args);
	}


	/**
	 * Service Call: transferAdvcashCard
	 * Parameter options:
	 * (transferAdvcashCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return transferAdvcashCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function transferAdvcashCard($mixed = null) {
		$validParameters = array(
			"(transferAdvcashCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("transferAdvcashCard", $args);
	}


	/**
	 * Service Call: withdrawalThroughExternalPaymentSystem
	 * Parameter options:
	 * (withdrawalThroughExternalPaymentSystem) parameters
	 * @param mixed,... See function description for parameter options
	 * @return withdrawalThroughExternalPaymentSystemResponse
	 * @throws Exception invalid function signature message
	 */
	public function withdrawalThroughExternalPaymentSystem($mixed = null) {
		$validParameters = array(
			"(withdrawalThroughExternalPaymentSystem)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("withdrawalThroughExternalPaymentSystem", $args);
	}


	/**
	 * Service Call: currencyExchange
	 * Parameter options:
	 * (currencyExchange) parameters
	 * @param mixed,... See function description for parameter options
	 * @return currencyExchangeResponse
	 * @throws Exception invalid function signature message
	 */
	public function currencyExchange($mixed = null) {
		$validParameters = array(
			"(currencyExchange)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("currencyExchange", $args);
	}


	/**
	 * Service Call: sendMoneyToAdvcashCard
	 * Parameter options:
	 * (sendMoneyToAdvcashCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return sendMoneyToAdvcashCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function sendMoneyToAdvcashCard($mixed = null) {
		$validParameters = array(
			"(sendMoneyToAdvcashCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("sendMoneyToAdvcashCard", $args);
	}


	/**
	 * Service Call: sendMoney
	 * Parameter options:
	 * (sendMoney) parameters
	 * @param mixed,... See function description for parameter options
	 * @return sendMoneyResponse
	 * @throws Exception invalid function signature message
	 */
	public function sendMoney($mixed = null) {
		$validParameters = array(
			"(sendMoney)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("sendMoney", $args);
	}


	/**
	 * Service Call: validationSendMoneyToAdvcashCard
	 * Parameter options:
	 * (validationSendMoneyToAdvcashCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationSendMoneyToAdvcashCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationSendMoneyToAdvcashCard($mixed = null) {
		$validParameters = array(
			"(validationSendMoneyToAdvcashCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationSendMoneyToAdvcashCard", $args);
	}


	/**
	 * Service Call: validationCurrencyExchange
	 * Parameter options:
	 * (validationCurrencyExchange) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationCurrencyExchangeResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationCurrencyExchange($mixed = null) {
		$validParameters = array(
			"(validationCurrencyExchange)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationCurrencyExchange", $args);
	}


	/**
	 * Service Call: emailTransfer
	 * Parameter options:
	 * (emailTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return emailTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function emailTransfer($mixed = null) {
		$validParameters = array(
			"(emailTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("emailTransfer", $args);
	}


	/**
	 * Service Call: sendMoneyToEmail
	 * Parameter options:
	 * (sendMoneyToEmail) parameters
	 * @param mixed,... See function description for parameter options
	 * @return sendMoneyToEmailResponse
	 * @throws Exception invalid function signature message
	 */
	public function sendMoneyToEmail($mixed = null) {
		$validParameters = array(
			"(sendMoneyToEmail)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("sendMoneyToEmail", $args);
	}


	/**
	 * Service Call: validateTransfer
	 * Parameter options:
	 * (validateTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateTransfer($mixed = null) {
		$validParameters = array(
			"(validateTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateTransfer", $args);
	}


	/**
	 * Service Call: register
	 * Parameter options:
	 * (register) parameters
	 * @param mixed,... See function description for parameter options
	 * @return registerResponse
	 * @throws Exception invalid function signature message
	 */
	public function register($mixed = null) {
		$validParameters = array(
			"(register)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("register", $args);
	}


	/**
	 * Service Call: validateAccount
	 * Parameter options:
	 * (validateAccount) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateAccountResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateAccount($mixed = null) {
		$validParameters = array(
			"(validateAccount)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateAccount", $args);
	}


	/**
	 * Service Call: validationSendMoneyToEmail
	 * Parameter options:
	 * (validationSendMoneyToEmail) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationSendMoneyToEmailResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationSendMoneyToEmail($mixed = null) {
		$validParameters = array(
			"(validationSendMoneyToEmail)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationSendMoneyToEmail", $args);
	}


	/**
	 * Service Call: validationSendMoneyToBankCard
	 * Parameter options:
	 * (validationSendMoneyToBankCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationSendMoneyToBankCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationSendMoneyToBankCard($mixed = null) {
		$validParameters = array(
			"(validationSendMoneyToBankCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationSendMoneyToBankCard", $args);
	}


	/**
	 * Service Call: makeCurrencyExchange
	 * Parameter options:
	 * (makeCurrencyExchange) parameters
	 * @param mixed,... See function description for parameter options
	 * @return makeCurrencyExchangeResponse
	 * @throws Exception invalid function signature message
	 */
	public function makeCurrencyExchange($mixed = null) {
		$validParameters = array(
			"(makeCurrencyExchange)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("makeCurrencyExchange", $args);
	}


	/**
	 * Service Call: validationSendMoney
	 * Parameter options:
	 * (validationSendMoney) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validationSendMoneyResponse
	 * @throws Exception invalid function signature message
	 */
	public function validationSendMoney($mixed = null) {
		$validParameters = array(
			"(validationSendMoney)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validationSendMoney", $args);
	}


	/**
	 * Service Call: validateCurrencyExchange
	 * Parameter options:
	 * (validateCurrencyExchange) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateCurrencyExchangeResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateCurrencyExchange($mixed = null) {
		$validParameters = array(
			"(validateCurrencyExchange)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateCurrencyExchange", $args);
	}


	/**
	 * Service Call: validateWithdrawalThroughExternalPaymentSystem
	 * Parameter options:
	 * (validateWithdrawalThroughExternalPaymentSystem) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateWithdrawalThroughExternalPaymentSystemResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateWithdrawalThroughExternalPaymentSystem($mixed = null) {
		$validParameters = array(
			"(validateWithdrawalThroughExternalPaymentSystem)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateWithdrawalThroughExternalPaymentSystem", $args);
	}


	/**
	 * Service Call: validateBankCardTransfer
	 * Parameter options:
	 * (validateBankCardTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return validateBankCardTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function validateBankCardTransfer($mixed = null) {
		$validParameters = array(
			"(validateBankCardTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("validateBankCardTransfer", $args);
	}


	/**
	 * Service Call: makeTransfer
	 * Parameter options:
	 * (makeTransfer) parameters
	 * @param mixed,... See function description for parameter options
	 * @return makeTransferResponse
	 * @throws Exception invalid function signature message
	 */
	public function makeTransfer($mixed = null) {
		$validParameters = array(
			"(makeTransfer)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("makeTransfer", $args);
	}


	/**
	 * Service Call: getBalances
	 * Parameter options:
	 * (getBalances) parameters
	 * @param mixed,... See function description for parameter options
	 * @return getBalancesResponse
	 * @throws Exception invalid function signature message
	 */
	public function getBalances($mixed = null) {
		$validParameters = array(
			"(getBalances)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("getBalances", $args);
	}


	/**
	 * Service Call: sendMoneyToBankCard
	 * Parameter options:
	 * (sendMoneyToBankCard) parameters
	 * @param mixed,... See function description for parameter options
	 * @return sendMoneyToBankCardResponse
	 * @throws Exception invalid function signature message
	 */
	public function sendMoneyToBankCard($mixed = null) {
		$validParameters = array(
			"(sendMoneyToBankCard)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("sendMoneyToBankCard", $args);
	}


	/**
	 * Service Call: history
	 * Parameter options:
	 * (history) parameters
	 * @param mixed,... See function description for parameter options
	 * @return historyResponse
	 * @throws Exception invalid function signature message
	 */
	public function history($mixed = null) {
		$validParameters = array(
			"(history)",
		);
		$args = func_get_args();
		$this->_checkArguments($args, $validParameters);
		return $this->__soapCall("history", $args);
	}

	public function getAuthenticationToken($securityWord) {
	      $gmt = gmdate('Ymd:H');
	      $token = hash("sha256", $securityWord . ':' . $gmt);
	      return $token;
	}

}}

?>