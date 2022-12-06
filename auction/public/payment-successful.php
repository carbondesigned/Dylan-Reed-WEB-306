<?php
require_once(__DIR__ . "/../app/bootstrap.php");

use App\Lib\Logger;
use App\Models\Payment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

$approvedOrderId = $_GET['token'];

$request = new OrdersCaptureRequest($approvedOrderId);
$request->prefer('return=representation');

try {
    $response = $client->execute($request);

    $item_number = $response->result->purchase_units[0]->items[0]->sku;
    $item_name = $response->result->purchase_units[0]->items[0]->name;

    // transaction info
    $paidTo = $response->result->purchase_units[0]->payee->email_address;
    $payment_gross = $response->result->purchase_units[0]->amount->value;
    $currency_code = $response->result->purchase_units[0]->amount->currency_code;
    $payment_status = $response->result->purchase_units[0]->payments->captures[0]->status;
    $txn_id = $response->result->purchase_units[0]->payments->captures[0]->id;
    $date_obj = DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $response->result->purchase_units[0]->payments->captures[0]->create_time);
    $payment_date = $date_obj->format('Y-m-d H:i:s');

    // payer info
    $payer_id = $response->result->payer->payer_id;
    $payer_email = $response->result->payer->email_address;

    // shipping info
    $full_name = $response->result->purchase_units[0]->shipping->name->full_name;
    $addressStreet = $response->result->purchase_units[0]->shipping->address->address_line_1;
    $addressCity = $response->result->purchase_units[0]->shipping->address->admin_area_2;
    $addressProvince = $response->result->purchase_units[0]->shipping->address->admin_area_1;
    $addressPostal = $response->result->purchase_units[0]->shipping->address->postal_code;
    $addressCountry = $response->result->purchase_units[0]->shipping->address->country_code;

    $payment = new Payment(
        $item_number,
        $item_name,
        $paidTo,
        $payment_gross,
        $currency_code,
        $payment_status,
        $txn_id,
        $payment_date,
        $payer_id,
        $payer_email,
        $full_name,
        $addressStreet,
        $addressCity,
        $addressProvince,
        $addressPostal,
        $addressCountry
    );

    $result = $payment->create();

    if ($result) {
        Logger::getLogger()->debug("Paypal: payment has been made & successfully saved to database");
    } else {
        Logger::getLogger()->alert("Paypal: payment has been made but failed to save to database");
    }

require(__DIR__ . "/../app/Layouts/header.php");

echo <<<RECEIPTPAYMENT
    <h1>Payment Successful</h1>
    <p>Your payment was successful.</p>
    <p>Thank you for your purchase!</p>

    <h2>Payment Details</h2>
<table cellpadding="5">
    <tr>
        <td>Item Number:</td>
        <td>{$item_number}</td>
    </tr>
    <tr>
        <td>Item Name:</td>
        <td>{$item_name}</td>
    </tr>
    <tr>
        <td>Payment Gross:</td>
        <td>{$payment_gross}</td>
    </tr>
    <tr>
        <td>Payment Status:</td>
        <td>{$payment_status}</td>
    </tr>
    <tr>
        <td>Transaction ID:</td>
        <td>{$txn_id}</td>
    </tr>
    <tr>
        <td>Payment Date:</td>
        <td>{$payment_date}</td>
    </tr>
</table>
RECEIPTPAYMENT;

require(__DIR__ . "/../app/Layouts/footer.php");

} catch (Exception $e) {
    Logger::getLogger()->critical("Error capturing order: ", ['exception' => $e]);
    echo "Error capturing order";
    die();
}
