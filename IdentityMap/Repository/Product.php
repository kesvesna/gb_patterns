<?php

declare(strict_types = 1);

namespace Repository;

use Repository\IdentityMap;

class Product
{
    private $storage;

    public function __construct()
    {
        $this->storage = new IdentityMap();
    }
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price']);
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];

        foreach ($this->getDataFromSource() as $item) {
            $productList[] = new Entity\Product($item['id'], $item['name'], $item['price']);
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(int $id)
    {
        return $this->storage->get(get_class($this), $id);
    }

}
