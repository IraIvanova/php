<?php

namespace MyShop\AdminBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadingProductController extends Controller
{
    /**
     * @Template()
     */
    public function importProductsAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('csv_file', FileType::class, ['label' => "Choose Csv file"])
            ->getForm();

        $form->handleRequest($request);

        if ($request->isMethod("POST"))
        {
            $data = $form->getData();
            /**@var UploadedFile $csvFile*/
            $csvFile = $data['csv_file'];

            $this->get('myshop_admin.product_import_export')->parseCcvData($csvFile->getRealPath());
            $this->addFlash("success", "Данные успешно добавлены в базу!");
        }

        return ['form' => $form->createView()];
    }

    public function exportProductAction()
    {
        $csvData = $this->get("myshop_admin.product_import_export")->exportProduct();
        $response = new Response($csvData);
        $response->headers->set("Content-disposition", "attachment;filename=products_".date("d.m.Y_H:i:s").".csv");
        return $response;
    }
}
