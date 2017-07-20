<?php

$data = [
    ['id' => 1, 'title' => 'Электроника', 'parent_id' => 0, 'goods_count' => 122],
    ['id' => 2, 'title' => 'Бытовая техника', 'parent_id' => 1, 'goods_count' => 0],
    ['id' => 3, 'title' => 'Планшеты SAMSUNG', 'parent_id' => 1, 'goods_count' => 0],
    ['id' => 4, 'title' => 'Самсунг galaxy 1', 'parent_id' => 3, 'goods_count' => 122],
    ['id' => 6, 'title' => 'Самсунг galaxy 2', 'parent_id' => 3, 'goods_count' => 122],
    ['id' => 11, 'title' => 'LG телефоны', 'parent_id' => 1, 'goods_count' => 0],
    ['id' => 12, 'title' => 'LG 12', 'parent_id' => 11, 'goods_count' => 322],
    ['id' => 13, 'title' => 'LG 13', 'parent_id' => 11, 'goods_count' => 322],
    ['id' => 14, 'title' => 'LG 14', 'parent_id' => 11, 'goods_count' => 322],
    ['id' => 15, 'title' => 'LG 15', 'parent_id' => 11, 'goods_count' => 322],
    ['id' => 16, 'title' => 'LG 16', 'parent_id' => 11, 'goods_count' => 322],
    ['id' => 17, 'title' => 'Стиральная машина Б/У', 'parent_id' => 2, 'goods_count' => 1000],
];

$hash_data = [];

foreach ($data as $item) {
    $hash_data[$item['id']] = $item;
}

class Tree
{
    public $tree = [
        0 => [
            'id' => 0,
            'title' => 'MAIN_CATEGORY',
        ]
    ];

    public $categories;

    public $html_tree = "";

    const MAIN_CAT_ID = 0;

    function __construct()
    {
        global $hash_data;

        $this->categories = $hash_data;
        $this->sum_categories = $hash_data;

        $this->full_sum = [];

        $this->createTree($this->tree);
        $this->createTreeHtml();
    }


    public function createCategoryNode($category)
    {
        $this->html_tree .= "<li>{$category['id']} <b>{$category['title']}</b>  {$category['goods_count']}";

        if (!empty($category['children'])) {
            $this->html_tree .= "<ul>";
            foreach ($category['children'] as $subcategory) {
                $this->createCategoryNode($subcategory);
            }
            $this->html_tree .= "</ul>";
        }
        $this->html_tree .= "</li>";
    }


    public function createTreeHtml()
    {

        $this->html_tree .= "<ul>";

        foreach ($this->tree as $category) {
            $this->createCategoryNode($category);
        }

        $this->html_tree .= "</ul>";
    }

    public function updateSum($id, $sum)
    {
        if ($id != self::MAIN_CAT_ID) {
            $this->sum_categories[$id]['goods_count'] += $sum;
        }

        $parent_id = $this->sum_categories[$id]['parent_id'];

        if (!empty($parent_id)) {
            $this->updateSum($parent_id, $sum);
        }
    }

    public function createTree(&$tree)
    {
        if (empty($tree)) return false;

        foreach ($tree as $key => &$tree_cat) {

            foreach ($this->categories as $tk => &$category) {

                if ($tree_cat['id'] == $category['parent_id']) {

                    if ($tree_cat['id'] != self::MAIN_CAT_ID) {
                        $tree_cat['goods_count'] = &$this->sum_categories[$tree_cat['id']]['goods_count'];
                    }

                    if (empty($tree_cat['children'])) {
                        $tree_cat['children'] = [];
                    }

                    $tree_cat['children'][$category['id']] = $category;

                    $this->updateSum($category['parent_id'], $category['goods_count']);

                    unset($this->categories[$tk]);
                }
            }

            if (!empty($tree_cat['children'])) {
                $this->createTree($tree_cat['children']);
            }
        }
    }
}

$tree = new Tree();
print_r($tree->html_tree);

