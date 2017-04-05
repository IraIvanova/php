<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Entity\Category;
use MyShop\DefaultBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{


    /**
     * @Template()
     */
    public function addAction(Request $request, $idParent= null)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            if ($idParent !== null)
            {
                $parentCat = $this->getDoctrine()->getManager()->getRepository("MyShopDefaultBundle:Category")->find($idParent);
                $category->setParentCategory($parentCat);
            }
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.category_list", ["idParentCategory"=> $idParent]);
        }

        return ["form" => $form->createView(),
            "idParent" => $idParent];
    }

   /**
    * @Template()
    */
public function treeAction()
{
    $categoryList= $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->findAll();
    $jsonArray = [];

foreach($categoryList as $cat){
  if($cat->getParentCategory() !== null){
      $idParent= $cat->getParentCategory()->getId();
  }
  else{
      $idParent = "#";
  }
   $jsonArray[]=[
       "id"=>$cat->getId(),
       "parent" =>$idParent,
       "text" => $cat->getName()
   ];
}  

$jsonCode = json_encode($jsonArray);

    return [
        "categoryListJson" => $jsonCode
    ];
}


 /**
    * @Template()
    */
public function listAction($idParentCategory = null)
{
    $manager =$this->getDoctrine()->getManager();
     $listData= [];

     if(is_null($idParentCategory)){
      
        $listData["categoryList"]= $manager->createQuery("select cat from MyShopDefaultBundle:Category cat where cat.parentCategory is null")->getResult();
     }
     else{
$parentCategory = $manager->getRepository("MyShopDefaultBundle:Category")->find($idParentCategory);
$listData["categoryList"]= $parentCategory->getChildrenCategories();
$listData["parentCategory"] = $parentCategory;
     }
     
return  $listData;
}



    /**
     * @Template()
     */
public function editAction(Request $request,$id)
{
    $category= $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->find($id);
$idParent = $category->getParentCategory()->getId();
$form = $this->createForm(CategoryType::class, $category);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.category_list", ["idParentCategory"=> $idParent]);
        }

        return ["form" => $form->createView(),
            "category" => $category];


}

public function deleteAction(Request $request,$id)
 {
$category = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->find($id);
$manager=$this->getDoctrine()->getManager();
$manager->remove($category);
$manager->flush();

return $this->redirectToRoute("my_shop_admin.category_list");

 }
   
  
    /**
     * @Template()
     */
  /*  public function listAction()
    {
        $categoryList = $this->getDoctrine()
            ->getManager()
            ->createQuery("select hello from MyShopDefaultBundle:Category hello where hello.parentCategory is null")
            ->getResult();

        return ["categoryList" => $categoryList];
    }*/

}

