/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define(
    [
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'Magento_Customer/js/model/customer',
        'Magento_Checkout/js/model/place-order',
        'jquery'
    ],
    function (quote, urlBuilder, customer, placeOrderService, $) {
        'use strict';

        return function (paymentData, messageContainer) {
            var serviceUrl, payload;

            if (paymentData['extension_attributes'] === undefined) {
                paymentData['extension_attributes'] = {};
            }

            paymentData['extension_attributes']['comment'] = $('[name="sf_comment"]').val();

            payload = {
                cartId: quote.getQuoteId(),
                billingAddress: quote.billingAddress(),
                paymentMethod: paymentData
            };

            if (customer.isLoggedIn()) {
                serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
            } else {
                serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                    quoteId: quote.getQuoteId()
                });
                payload.email = quote.guestEmail;
            }

            return placeOrderService(serviceUrl, payload, messageContainer);
        };
    }
);