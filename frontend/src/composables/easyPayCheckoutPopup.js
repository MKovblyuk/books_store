import { startCheckout } from "@easypaypt/checkout-sdk";
import axios from "axios";
import { ref } from "vue";

export function useEasyPayCheckoutPopup() {
    let checkoutInstance;
    const successfulPaymentInteraction = ref(false);
    const errors = ref();

    async function getCheckoutManifest(paymentData)
    {
        try {
            const response = await axios.post('/orders/createOnlinePaymentOrder', paymentData);
            initEasypayCheckoutSDK(response.data);
        } catch(e) {
            if (e.response.status == 422) {
                errors.value = e.response.data.errors;
            }
        }
    }

    function onCheckoutClose()
    {
        if (successfulPaymentInteraction.value) {
            checkoutInstance.unmount()
        }
    }

    function onCheckoutSuccess(successInfo) {
        successfulPaymentInteraction.value = true
    }

    function onCheckoutError()
    {
        checkoutInstance.unmount()
        alert('checkout error');
    }

    function initEasypayCheckoutSDK(manifest)
    {
        let config = {
            onSuccess: onCheckoutSuccess,
            onClose: onCheckoutClose,
            onError: onCheckoutError,
            language: 'en',
            logoUrl:
            sessionStorage.getItem('logoUrl') === 'true'
                ? 'https://easypay-cdn-delivery.s3.eu-central-1.amazonaws.com/emails/easypay_logo.svg'
                : '',
            testing: true,
            display: 'popup',
        }

        for (const key of Object.keys(sessionStorage)) {
            const item = sessionStorage.getItem(key)
            if (item === 'true' || item === 'false') {
            if (key !== 'logoUrl') {
                config[key] = item === 'true'
            }
            } else if (['inputBorderRadius', 'buttonBorderRadius', 'baseFontSize'].includes(key)) {
            config[key] = parseInt(item)
            } else {
            config[key] = item
            }
        }

        checkoutInstance = startCheckout(manifest, config)
    }

    async function setIframeUrl(callback) {
        sessionStorage.setItem('iframeUrl', 'https://pay.sandbox.easypay.pt');
        await callback();
    }

    function createOnlinePaymentOrder(paymentData)
    {
        createPopupButton();

        setIframeUrl(async () => await getCheckoutManifest(paymentData))
            .then(() => document.getElementById('easypay-checkout').click());
    }

    function createPopupButton()
    {
        if (!document.getElementById('easypay-checkout')) {
            const button = document.createElement('button');
            button.id = 'easypay-checkout';
            button.hidden = true;
            document.body.appendChild(button);
        }
    }

    return {createOnlinePaymentOrder, errors, successfulPaymentInteraction}
}