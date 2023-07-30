<?php

namespace App\Modules;

use App\Controller\BaseController;
use App\Entity\Color;
use App\Entity\DefaultData;
use App\Entity\DoorAccessories;
use App\Entity\DoorHeight;
use App\Entity\DoorWidth;
use App\Entity\FilmColor;
use App\Entity\HandleColor;
use App\Entity\Order;
use App\Entity\OrderAccessories;
use App\Service\PDFService;
use App\Service\TelegramService;
use mysql_xdevapi\Exception;

/**
 * Модуль для обработки данных о заказе
 */
class ConfiguratorModule extends BaseController
{

    public function processing($data, $doorAccessories)
    {
        if (!$data && !$doorAccessories) {
            throw new Exception('Data not found');
        }

        if (!$data) {
            $data = [];
        }

        $order = $this->saveOrder($data, $doorAccessories);
        $this->generatePdf($order);

    }

    public function saveOrder($data, $doorAccessories)
    {
        $defaultData = $this->em->getRepository(DefaultData::class)->find(1);
        $price = $defaultData->getPrice();

        $order = new Order();
        $order->setDateCreated(new \DateTime());
        if (array_key_exists('doorColor', $data) && $data['doorColor']) {
            $color = $this->em->getRepository(Color::class)->find($data['doorColor']);
            $order->setColor($color);
            $price += $color->getPrice();
        }
        if (array_key_exists('doorHeight', $data) && $data['doorHeight']) {
            $doorHeight = $this->em->getRepository(DoorHeight::class)->find($data['doorHeight']);
            $order->setDoorHeight($doorHeight);
            $price += $doorHeight->getPrice();
        }
        if (array_key_exists('doorWidth', $data) && $data['doorWidth']) {
            $doorWidth = $this->em->getRepository(DoorWidth::class)->find($data['doorWidth']);
            $order->setDoorWidth($doorWidth);
            $price += $doorWidth->getPrice();
        }
        if (array_key_exists('filmColor', $data) && $data['filmColor']) {
            $filmColor = $this->em->getRepository(FilmColor::class)->find($data['filmColor']);
            $order->setFilmColor($filmColor);
            $price += $filmColor->getPrice();
        }
        if (array_key_exists('handleColor', $data) && $data['handleColor']) {
            $handleColor = $this->em->getRepository(HandleColor::class)->find($data['handleColor']);
            $order->setHandleColor($handleColor);
            $price += $handleColor->getPrice();
        }

        if ($doorAccessories) {
            $doorAccessories = $this->em->getRepository(DoorAccessories::class)->findBy(['id' => $doorAccessories]);
            foreach ($doorAccessories as $doorAccessory) {
                $orderAccessory = new OrderAccessories();
                $orderAccessory->setOrder($order)
                    ->setDoorAccessories($doorAccessory);
                $this->em->persist($orderAccessory);
                $price += $doorAccessory->getPrice();
            }
        }

        $dealerPrice = $price * $defaultData->getCoefficient();

        $order->setDealerPrice($dealerPrice);
        $order->setPrice($price);

        $this->em->persist($order);
        $this->em->flush();



        return $order;
    }

    public function generatePdf($order)
    {

        try {
            $data = $this->getPdfData($order);
            $this->sc->get(PDFService::class)->generatePDF($data);
            $this->sc->get(TelegramService::class)->sendPDF($order);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return true;
    }

    public function getPdfData($order)
    {
        $data = [];

        $orderAccessories = $this->em->getRepository(OrderAccessories::class)->findBy(['order' => $order]);
        $accessoryNames = [];
        foreach ($orderAccessories as $item) {
            $accessoryNames[] = $item->getDoorAccessories()->getName();
        }
        $accessoryNames = implode(', ', $accessoryNames);
        $data = [
            'order' => $order,
            'color' => $order->getColor(),
            'accessoryNames' => $accessoryNames,
            'doorHeight' => $order->getDoorHeight(),
            'doorWidth' => $order->getDoorWidth(),
            'filmColor' => $order->getFilmColor(),
            'handleColor' => $order->getHandleColor(),
        ];

        return $data;
    }

    public function getDoorImages()
    {
        $images = [];
        $pathForImages = '../public/image/door/';
        $imageNames = scandir($pathForImages);

        unset($imageNames[0]);
        unset($imageNames[1]);
        if ($imageNames) {
            foreach ($imageNames as $imageName) {
                $imagePath = '/image/door/' . $imageName;
                $images[] = $imagePath;
            }
        }
        return $images;
    }
}