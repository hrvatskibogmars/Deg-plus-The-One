<?php

/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 14:58
 */
class ProductsSearch
{
    const PRICE_ASC     = "ASC";
    const PRICE_DESC    = "DESC";

    private $category = 0;
    private $opg = 0;
    private $page = 1;
    private $perPage = 12;
    private $order = self::PRICE_ASC;


    private $arguments = [];

    public function search()
    {
        $this->initArguments();

        $this->initCategoryArguments();

        $this->initOPGArguments();

        $this->initOrderArguments();

        $query = new WP_Query( $this->arguments );
        return $query->get_posts();
    }

    private function initOrderArguments()
    {
        $this->arguments['orderby'] = 'meta_value_num';
        $this->arguments['order']   = $this->order;
        $this->arguments['meta_key']= 'price';
    }

    private function initCategoryArguments()
    {
        if($this->category == 0) {
            return;
        }
        if(!is_array($this->category)) {
            $this->category = array($this->category);
        }

        $this->arguments['tax_query'] = array(
            array(
                'taxonomy' => 'kategorija',
                'field'    => 'slug',
                'terms'    => $this->category,
            ),
        );
    }

    private function initOPGArguments()
    {
        if($this->opg == 0) {
            return;
        }
        if(!is_array($this->opg)) {
            $this->opg = array($this->opg);
        }

        $this->arguments['author__in'] = $this->opg;
    }

    private function initArguments()
    {
        $this->arguments = [
            "post_type" => "product",
            "page" => $this->page,
            "posts_per_page" => $this->perPage,
            "post_status" => "publish"
        ];
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @param mixed $opg
     */
    public function setOpg($opg)
    {
        $this->opg = $opg;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @param mixed $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }


    public function getOPGs()
    {
        $query = new WP_User_Query(
            [
                'role' => 'Korisnik',
                'meta_key' => 'opg',
                'meta_value' => "1",
                'meta_compare' => "="
            ]
        );

        $users = $query->get_results();

        $output = [];

        foreach($users as $user) {
            /**
             * @var $user WP_User
             */
            $output[$user->ID] = get_user_meta($user->ID, 'name', true);
        }

        return $output;
    }

}