<?php

namespace App\Service;

/**
 * Сервис служит для отправки pdf файла в телеграм
 */
class TelegramService
{
    const CHAT_ID = ''; // Идентификатор чата
    const TOKEN = ''; // Личный токен

    public function sendPDF($order)
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/../files/pdf/'. $order->getId() .'.pdf';

        $arrayQuery = array(
            'chat_id' => self::CHAT_ID,
            'caption' => 'Заказ №' . $order->getId(),
            'document' => curl_file_create($filePath)
        );
        $ch = curl_init('https://api.telegram.org/bot'. self::TOKEN .'/sendDocument');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arrayQuery);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
    }
}