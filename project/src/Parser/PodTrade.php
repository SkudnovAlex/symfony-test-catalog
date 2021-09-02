<?php


namespace App\Parser;


use App\Entity\Category;
use App\Entity\Product;
use Cocur\Slugify\Slugify;
use PHPHtmlParser\Dom;
use stringEncode\Exception;

class PodTrade extends Parser
{
    public string $baseUrl = 'https://podtrade.ru';
    private array $listLinks = [
        '/catalog/01_sharikovye_podshipniki/',
        '/catalog/02_rolikovye_podshipniki/',
    ];
    private string $parentCode = 'bearing';
    private string $parentName = 'Подшибники';
    private int $limitPages = 1;
    private array $listCategories = [];
    private array $listProducts = [];
    private int $parentCategories;


    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function parseListCategories(): array
    {
        $slugify = new Slugify(['lowercase' => true, 'ruleset' => 'russian', 'trim' => true]);
        $dom = new Dom();
        $listCategories = [];

        foreach ($this->listLinks as $category) {
            $dom->loadFromUrl($this->baseUrl . $category)->outerHtml;

            foreach ($dom->find(".bx_catalog_tile_title") as $key => $value) {
                $name = $value->find('a')->text();
                $newCategory = new Category();
                $newCategory->setParent($this->parentCategories);
                $newCategory->setName($name);
                $newCategory->setCode($slugify->slugify($name));

                $listCategories[] = [
                    'id' => $this->em->getRepository(Category::class)->createIfNotExist($newCategory),
                    'href' => $value->find('a')->getAttribute('href'),
                ];
            }
        }

        return $listCategories;
    }

    protected function parseListProducts(): array
    {
        $dom = new Dom();
        $listProducts = [];
        foreach ($this->listCategories as $category) {
            $currentPage = 1;
            while ($this->limitPages >= $currentPage) {
                $dom->loadFromUrl($this->baseUrl . $category['href'] . '?PAGEN_1=' . $currentPage)->outerHtml;

                foreach ($dom->find(".block-view-title") as $value) {
                    $listProducts[$category['id']][] = $value->find('a')->getAttribute('href');
                }
                $currentPage++;
            }
        }
        return $listProducts;
    }

    protected function parseProducts(): void
    {
        $slugify = new Slugify(['lowercase' => true, 'ruleset' => 'russian', 'trim' => true]);
        $dom = new Dom();
        $categoryRepository = $this->em->getRepository(Category::class);

        foreach ($this->listProducts as $categoryId => $linkPages) {
            foreach ($linkPages as $page) {
                $dom->loadFromUrl($this->baseUrl . $page)->outerHtml;

                $name = $dom->find('h1[itemprop="name"]')[0]->text;
                $newProduct = new Product();
                $newProduct->setCategory($categoryRepository->find($categoryId));
                $newProduct->setName($name);
                $newProduct->setCode($slugify->slugify($name));
                $price = preg_replace('/\D+/', '', $dom->getElementsByClass('buy-price')[0]->text);
                $newProduct->setPrice($price ? (int)$price : 0);
                $newProduct->setDescription($dom->find('.detail-tabs-grid .tabs-item[data-tabsourcename="2"]')[0]->innerHtml);
                $this->em->persist($newProduct);
                $this->em->flush();
            }
        }
    }

    public function run(): ?string
    {
        try {
            $this->em->getConnection()->beginTransaction();

            $newCategory = new Category();
            $newCategory->setParent(0);
            $newCategory->setName($this->parentName);
            $newCategory->setCode($this->parentCode);


            $this->parentCategories = $this->em->getRepository(Category::class)->createIfNotExist($newCategory);

            $this->listCategories = $this->parseListCategories();
            $this->listProducts = $this->parseListProducts();
            $this->parseProducts();

            $this->em->getConnection()->commit();

            return null;

        } catch (Exception $e) {
            $this->em->getConnection()->rollBack();

            return $e->getMessage();
        }
    }
}
