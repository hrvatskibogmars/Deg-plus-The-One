<?php

/**
 * Created by PhpStorm.
 * User: vilimstubican
 * Date: 08/07/16
 * Time: 18:03
 */
class OPGSearch
{
    private $category = 0;
    private $page = 1;
    private $perPage = 12;

    private $arguments = [];

    public function search()
    {
        $this->initArguments();

        $this->initCategoryArguments();

        $query = new WP_User_Query( $this->arguments );
        return $query->get_results();
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



    private function initArguments()
    {
        $this->arguments = [
            'role' => 'Korisnik',
            'meta_key' => 'opg',
            'meta_value' => '1'
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

    public static function getCategories()
    {
        $terms = get_terms( 'kategorija', array(
            'hide_empty' => false,
        ) );


        return $terms;
    }

}