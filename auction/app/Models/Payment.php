<?php

namespace App\Models;
use App\Lib\Model;

class Payment extends Model
{
    protected static string $table_name = 'payments';
    protected int $id;
    protected string $txn_id;
    protected float $mc_gross;
    protected string $payment_status;
    protected int $item_number;
    protected string $item_name;
    protected string $payer_id;
    protected string $payer_email;
    protected string $full_name;
    protected string $address_street;
    protected string $address_city;
    protected string $address_state;
    protected string $address_zip;
    protected string $address_country;
    protected string $payment_date;

    public static function generatePayment(int $id): string {
       $url = CONFIG_URL . "payment.php?id=$id";
       $PayPalButton = <<<HEREDOC_
<a href="{$url}">
   <img src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" alt="Paypal - the Safer, easier way to pay online" border="0"/> 
</a>
HEREDOC_;
         return $PayPalButton;
    }

    public function __construct(
        string $txn_id,
        float $mc_gross,
        string $payment_status,
        int $item_number,
        string $item_name,
        string $payer_id,
        string $payer_email,
        string $full_name,
        string $address_street,
        string $address_city,
        string $address_state,
        string $address_zip,
        string $address_country,
        string $payment_date
    ) {
        $this->txn_id = $txn_id;
        $this->mc_gross = $mc_gross;
        $this->payment_status = $payment_status;
        $this->item_number = $item_number;
        $this->item_name = $item_name;
        $this->payer_id = $payer_id;
        $this->payer_email = $payer_email;
        $this->full_name = $full_name;
        $this->address_street = $address_street;
        $this->address_city = $address_city;
        $this->address_state = $address_state;
        $this->address_zip = $address_zip;
        $this->address_country = $address_country;
        $this->payment_date = $payment_date;
    }
}