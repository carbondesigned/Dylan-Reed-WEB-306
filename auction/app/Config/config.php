<?php

date_default_timezone_set("America/Toronto");

const DB_USER = 'dreed';
const DB_PASSWORD = 'qh6xhqh6xh2mtqj2mtqj';
const DB_HOST = 'localhost';
const DB_NAME = 'dreeddb';

const CONFIG_ADMIN = "Dylan Reed";
const CONFIG_ADMINEMAIL = "W0785043@myscc.ca";
const CONFIG_URL = "https://dreed.scweb.ca/WEB306/auction";
const CONFIG_AUCTIONNAME = "Dylan Reed's Auction";
const CONFIG_CURRENCY = "$";


CONST LOG_LOCATION = __DIR__ . "/../../logs/app.log";

const FILE_UPLOADLOC = "imgs/";

const CLIENT_ID = "AV1ty8uHl5po7ixOB7TSF6H2b3T6nomsIZTpoFZE2pFtSMXT9OqXHnk515tGkOTpyDlr_FaEHUEcWQpo";
const CLIENT_SECRET = "EI-AVizMG7c-9DbBxAmUlmVd5gDbRirx9MSb_gu1NiTv-L-LZZCtHWfYVcdSWXOtw1KYXxk-VZMtDRji";
const PAYPAL_CURRECY = "CAD";
const PAYPAL_RETURNURL = CONFIG_URL . "/payment-successful.php";
const PAYPAL_CANCELURL = CONFIG_URL . "/payment-cancelled.php";
