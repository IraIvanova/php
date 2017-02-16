<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Entity\News;
use MyShop\DefaultBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{

    /**
     * @Template()
     */
    public function addNewsAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);

        {
            $form->handleRequest($request);

            if ($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($news);
                $manager->flush();

                return $this->redirectToRoute("myshop.news_list");
            }
        }
        

        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Template()
     */
    public function editNewsAction(Request $request, $id)
    {
        $news= $this->getDoctrine()->getRepository("MyShopDefaultBundle:News")->find($id);
        $form= $this->createForm(NewsType::class, $news);

        if($form->isSubmitted())
        {
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($news);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.news_list");
        }
        return [
            "form"=> $form->createView(),
            "news"=> $news
        ];
    }

    public function deleteNewsAction($id)
    {
        $news=$this->getDoctrine()->getRepository("MyShopDefaultBundle:News")->find($id);

        $manager= $this->getDoctrine()->getManager();
        $manager->remove($news);
        $manager->flush();

        return $this->redirectToRoute("my_shop_admin.news_list");
    }

    /**
     * @Template()
     */
    public function listAction()
    {

        $newsList = $this->getDoctrine()->getRepository("MyShopDefaultBundle:News")->findAll();
/*
        dump($newsList);die;
        0 => News {#338 ▼
        -id: 6
        -title: "New shirts!Wow!"
        -shortDescription: "Short description"
        -content: "ContentContentContentContentContentContentContentContentContent"
        -datePublished: DateTime {#335 ▶}
            -newsCategory: null
            -photos: PersistentCollection {#359 ▶}
            }
  1 => News {#362 ▼
                -id: 7
                -title: "New shirts!Wow!"
                -shortDescription: "50% discount only for 2 days?"
                -content: "zxccdsxfdsf"
                -datePublished: DateTime {#361 ▶}
                    -newsCategory: null
                    -photos: PersistentCollection {#363 ▼
                        -snapshot: []
                        -owner: News {#362}
                            -association: array:15 [ …15]
      -em: EntityManager {#266 …11}
                                -backRefFieldName: "news"
                                -typeClass: ClassMetadata {#340 …}
                                    -isDirty: false
                                    #collection: ArrayCollection {#364 ▼
                                    -elements: []
      }
      #initialized: false
    }
  }

$em=$this->getDoctrine()->getManager();
        dump($em->getRepository('MyShopDefaultBundle:News'));die;
NewsRepository {#309 ▼
  #_entityName: "MyShop\DefaultBundle\Entity\News"
  #_em: EntityManager {#266 …11}
  #_class: ClassMetadata {#280 ▼
    +name: "MyShop\DefaultBundle\Entity\News"
    +namespace: "MyShop\DefaultBundle\Entity"
    +rootEntityName: "MyShop\DefaultBundle\Entity\News"
    +customGeneratorDefinition: null
    +customRepositoryClassName: "MyShop\DefaultBundle\Repository\NewsRepository"
    +isMappedSuperclass: false
    +isEmbeddedClass: false
    +parentClasses: []
    +subClasses: []
    +embeddedClasses: []
    +namedQueries: []
    +namedNativeQueries: []
    +sqlResultSetMappings: []
    +identifier: array:1 [▼
      0 => "id"
    ]
    +inheritanceType: 1
    +generatorType: 4
    +fieldMappings: array:5 [▼
      "id" => array:9 [▼
        "fieldName" => "id"
        "type" => "integer"
        "scale" => 0
        "length" => null
        "unique" => false
        "nullable" => false
        "precision" => 0
        "columnName" => "id"
        "id" => true
      ]
      "title" => array:8 [▼
        "fieldName" => "title"
        "type" => "string"
        "scale" => 0
        "length" => 255
        "unique" => false
        "nullable" => false
        "precision" => 0
        "columnName" => "title"
      ]
      "shortDescription" => array:8 [▶]
      "content" => array:8 [▶]
      "datePublished" => array:8 [▶]
    ]
    +fieldNames: array:5 [▼
      "id" => "id"
      "title" => "title"
      "shortDescription" => "shortDescription"
      "content" => "content"
      "datePublished" => "datePublished"
    ]
    +columnNames: array:5 [▼
      "id" => "id"
      "title" => "title"
      "shortDescription" => "shortDescription"
      "content" => "content"
      "datePublished" => "datePublished"
    ]
    +discriminatorValue: null
    +discriminatorMap: []
    +discriminatorColumn: null
    +table: array:1 [▼
      "name" => "news"
    ]
    +lifecycleCallbacks: []
    +entityListeners: []
    +associationMappings: array:2 [▼
      "newsCategory" => array:19 [▼
        "fieldName" => "newsCategory"
        "joinColumns" => array:1 [▼
          0 => array:6 [▼
            "name" => "id_newsCategory"
            "unique" => false
            "nullable" => true
            "onDelete" => null
            "columnDefinition" => null
            "referencedColumnName" => "id"
          ]
        ]
        "cascade" => []
        "inversedBy" => "newsList"
        "targetEntity" => "MyShop\DefaultBundle\Entity\NewsCategory"
        "fetch" => 2
        "type" => 2
        "mappedBy" => null
        "isOwningSide" => true
        "sourceEntity" => "MyShop\DefaultBundle\Entity\News"
        "isCascadeRemove" => false
        "isCascadePersist" => false
        "isCascadeRefresh" => false
        "isCascadeMerge" => false
        "isCascadeDetach" => false
        "sourceToTargetKeyColumns" => array:1 [▼
          "id_newsCategory" => "id"
        ]
        "joinColumnFieldNames" => array:1 [▼
          "id_newsCategory" => "id_newsCategory"
        ]
        "targetToSourceKeyColumns" => array:1 [▼
          "id" => "id_newsCategory"
        ]
        "orphanRemoval" => false
      ]
      "photos" => array:15 [▼
        "fieldName" => "photos"
        "mappedBy" => "news"
        "targetEntity" => "MyShop\DefaultBundle\Entity\NewsPhoto"
        "cascade" => []
        "orphanRemoval" => false
        "fetch" => 2
        "type" => 4
        "inversedBy" => null
        "isOwningSide" => false
        "sourceEntity" => "MyShop\DefaultBundle\Entity\News"
        "isCascadeRemove" => false
        "isCascadePersist" => false
        "isCascadeRefresh" => false
        "isCascadeMerge" => false
        "isCascadeDetach" => false
      ]
    ]
    +isIdentifierComposite: false
    +containsForeignIdentifier: false
    +idGenerator: IdentityGenerator {#290 ▶}
    +sequenceGeneratorDefinition: null
    +tableGeneratorDefinition: null
    +changeTrackingPolicy: 1
    +isVersioned: null
    +versionField: null
    +cache: null
    +reflClass: ReflectionClass {#288 ▶}
    +isReadOnly: false
    #namingStrategy: UnderscoreNamingStrategy {#252 ▶}
    +reflFields: array:7 [▼
      "id" => ReflectionProperty {#282 ▶}
      "title" => ReflectionProperty {#287 ▶}
      "shortDescription" => ReflectionProperty {#286 ▶}
      "content" => ReflectionProperty {#285 ▶}
      "datePublished" => ReflectionProperty {#303 ▶}
      "newsCategory" => ReflectionProperty {#307 ▶}
      "photos" => ReflectionProperty {#308 ▶}
    ]
    -instantiator: Instantiator {#281}
  }
}
*/
        return [
            "newsList"=> $newsList
        ];
    }
}
