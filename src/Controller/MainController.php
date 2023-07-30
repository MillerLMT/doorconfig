<?php

namespace App\Controller;

use App\Entity\Color;
use App\Entity\DefaultData;
use App\Entity\DoorAccessories;
use App\Entity\DoorHeight;
use App\Entity\DoorWidth;
use App\Entity\FilmColor;
use App\Entity\HandleColor;
use App\Entity\Order;
use App\Modules\ConfiguratorModule;
use App\Service\TelegramService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/main")
 */
class MainController extends BaseController
{
    /**
     * @Route("/index", name="main")
     * @Template()
     */
    public function indexAction()
    {
        $colors = $this->em->getRepository(Color::class)->findAll();
        $doorHeights = $this->em->getRepository(DoorHeight::class)->findAll();
        $doorWidths = $this->em->getRepository(DoorWidth::class)->findAll();
        $filmColors = $this->em->getRepository(FilmColor::class)->findAll();
        $handleColors = $this->em->getRepository(HandleColor::class)->findAll();
        $doorAccessories = $this->em->getRepository(DoorAccessories::class)->findAll();
        $defaultData = $this->em->getRepository(DefaultData::class)->find(1);

        return [
            'colors' => $colors,
            'doorHeights' => $doorHeights,
            'doorWidths' => $doorWidths,
            'filmColors' => $filmColors,
            'handleColors' => $handleColors,
            'doorAccessories' => $doorAccessories,
            'defaultData' => $defaultData,
            'doorImages' => $this->sc->get(ConfiguratorModule::class)->getDoorImages(),
        ];
    }

    /**
     * @Route("/send", name="send")
     * @Template()
     *
     * @param Request $request
     */
    public function sendAction(Request $request)
    {
        $data = $request->get('data');
        $doorAccessories = $request->get('doorAccessories');

        $this->sc->get(ConfiguratorModule::class)->processing($data, $doorAccessories);

        return $this->redirect('index');
    }

    /**
     * Служит для повторной генерации и отправки старого заказа
     * Пример: /main/generate?id=123
     *
     * @Route("/generate", name="generate")
     * @Template()
     *
     * @param Request $request
     */
    public function generateOldPdf(Request $request)
    {
       if ($id = $request->get('id')) {
           $order = $this->em->getRepository(Order::class)->find($id);
           $this->sc->get(ConfiguratorModule::class)->generatePdf($order);
       } else {
           throw new \Exception('Data not found');
       }
        return $this->redirect('index');
    }

}