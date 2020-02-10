<?php 

if(!defined('NO')) define('NO', 0);
if(!defined('YES')) define('YES', 1);

if(!defined('PROVIDER_NOT_ACTIVE')) define('PROVIDER_NOT_ACTIVE', 0);
if(!defined('PROVIDER_ACTIVE')) define('PROVIDER_ACTIVE', 1);

if(!defined('EMAIL_NOT_VERIFIED')) define('EMAIL_NOT_VERIFIED', 0);
if(!defined('EMAIL_VERIFIED')) define('EMAIL_VERIFIED', 1);

if(!defined('APPROVED')) define('APPROVED', 1);
if(!defined('DECLINED')) define('DECLINED', 0);

if(!defined('DEFAULT_TRUE')) define('DEFAULT_TRUE', true);
if(!defined('DEFAULT_FALSE')) define('DEFAULT_FALSE', false);

if(!defined('ADMIN')) define('ADMIN', 'admin');
if(!defined('USER')) define('USER', 'user');
if(!defined('PROVIDER')) define('PROVIDER', 'provider');

if(!defined('USER_EMAIL_VERIFIED')) define('USER_EMAIL_VERIFIED', 1);
if(!defined('USER_EMAIL_NOT_VERIFIED')) define('USER_EMAIL_NOT_VERIFIED', 0);

if(!defined('USER_DECLINED')) define('USER_DECLINED',0);
if(!defined('USER_APPROVED')) define('USER_APPROVED', 1);
if(!defined('USER_PENDING')) define('USER_PENDING', 2);

if(!defined('PROVIDER_EMAIL_VERIFIED')) define('PROVIDER_EMAIL_VERIFIED', 1);
if(!defined('PROVIDER_EMAIL_NOT_VERIFIED')) define('PROVIDER_EMAIL_NOT_VERIFIED', 0);

if(!defined('PROVIDER_DECLINED')) define('PROVIDER_DECLINED',0);
if(!defined('PROVIDER_APPROVED')) define('PROVIDER_APPROVED', 1);
if(!defined('PROVIDER_PENDING')) define('PROVIDER_PENDING', 2);

if(!defined('SPACE_DECLINED')) define('SPACE_DECLINED',0);
if(!defined('SPACE_APPROVED')) define('SPACE_APPROVED', 1);
if(!defined('SPACE_PENDING')) define('SPACE_PENDING', 2);


if(!defined('COMPLETED')) define('COMPLETED', 1);
if(!defined('DECLINED')) define('DECLINED', 0);

if(!defined('COD')) define('COD', 'cod');
if(!defined('PAID')) define('PAID',1);


if(!defined('NOT_ACTIVE')) define('NOT_ACTIVE', 0);
if(!defined('ACTIVE')) define('ACTIVE', 1);

if(!defined('NOT_VERIFIED')) define('NOT_VERIFIED', 0);
if(!defined('VERIFIED')) define('VERIFIED', 1);

if(!defined('ADMIN_SPACE_NOT_VERIFIED')) define('ADMIN_SPACE_NOT_VERIFIED', 0);
if(!defined('ADMIN_SPACE_VERIFIED')) define('ADMIN_SPACE_VERIFIED', 1);

if(!defined('ADMIN_SPACE_NOT_APPROVED')) define('ADMIN_SPACE_NOT_APPROVED', 0);
if(!defined('ADMIN_SPACE_APPROVED')) define('ADMIN_SPACE_APPROVED', 1);

if(!defined('SPACE_OWNER_NOT_PUBLISHED')) define('SPACE_OWNER_NOT_PUBLISHED', 0);
if(!defined('SPACE_OWNER_PUBLISHED')) define('SPACE_OWNER_PUBLISHED', 1);

if(!defined('BOOKING_INITIATE')) define('BOOKING_INITIATE', 0);
if(!defined('BOOKING_ONPROGRESS')) define('BOOKING_ONPROGRESS', 1);
if(!defined('BOOKING_WAITING_FOR_PAYMENT')) define('BOOKING_WAITING_FOR_PAYMENT', 2);
if(!defined('BOOKING_PAYMENT_DONE')) define('BOOKING_PAYMENT_DONE', 3);
if(!defined('BOOKING_CANCELLED_BY_USER')) define('BOOKING_CANCELLED_BY_USER', 4);
if(!defined('BOOKING_CANCELLED_BY_PROVIDER')) define('BOOKING_CANCELLED_BY_PROVIDER', 5);
if(!defined('BOOKING_COMPLETED')) define('BOOKING_COMPLETED', 6);
if(!defined('BOOKING_REFUND_INITIATED')) define('BOOKING_REFUND_INITIATED', 7);
if(!defined('BOOKING_CHECKIN')) define('BOOKING_CHECKIN', 8);
if(!defined('BOOKING_CHECKOUT')) define('BOOKING_CHECKOUT', 9);
if(!defined('BOOKING_REVIEW_DONE')) define('BOOKING_REVIEW_DONE', 10);
if(!defined('BOOKING_APPROVED_BY_PROVIDER')) define('BOOKING_APPROVED_BY_PROVIDER', 11);
if(!defined('BOOKING_REJECTED_BY_PROVIDER')) define('BOOKING_REJECTED_BY_PROVIDER', 12);


if(!defined('SPACE_TYPE')) define('SPACE_TYPE', 'space_type');


if(!defined('OWN_SPACE')) define('OWN_SPACE', 'Own Space');
if(!defined('PRIVATE_SPACE')) define('PRIVATE_SPACE', 'Private Space');
if(!defined('OFFICE_SPACE')) define('OFFICE_SPACE', 'Office Space');
if(!defined('SHARED_SPACE')) define('SHARED_SPACE', 'Shared Space');

if(!defined('PAYMENT_NOT_PAID')) define('PAYMENT_NOT_PAID', 0);
if(!defined('PAYMENT_PAID')) define('PAYMENT_PAID', 1);
if(!defined('PAYMENT_CANCELLED')) define('PAYMENT_CANCELLED', 2);
