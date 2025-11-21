<?php

namespace MiniOrange\TwoFA\Api;

/**
 * Headless API Interface
 */
interface HeadlessApiInterface
{
    /**
     * Sends an OTP (One-Time Password) for authentication.
     *
     * @param string $username The username or identifier of the recipient.
     * @param string $phone The phone number of the recipient.
     * @param string $authType The type of authentication.
     * @return array An array containing the result of the operation.
     */
    public function sendOtpApi(string $username, string $phone, string $authType): array;

    /**
     * Validates the provided OTP (One-Time Password).
     *
     * @param string $username The username of the user.
     * @param string $authType The type of authentication.
     * @param string $otp The OTP (One-Time Password).
     * @return array An array containing the result of the operation.
     */
    public function validateOtpApi(string $username, string $authType, string $otp): array;

    /**
     * Sends an OTP (One-Time Password) for authentication.
     *
     * @param string $username The username or identifier of the recipient.
     * @param string $phone The phone number of the recipient.
     * @param string $authType The type of authentication.
     * @param string $validApiKey The valid API key.
     * @return array An array containing the result of the operation.
     */
    public function sendOtp(string $username, string $phone, string $authType, string $validApiKey): array;

    /**
     * Authenticates using the provided credentials.
     *
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @param string $validApiKey The valid API key.
     * @return array An array containing the result of the operation.
     */
    public function authenticateApi(string $username, string $password, string $validApiKey): array;

    /**
     * Logs in using the provided credentials and OTP.
     *
     * @param string $username The username of the user.
     * @param string $validApiKey The valid API key.
     * @param string $authType The type of authentication.
     * @param string $transactionID The transaction ID.
     * @param string $otp The OTP (One-Time Password).
     * @return array An array containing the result of the operation.
     */
    public function loginApi(string $username, string $validApiKey, string $authType, string $transactionID, string $otp): array;

    /**
     * Validates the provided OTP (One-Time Password).
     *
     * @param string $username The username of the user.
     * @param string $validApiKey The valid API key.
     * @param string $authType The type of authentication.
     * @param string $transactionID The transaction ID.
     * @param string $otp The OTP (One-Time Password).
     * @return array An array containing the result of the operation.
     */
    public function validateOtp(string $username, string $validApiKey, string $authType, string $transactionID, string $otp): array;

    /**
     * Validates SMS OTP with phone and country code.
     *
     * @param string $email The email of the user.
     * @param string $action_method The action method (e.g., 'OOS').
     * @param string $savestep The save step (e.g., 'OOS').
     * @param string $phone The phone number.
     * @param string $countrycode The country code.
     * @param string $Passcode The OTP passcode.
     * @return array An array containing the result of the operation.
     */
    public function validateSMSOtpApi(
        string $email,
        string $action_method,
        string $savestep,
        string $phone,
        string $countrycode,
        string $Passcode
    ): array;
}
