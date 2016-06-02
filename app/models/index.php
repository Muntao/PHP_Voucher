<?php

namespace Models;

use core;

require_once 'engine/lib/baseModel.php';

class Index extends core\BaseModel {

    private $vouchers = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];

    function __construct() {
        $success = false;
        $available = false;

        global $request;
        $post = $request->getPostParams();
        //Sprawdzanie czy użytkownik przesłał dane
        $from = '';
        if (isset($post['from'])) {
            $from = $this->cleanVar($post['from']);
        }
        $email = '';
        if (isset($post['email'])) {
            $email = $this->cleanVar($post['email']);
        }
        $amount = '';
        if (isset($post['amount'])) {
            $amount = (integer) $this->cleanVar($post['amount']);
        }
        $to = '';
        if (isset($post['to'])) {
            $to = $this->cleanVar($post['to']);
        }
        $recipient_email = '';
        if (isset($post['recipient_email'])) {
            $recipient_email = (integer) $this->cleanVar($post['recipient_email']);
        }
        $message = '';
        if (isset($post['message'])) {
            $message = $this->cleanVar($post['message']);
        }

        //W przypadku nie przesłania wszsytkich danych forma jest uzupełniana podanymi wartościami.
        //Jeśli wszystko jest ok, następuje zapisanie vouchera do bazy
        if ($this->validFrom($from) && $this->validEmail($email) && $this->validAmount($amount) && $this->validTo($to) && $this->validRecipientEmail($recipient_email)) {

            if ($amount == 100) {
                $available = true;
            }

            $date = date("Y-m-d H:i:s");
            global $database;
            $result = $database->query('INSERT INTO voucher (voucher_from,voucher_email,voucher_recipient,voucher_recipient_email,voucher_message,voucher_date,voucher_value) VALUES ("' . $from . '","' . $email . '", "' . $to . '", "' . $recipient_email . '",'
                    . '"' . $message . '","' . $date . '",' . $amount . ');');
            $success = $result;
        }

        $this->addData('from', $from);
        $this->addData('email', $email);
        $this->addData('to', $to);
        $this->addData('recipient_email', $recipient_email);
        $this->addData('amount', $amount);
        $this->addData('message', $message);


        $this->addData('success', $success);
        $this->addData('available', $available);
        $this->addData('vouchers', $this->vouchers);
    }

    
    //Czyszczenie i walidacji danych
    public function cleanVar($var) {
        return htmlspecialchars(strip_tags($var));
    }

    public function validFrom($v) {

        if (is_string($v) && (strlen($v) < 51) && (strlen($v) > 5)) {
            return true;
        }
        return false;
    }

    public function validEmail($v) {
        if (preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $v) && strlen($v) < 101) {
            return true;
        }
        return false;
    }

    public function validTo($v) {
        if (is_string($v) && strlen($v) < 101) {
            return true;
        }
        return false;
    }

    public function validRecipientEmail($v) {
        if (is_integer($v) && ($v > 0)) {
            return true;
        }
        return false;
    }

    public function validAmount($v) {
        if (is_integer($v) && in_array($v, $this->vouchers)) {
            return true;
        }
        return false;
    }

}
