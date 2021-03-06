<?php

namespace Banklink\Protocol\iPizzaLatvia;

/**
 * List of all services available via iPizza
 *
 * @author Roman Marintsenko <inoryy@gmail.com>
 * @since  10.01.2012
 */
final class Services
{
    // Used for latvian SEB
    const IB_AUTHENTICATE_REQUEST = '0005';
    const IB_AUTHENTICATE_SUCCESS = '0001';
    const IB_AUTHENTICATE_DENIED = '0008';
    // Requests
    const PAYMENT_REQUEST      = '1002';
    const AUTHENTICATE_REQUEST = '4001';

    // Responses
    const PAYMENT_SUCCESS      = '1101';
    const PAYMENT_CANCEL       = '1901';
    const PAYMENT_ERROR        = '1901';
    const AUTHENTICATE_SUCCESS = '3002';

    /**
     * Fetch mandatory fields for a given service
     *
     * @param string $serviceId
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function getFieldsForService($serviceId)
    {
        switch ($serviceId) {
            case Services::IB_AUTHENTICATE_REQUEST:
                return array(
                    FieldsIB::SELLER_ID,    // IB_SND_ID
                    FieldsIB::SERVICE_ID,   // IB_SERVICE
                    FieldsIB::USER_LANG     // IB_LANG
                );
            case Services::IB_AUTHENTICATE_DENIED:
                return array(
                    FieldsIB::SELLER_ID,    // IB_SND_ID
                    FieldsIB::SERVICE_ID,   // IB_SERVICE
                    FieldsIB::USER_LANG     // IB_LANG
                );
            case Services::IB_AUTHENTICATE_SUCCESS:
                return array(
                    FieldsIB::SELLER_ID,            // IB_SND_ID
                    FieldsIB::SERVICE_ID,           // IB_SERVICE
                    FieldsIB::SELLER_ID_RESPONSE,   // IB_REC_ID Beneficiary’s identifier – constant AAA
                    FieldsIB::VK_USER,              // IB_USER
                    FieldsIB::VK_DATE,              // IB_DATE
                    FieldsIB::VK_TIME,              // IB_TIME
                    FieldsIB::VK_USER_INFO,         // IB_USER_INFO
                    FieldsIB::PROTOCOL_VERSION      // IB_VERSION
                    /// Parameters IB_CRC, IB_LANG and IB_FROM_SERVER are not
                    /// used in e‐signature generation process
                );
            case Services::PAYMENT_REQUEST:
                return array(
                    Fields::SERVICE_ID,         // VK_SERVICE
                    Fields::PROTOCOL_VERSION,   // VK_VERSION
                    Fields::SELLER_ID,          // VK_SND_ID
                    Fields::ORDER_ID,           // VK_STAMP
                    Fields::SUM,                // VK_AMOUNT
                    Fields::CURRENCY,           // VK_CURR
                    Fields::ORDER_REFERENCE,    // VK_REF
                    Fields::DESCRIPTION,        // VK_MSG
                );
            case Services::PAYMENT_SUCCESS:
                return array(
                    Fields::SERVICE_ID,                 // VK_SERVICE
                    Fields::PROTOCOL_VERSION,           // VK_VERSION
                    Fields::SELLER_ID,                  // VK_SND_ID
                    Fields::SELLER_ID_RESPONSE,         // VK_REC_ID
                    Fields::ORDER_ID,                   // VK_STAMP
                    Fields::TRANSACTION_ID,             // VK_T_NO
                    Fields::SUM,                        // VK_AMOUNT
                    Fields::CURRENCY,                   // VK_CURR
                    Fields::SELLER_BANK_ACC_RESPONSE,   // VK_REC_ACC
                    Fields::SELLER_NAME_RESPONSE,       // VK_REC_NAME
                    Fields::SENDER_BANK_ACC,            // VK_SND_ACC
                    Fields::SENDER_NAME,                // VK_SND_NAME
                    Fields::ORDER_REFERENCE,            // VK_REF
                    Fields::DESCRIPTION,                // VK_MSG
                    Fields::TRANSACTION_DATE,           // VK_T_DATE
                );
            case Services::PAYMENT_CANCEL:
                return array(
                    Fields::SERVICE_ID,         // VK_SERVICE
                    Fields::PROTOCOL_VERSION,   // VK_VERSION
                    Fields::SELLER_ID,          // VK_SND_ID
                    Fields::SELLER_ID_RESPONSE, // VK_REC_ID
                    Fields::ORDER_ID,           // VK_STAMP
                    Fields::ORDER_REFERENCE,    // VK_REF
                    Fields::DESCRIPTION,        // VK_MSG
                );
            case Services::AUTHENTICATE_REQUEST:
                return array(
                    Fields::SERVICE_ID,         // VK_SERVICE
                    Fields::PROTOCOL_VERSION,   // VK_VERSION
                    Fields::SELLER_ID,          // VK_SND_ID
                    Fields::VK_REPLY,           // VK_REPLY
                    Fields::SUCCESS_URL,        // VK_RETURN
                    Fields::VK_DATE,            // VK_DATE
                    Fields::VK_TIME,             // VK_TIME
                );

            case Services::AUTHENTICATE_SUCCESS:
                return array(
                    Fields::SERVICE_ID,         // VK_SERVICE
                    Fields::PROTOCOL_VERSION,   // VK_VERSION
                    Fields::VK_USER,            // VK_USER
                    Fields::VK_DATE,            // VK_DATE
                    Fields::VK_TIME,            // VK_TIME
                    Fields::SELLER_ID,          // VK_SND_ID
                    Fields::VK_INFO,            // VK_INFO
                );
            default:
                throw new \InvalidArgumentException('Unsupported service id: '.$serviceId);
        }
    }

    /**
     * Fetch supported payment services
     *
     * @return array
     */
    public static function getPaymentServices()
    {
        return array(
            self::PAYMENT_REQUEST,
            self::PAYMENT_SUCCESS, 
            self::PAYMENT_CANCEL,
            self::PAYMENT_ERROR
        );
    }

    /**
     * Fetch supported authentication services
     *
     * @return array
     */
    public static function getAuthenticationServices()
    {
        return array(
            self::AUTHENTICATE_REQUEST,
            self::AUTHENTICATE_SUCCESS,
            self::IB_AUTHENTICATE_SUCCESS,
            self::IB_AUTHENTICATE_REQUEST
        );
    }

    public static function getDeclinedServices()
    {
        return [
            self::IB_AUTHENTICATE_DENIED
        ];
    }

    /**
     * Can't instantiate this class
     */
    private function __construct() {}
}
