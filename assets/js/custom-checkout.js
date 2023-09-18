"use strict"

const customMail = document.querySelector('.woocommerce-billing-fields-custom h3');
const sumOrder = document.querySelector('.wcf-order-review-toggle-text');
const customPayment = document.querySelector('#payment_options_heading');
const mailInfo = document.querySelector('.wcf-logged-in-customer-info');
const customCupon = document.querySelector('#wcf_custom_coupon_field');

customCupon.style.display = 'none';

let newMailInfo = mailInfo.textContent;
newMailInfo = newMailInfo.replace('Welcome Back', 'Привіт');
mailInfo.textContent = newMailInfo;

customPayment.textContent = 'Оплата';
sumOrder.textContent = 'Сумма замовлення';
customMail.textContent = 'Email';

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        let customBtn = document.querySelector('#place_order');
		const customForm = document.querySelector('label.woocommerce-form__label span');
        if (customBtn) {
            customBtn.value = 'Підтвердити';
            customBtn.setAttribute('data-value', 'Підтвердити');
            customBtn.textContent = 'Підтвердити';
			customBtn.style.backgroundColor = '#333333';
        }
		if (customForm) {
			customForm.textContent = 'Я хочу отримувати ексклюзивні електронні листи зі знижками та інформацією про продукт';
		}
    }, 20000); // Задержка в 1 секунду (можно изменить значение по вашему усмотрению)
});

function my_thanckyou_page_translate() {
	const orderReceived = document.querySelector('.woocommerce-notice .woocommerce-notice--success .woocommerce-thankyou-order-received');
	orderReceived.textContent = 'Ваше замовлення отримано';
	console.log(orderReceived);
}

my_thanckyou_page_translate();